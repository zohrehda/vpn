<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
//use Illuminate\Notifications\Notifiable;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'email',
        'phone_number',
        'role',
        'password',
        'referral_id',
        'referral_code',
        'referrals',
        'fix_discount',
        'rank',
        'server_username',
        'server_password',
        'last_seen',
    ];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password',
    ];

    protected $attributes = [
        'role' => UserRoleEnum::USER
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($value)
    {
        return $this->attributes['password'] = Hash::make($value);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->referral_id = $query->referral_id ?? random_string();
            $query->last_seen = Carbon::now();
        });
    }
   

    public function calculateDiscount()
    {
        // return $this->fix_discount + () ;
    }

    public function tokens()
    {
        return $this->hasMany(Token::class, 'user_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'user_services')->withPivot(['start_date', 'end_date']);
    }

    public function currentService()
    {
        return $this->services()->wherePivot('start_date', '<=', Carbon::now())->wherePivot('end_date', '>=', Carbon::now())->first();
    }

    public function reservedService()
    {
        return $this->services()->wherePivot('start_date', '>', Carbon::now())->first();
    }
    public function devices()
    {
        return $this->hasMany(UserDevice::class);
    }
}
