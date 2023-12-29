<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'did',
        'name',
        'avatar',
        'discord_token',
        'admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'discord_token',
        'remember_token',
    ];

    public function servers()
    {
        return $this->belongsToMany(Server::class,"server_users","user_id","server_id")->withPivot('is_owner');
    }
    public function uploads(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Upload::class, "user_id");
    }
    public function allUploads()
    {
        $serverIds = $this->servers->pluck('id');
        return Upload::whereHas('server', function ($query) use ($serverIds) {
            $query->whereIn('id', $serverIds);
        });
    }
}
