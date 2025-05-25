<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;
    protected $table = 'perfil';
    protected $fillable = [
        'user_id',
        'tipo_persona',
        'nombre_fiscal',
        'email',
        'telefono',
        'tamano_empresa',
        'regimen_fiscal',
        'ocupacion',
        'nombre_comercial',
        'codigo_postal',
        'calle',
        'numero_exterior',
        'num_interior',
        'colonia',
        'municipio',
        'estado',
        'pais',
        // 'key_file',
        // 'cer_file',
        // 'key_password',
        'rfc',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
