<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;
    protected $table = 'servers';
    public function users()
    {
        return $this->hasMany(User::class,"server_ids")->withPivot('is_owner');
    }
}
