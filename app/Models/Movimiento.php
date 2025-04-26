<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $fillable = [
        'user_id',
        'categoria_id',
        'tipo',
        'monto',
        'descripcion',
        'foto',
        'fecha',

    ];
    protected $casts = [
        'monto' => 'decimal:2',
      ];

    //

    // relacion uno a muchos
    // Un movimiento pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Un movimiento pertenece a un presupuesto
    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }
    // Un movimiento pertenece a una categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
