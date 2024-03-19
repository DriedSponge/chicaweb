<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'uploads';
    protected $hidden = ['server_id','user_id','id'];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function setPrivate(bool $private){
        \Storage::setVisibility("uploads/".$this->fileName,$private ? "private" : "public");
    }
}
