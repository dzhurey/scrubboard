<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function setPasswordAttribute($password)
    {
        if ( !empty($password) ) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    const ROLES = [
        'superadmin' => 'Superadmin',
        'sales' => 'Client Service',
        'finance' => 'Finance',
        'operation' => 'Operation',
        'courier' => 'Kurir',
        'workshop' => 'Workshop',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'role', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function person()
    {
        return $this->hasOne('App\Person');
    }

    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    public function isCourier()
    {
        return $this->role === 'courier';
    }

    public function salesOrders()
    {
        return $this->hasMany('App\SalesOrder');
    }

    public function salesInvoices()
    {
        return $this->hasMany('App\SalesInvoice');
    }
}
