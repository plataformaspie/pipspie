<?php

namespace App\Models\ModuloEntidades;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $table='spie_instituciones';
    protected $fillable=[
    	'nombre',
    	'codigo',
    	'sigla',
    	'direccion',
    	'localidad'
    ];
}
