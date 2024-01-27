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
    use HasFactory;

    protected $table = 'servers';
    protected $hidden = ['id','owner'];
    protected $fillable=['did','name','server_icon','botIn','owner'];
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
}
