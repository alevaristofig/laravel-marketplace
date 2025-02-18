<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    protected $fillable = ['store_id','reference','pagseguro_status','pagseguro_code','items'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function store()
    {
        $this->belongsTo(Store::class);
    }
    
    public function stores()
    {
        return $this->belongsToMany(Store::class,'order_store','order_id');
    }
}
