<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    //
    protected $fillable = [
        'user_id',
        'categoria_id',
        'monto_asignado',
        'monto_gastado',
        'mes',
        'anio',
    ];

    // Un presupuesto pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Un presupuesto pertenece a una categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
