<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    
    protected $table = 'customers';


    protected $primaryKey = 'dni';


    protected $fillable = ['dni', 'id_reg', 'id_com', 'email', 'name', 'last_name', 'address', 'date_reg', 'status'];


    public $timestamps = false;


    public function commune()
    {
        return $this->belongsTo(Commune::class, ['id_com', 'id_reg'], ['id_com', 'id_reg']);
    }


    public function region()
    {
        return $this->belongsTo(Region::class, 'id_reg', 'id_reg');
    }


    public function scopeActive($query)
    {
        return $query->where('status', 'A');
    }


    public function scopeSearch($query, $identifier)
    {
        return $query->where(function ($q) use ($identifier) {
            $q->where('dni', $identifier)
              ->orWhere('email', $identifier);
        });
    }


    public function softDelete()
    {
        if ($this->status === 'trash') {
            return "Registro no existe.";
        }

        $this->status = 'trash';
        $this->save();

        return "Registro eliminado.";
    }
}
