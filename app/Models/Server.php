<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
/**
 * Server
 *
 * @mixin Builder
 */
class Server extends Model
{

    /**
     * @var int|mixed
     */
    protected $table = 'servers';
    protected $hidden = ['id','owner_id','botIn'];
    protected $fillable=['did','name','server_icon','botIn','owner','private'];
    public function users()
    {
        return $this->belongsToMany(User::class,"server_users","server_id");
    }
    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function uploads(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Upload::class, "server_id")->with("author");
    }
    public function suspension(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Suspension::class,"server_id","did");
    }
    /*
     * Check if a server is suspended.
     */
    public function isSuspended():bool
    {
        return $this->suspension()->where("active",true)->exists();
    }
    protected static function booted(): void
    {
        static::deleting(function (Server $server) {
            \Storage::deleteDirectory("/uploads/".$server->id);
            $server->uploads()->delete();
        });
    }
    public function getRouteKeyName(): string
    {
        return 'did';
    }
}
