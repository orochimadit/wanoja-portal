<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'roles',
        'address', 'city_id', 'province_id', 'phone', 'avatar', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function orders(){
        return $this->hasMany('App\Order');
      }

    //   public function generateToken()
    //   {
    //       $this->remember_token = str_random(60);
    //       $this->save();
    //       return $this->remember_token;
    //   }
      public function generateToken()
      {
          $this->api_token = str_random(60);
          $this->save();
  
          return $this->api_token;
      }
}
