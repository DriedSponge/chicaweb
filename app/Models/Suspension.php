<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suspension extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'suspensions';
    public function server(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(Server::class);
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(User::class);
    }

}
