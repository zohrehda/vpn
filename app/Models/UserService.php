<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserService extends Model
{
    use  HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'service_id', 'start_date', 'end_date'
    ];

    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function ($query) {

            $query->start_date = $query->start_date ?? Carbon::now();
            $query->end_date = $query->end_date ??  Carbon::now()->addDays(
                Service::find($query->service_id)->duration
            );
        });
    }
}
