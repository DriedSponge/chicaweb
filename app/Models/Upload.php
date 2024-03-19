<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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
    public function setPrivate(bool $private): void
    {
        if(!$private){
            \Cache::forget($this->fileName."tempURL");
        }
        \Storage::setVisibility($this->path(),$private ? "private" : "public");
    }

    public function generateTempURL(): string
    {
        $url = Cache::get($this->fileName."tempURL");
        if(!$url){
            $expires=now()->addMinutes(5);
            $url = \Storage::temporaryUrl($this->path(),$expires);
            Cache::put($this->fileName."tempURL",$url,$expires);
        }
        return $url;
    }

    public function path():string
    {
        return "/uploads/".$this->server_id."/".$this->fileName;
    }
    public function directory():string
    {
        return "/uploads/".$this->server_id."/";
    }
}
