<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimState extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function claim(){
        return $this->hasMany(Claim::class, 'claim_state_id');
    }

}
