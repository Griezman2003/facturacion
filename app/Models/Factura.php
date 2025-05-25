<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'IdFactura',
        'folio',
        'uuid',
        'rfc_emisor',
        'rfc_receptor',
        'subtotal',
        'total',
        'pdf_path',
        'xml_path',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
