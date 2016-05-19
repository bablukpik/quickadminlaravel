<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;
use Illuminate\Support\Facades\Hash; 


use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    public $table    = 'member';
    
    protected $fillable = [
          'name',
          'email',
          'password',
          'photo'
    ];
    

    public static function boot()
    {
        parent::boot();

        Member::observe(new UserActionsObserver);
    }
    
    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        $this->attributes['password'] = Hash::make($input);
    }


    
    
}