<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //
    protected $fillable = [

        'nombre',
        'tipo',
    ];


    // Un movimiento pertenece a una categoria
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }


}
