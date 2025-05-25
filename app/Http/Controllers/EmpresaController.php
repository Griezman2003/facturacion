<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmpresaController extends Controller
{
    public function crear(){
        return view('empresa.crearEmpresa');
    }
    
    public function empresa(Request $request)
    {
        if (!Auth::check()) {
            return back()->with(['mensajeError' => 'No se pudo identificar al usuario autenticado.']);
        }
    
        $request->validate([
            'nombreEmpresa' => 'required|string|max:255',
            'rfcEmpresa' => 'required|string|max:13|unique:empresas,rfc',
            'catalogoPreinstalado' => 'nullable|string',
            'estructura' => 'nullable|string|max:255',
            'valores' => 'required|in:numericos,alfanumericos',
            'servidorBDD' => 'required|string|max:255',
            'baseDatos' => 'required|string|max:100|unique:empresas,baseDatos',
            'TipoPeriodo' => 'required|in:Mensual,Trimestral,Anual',
            'PeriodosEjercicio' => 'required|numeric|min:1|max:12',
        ], [
            'nombreEmpresa.required' => 'El nombre de la empresa es obligatorio.',
            'rfcEmpresa.required' => 'El RFC de la empresa es obligatorio.',
            'rfcEmpresa.unique' => 'El RFC ingresado ya existe.',
            'baseDatos.required' => 'El nombre de la base de datos es obligatorio.',
            'baseDatos.unique' => 'El nombre de la base de datos ya está en uso.',
            'valores.in' => 'El valor debe ser "numéricos" o "alfanuméricos".',
            'TipoPeriodo.in' => 'El tipo de periodo debe ser "Mensual", "Trimestral" o "Anual".',
        ]);
        
        $datos = $request->all();
    
        try {
            $databaseName = $datos['baseDatos'];
            $result = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$databaseName]);
    
            if (count($result) > 0) {
                return back()->with([
                    'mensajeError' => 'La base de datos "' . $databaseName . '" ya existe.',
                ]);
            }
    
            DB::statement("CREATE DATABASE `" . $databaseName . "`");
        } catch (\Exception $e) {
            return back()->with([
                'mensajeError' => 'No se pudo crear la base de datos: ' . $e->getMessage(),
            ]);
        }
    
        try {
            Empresa::create([
                'nombre' => $datos['nombreEmpresa'],
                'rfc' => $datos['rfcEmpresa'],
                'servidorBDD' => $datos['servidorBDD'],
                'baseDatos' => $datos['baseDatos'],
                'catalogo_preinstalado' => $datos['catalogoPreinstalado'] ?? null,
                'estructura' => $datos['estructura'] ?? null,
                'valores' => $datos['valores'],
                'tipo_periodo' => $datos['TipoPeriodo'],
                'periodos_ejercicio' => $datos['PeriodosEjercicio'],
                'periodos_abiertos' => $request->has('periodosAbiertos'),
                'user_id' => Auth::id(),
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'mensajeError' => 'No se pudo guardar la empresa: ' . $e->getMessage(),
            ]);
        }
    
        return redirect()->route('dashboard.index')->with([
            'mensaje' => 'Empresa creada y base de datos configurada correctamente.',
        ]);
    }
    
}
