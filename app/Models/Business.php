<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_Name',
        'business_Eddress',
        'business_Contact_Number',
        'business_Email',
        'business_SocialMedia'
    ];

    protected static function boot(){

        //para ma-run yung general Model setups na nakukuha ng ibang models
        parent::boot();

        static::creating (function ($business){
            $user = User::find($business->user_id);
            if(!$user || $user->user_type !== "owner"){
                throw new \Exception('The selected user must be an owner.');
            }
        });

    }

    

}
