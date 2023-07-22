<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class Scheme extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function claims(){
        return $this->hasmany(Claim::class);
    }

    public static function boot() {
        parent::boot();
        /**
        * Write code on Method
        *
        * @return response()
        */

        static::created(function($item) {
             Permission::create(['name' => $item->name.'--'. $item->tiertype]);
        });
    }


    public function receipt_count(){
        return Claim::where('claim_state_id', 4)->where('scheme_id', $this->id)->where('user_id', Auth::user()->id)->count();
    }
}
