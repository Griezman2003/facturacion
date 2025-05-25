<?php

namespace App\Models;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;

class Claves{

    public function regimenFiscal(){
        return json_decode(\File::get('../json/RegimenFiscal.json'), true);
    }
    public function usoCFDI(){
        return json_decode(\File::get('../json/UsoCFDI.json'), true);
    }
    
    public function filterProduct(){
        $Prod = collect(json_decode(File::get('../json/ClaveProdServ.json')));
        $prod = $Prod->take(60000);
        $resultado = $prod->select('id', 'descripcion');
        return $resultado;
    }
    
    
    public function claveUnidad(){
        $json = collect(json_decode(File::get('../json/ClaveUnidad.json')));
        $clave = $json->take(20000);
        $claveFilter = $clave->select('id', 'nombre');
        return $claveFilter;
    }
    
}