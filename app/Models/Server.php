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
    protected $keyType = 'string';

    protected $table = 'servers';
    public function users()
    {
        return $this->hasMany(User::class,"server_id")->withPivot('is_owner');
    }
    public function uploads(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Upload::class, "server_id")->with("author");
    }
}
