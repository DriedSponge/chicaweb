<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;
    protected $keyType = 'string';

    protected $table = 'servers';
    public function users()
    {
        return $this->hasMany(User::class,"server_id")->withPivot('is_owner');
    }
}
