<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoVisita extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipo_visita';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'descripcion_tipo_visita',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
