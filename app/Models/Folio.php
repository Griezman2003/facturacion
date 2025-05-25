<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Folio extends Model
{
    use HasFactory;

    protected $fillable = ['serie', 'ultimo_folio'];

    protected $attributes = [
        'ultimo_folio' => 1000,
    ];


    /**
     * Metodo para obtener el siguiente folio de la serie
     *
     * @param [type] $serie
     * @return void
     */
    public static function obtenerSiguienteFolio($serie)
    {
        $folio = DB::table('folios')->where('serie', $serie)->first();

        if (!$folio) {
            $folio = DB::table('folios')->insert(['serie' => $serie, 'ultimo_folio' => 1000]);
        }
        return $folio->ultimo_folio;
    }

    /**
     * Metodo para incrementar el folio después de generar una factura
     *
     * @param [type] $serie
     * @return void
     */
    public static function incrementarFolio($serie)
    {
        $folio = DB::table('folios')->where('serie', $serie)->first();

        if (!$folio) {
            $folio = DB::table('folios')->insert(['serie' => $serie, 'ultimo_folio' => 1000]);
        }else{
        $folio = DB::table('folios')->increment('ultimo_folio', 1);

        }
        return $folio->ultimo_folio;
    }
}
