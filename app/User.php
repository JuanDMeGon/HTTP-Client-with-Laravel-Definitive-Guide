<?php

namespace App;

use App\Services\MarketService;
use Illuminate\Notifications\Notifiable;
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
        'service_id',
        'grant_type',
        'access_token',
        'refresh_token',
        'token_expires_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
        'access_token',
        'refresh_token',
        'token_expires_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function getNameAttribute()
    {
        $marketService = resolve(MarketService::class);

        $userInformation = $marketService->getUserInformation();

        return $userInformation->name;
    }
}
