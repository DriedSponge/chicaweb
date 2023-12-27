<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'uploads';

    use HasFactory;

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
