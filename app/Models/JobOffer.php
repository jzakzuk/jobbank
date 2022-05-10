<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;

    protected $table = 'job_offers';

    protected $fillable = [
        'name',
        'status'
    ];

    public function users(){
        return $this->belongsToMany(\App\Models\User::class, 'job_offer_has_users', 'offer_id', 'user_id');
    }

}
