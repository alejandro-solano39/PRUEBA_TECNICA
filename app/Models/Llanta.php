<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Llanta extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = ['nombre', 'ancho', 'diametro_rin', 'presion_max', 'fabricante', 'stock', 'calificacion', 'satisfaccion'];
    protected $guarded = ['satisfaccion'];

    protected $dates = ['deleted_at']; 
}
