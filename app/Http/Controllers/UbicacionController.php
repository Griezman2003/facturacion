<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UbicacionController extends Controller
{
    
    private $apiUrl = "https://api.tau.com.mx/dipomex/v1";
    private $apiKey = "8351bb12fd99ef094d28d895409d418e0f733e8b"; 

    public function getEstados()
    {
        $response = Http::withHeaders([
            'APIKEY' => $this->apiKey
        ])->get("{$this->apiUrl}/estados");

        return response()->json($response->json());
    }

    public function getMunicipios($estado_nombre)
    {
        $estados = Http::withHeaders([
            'APIKEY' => $this->apiKey
        ])->get("{$this->apiUrl}/estados")->json();
    
        $estado = collect($estados['estados'])->firstWhere('ESTADO', $estado_nombre);
        if (!$estado) {
            return response()->json(['municipios' => []]);
        }
    
        $response = Http::withHeaders([
            'APIKEY' => $this->apiKey
        ])->get("{$this->apiUrl}/municipios", [
            'id_estado' => $estado['ESTADO_ID']
        ]);
    
        return response()->json($response->json());
    }
    

    public function getColonias($estado_nombre, $municipio_nombre)
{
    $estados = Http::withHeaders([
        'APIKEY' => $this->apiKey
    ])->get("{$this->apiUrl}/estados")->json();

    $estado = collect($estados['estados'])->firstWhere('ESTADO', $estado_nombre);
    if (!$estado) {
        return response()->json(['colonias' => []]);
    }

    $municipios = Http::withHeaders([
        'APIKEY' => $this->apiKey
    ])->get("{$this->apiUrl}/municipios", [
        'id_estado' => $estado['ESTADO_ID']
    ])->json();

    $municipio = collect($municipios['municipios'])->firstWhere('MUNICIPIO', $municipio_nombre);
    if (!$municipio) {
        return response()->json(['colonias' => []]);
    }

    $response = Http::withHeaders([
        'APIKEY' => $this->apiKey
    ])->get("{$this->apiUrl}/colonias", [
        'id_estado' => $estado['ESTADO_ID'],
        'id_mun' => $municipio['MUNICIPIO_ID']
    ]);

    return response()->json($response->json());
}

}
        