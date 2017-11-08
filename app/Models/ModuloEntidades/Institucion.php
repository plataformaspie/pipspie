<?php

namespace App\Models\ModuloEntidades;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $table='spie_instituciones';
    protected $fillable=[
    	'nombre',
    	'dependede_id',
    	'codigo',
    	'sigla',
    	'direccion',
    	'localidad'
    ];
}
