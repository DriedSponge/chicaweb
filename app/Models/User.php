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
        'id',
        'discord_token',
        'remember_token',
    ];

    public function servers()
    {
        return $this->belongsToMany(Server::class,"server_users","user_id","server_id");
    }
    public function ownedServers(){
        return $this->hasMany(Server::class,"owner_id");
    }
    public function uploads(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Upload::class, "user_id");
    }
    public function allUploads(): \Illuminate\Database\Eloquent\Builder|Upload
    {
        $serverIds = $this->servers->pluck('id');
        return Upload::whereHas('server', function ($query) use ($serverIds) {
            $query->whereNull('suspension_id')->whereIn('id', $serverIds);
        })->whereHas('author', function ($query) {
            $query->whereNull('suspension_id');
        });
    }
    public function suspension(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Suspension::class);
    }
    public function suspended(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Suspension::class,"admin_id");
    }
}
