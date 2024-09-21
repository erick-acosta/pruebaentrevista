<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{

    protected $table = 'communes';


    protected $primaryKey = 'id_com';


    protected $fillable = ['id_reg', 'description', 'status'];


    public function region()
    {
        return $this->belongsTo(Region::class, 'id_reg', 'id_reg');
    }

    
    public function customers()
    {
        return $this->hasMany(Customer::class, 'id_com', 'id_com');
    }
}
