<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicio';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nombre_servicio',
        'cod_tipo_servicio',
        'cod_sublinea',
    ];

    protected $dates = ['created_at', 'updated_at'];

    // Define the relationships
    public function tipoServicio()
    {
        return $this->belongsTo(TipoServicio::class, 'cod_tipo_servicio');
    }

    public function sublinea()
    {
        return $this->belongsTo(Sublinea::class, 'cod_sublinea');
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'cod_servicio');
    }
}
