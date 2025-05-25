<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Models\Folio;

class facturaController extends Controller
{
    
    public function CadenaSAT(){
        $longitud = 300;
        $cadena = '';
        for ($i=0; $i < $longitud ; $i++) { 
            (rand(0,1) ===0) 
            ?
            $cadena .= chr(rand(65,90))
            : 
            $cadena .= chr(rand(97, 122));
        }
        return $cadena;
    }
    
    public function cadenaEmisor(){
        $longitud = 300;
        $cadena = '';
        for ($i=0; $i < $longitud; $i++) { 
            (rand(0,1) ===0) 
            ?
            $cadena .= chr(rand(65,90))
            : 
            $cadena .= chr(rand(97, 122));
        }
        return $cadena;
    }
    
    public function cadenaTimbre(){
        $longitud = 300;
        $cadena = '';
        for ($i=0; $i < $longitud; $i++) { 
            if(rand(0,1) ===0){
                $cadena .= chr(rand(65,90));
            }else{
                $cadena .= chr(rand(97, 122));
            }
        }
        return $cadena;
    }
    
    public function claveUnidad(){
        $json = storage_path('../json/ClaveUnidad.json');
        $jsonClave = file_get_contents($json);
        $claveUnidad = json_decode($jsonClave, false);
        $clave = array_slice($claveUnidad, 0, 40000);
        $claveFilter = array_map(function($array_new) {
            return (object) [
                'id' => $array_new -> id,
                'nombre' => $array_new -> nombre
            ];
        }, $clave);
        return $claveFilter;
    }
    
    
    
    public function filterProduct(){
        $filtro = \storage_path('../json/ClaveProdServ.json');
        $contentJson= \file_get_contents($filtro);
        $Prod = \json_decode($contentJson, false);
        $Prod = array_slice($Prod, 0, 20000);
        $resultado = array_map(function($item) {
            return (object) [
                'id' => $item ->id,
                'descripcion' => $item -> descripcion
            ];
        }, $Prod);
        return $resultado;
    }
    
    public function generateSat(){
        $longitud = 20;
        $numeroRandom = '';
        for ($i = 0; $i < $longitud; $i++) {
            $numeroRandom .= rand(0, 1);
        }
        $numeroRandom = str_pad($numeroRandom, $longitud, '0');
        return $numeroRandom;
    }
    public function obtenerFolio(Request $request)
    {
        $serie = $request->query('serie');
        
        if (!$serie) {
            return response()->json(['error' => 'Serie no proporcionada'], 400);
        }
        
        $folio = Folio::obtenerSiguienteFolio($serie);
        
        return response()->json(['folio' => $folio]);
    }
    
    // Incrementar el folio después de generar una factura
    public function incrementarFolio(Request $request)
    {
        $serie = $request->input('serie');
        
        if (!$serie) {
            return response()->json(['error' => 'Serie no proporcionada'], 400);
        }
        
        $folio = Folio::incrementarFolio($serie);
        
        return response()->json(['folio' => $folio]);
    }
    
    
    
    public function formaPago(){ 
        $json_formaPago = \storage_path('../json/FormaPago.json');
        $FormaPago = \file_get_contents($json_formaPago);
        $array_formaPago = \json_decode($FormaPago, false);
        return $array_formaPago;
    }
    
    public function regimenFiscal(){
        $json = storage_path('../json/RegimenFiscal.json');
        $contenido_json = file_get_contents($json);
        $array_json = json_decode($contenido_json, true);
        return $array_json;
    }
    
    public function metodoPago(){
        $jsonMetodo_Pago = storage_path('../json/MetodoPago.json');
        $contenido_Metodo_pago = file_get_contents($jsonMetodo_Pago);
        $Metodo_pago = json_decode($contenido_Metodo_pago, false);
        return $Metodo_pago;
    }
    
    public function usoCFDI(){
        $json  = storage_path ('../json/UsoCFDI.json');
        $contenido_json = file_get_contents($json);
        $array_json = json_decode($contenido_json, false);
        return $array_json;
    }
    
    
    public function index(Request $request){
        $formaPago = $this->formaPago();
        $regimenFiscal = $this->regimenFiscal();
        $metodoPago = $this->metodoPago();
        $usoCFDI = $this->usoCFDI();
        $ProdServ = $this-> filterProduct();
        $claveUnidad = $this->claveUnidad();
        $cadenaSAT = $this->CadenaSAT();
        return view('page.factura', compact('regimenFiscal','metodoPago', 'formaPago', 'usoCFDI','ProdServ', 'claveUnidad', 'cadenaSAT'));
    }
    
    public function recibo()
    {
        $regimenFiscal = $this->regimenFiscal();
        $sat = $this ->generateSat();
        $dato = session('dato');
        $cadenaSAT = $this->CadenaSAT();
        $cadenaEmisor = $this->cadenaEmisor();
        $cadenaTimbre = $this->cadenaTimbre();
        return view('page.recibo', compact('dato', 'sat','regimenFiscal','cadenaSAT','cadenaEmisor', 'cadenaTimbre'));
    }
    
    public function facturar (Request $request){  
        $dato = $request->all();
        return redirect()->route('facturas.recibo')->with(['dato' => $dato, 'mensaje' => 'Factura generada correctamente']);
        
    }
    
}
