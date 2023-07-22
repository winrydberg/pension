<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function employees(){
        return $this->hasMany(Customer::class);
    }



    public function pendingcount(){
        $count = Customer::where('bank_id',$this->id)->where('ispaid', false)->count();
        if($count == null){
            return 0;
        }
        return $count;
    }
}
