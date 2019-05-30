<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = ['name','type'];
    protected $visible = ['id','url_real_media','url','is_image', 'name'];
    protected $appends = ['url_real_media','is_image','url'];

    public function attach()
    {
        return $this->morphTo();
    }

    public function setNameAttribute($name){
        $this->attributes['name'] =  str_replace('public/', '', $name);
    }
    public function getUrlAttribute()
    {
        return $this->isImage() ?$this->url_real_media:'https://upload.wikimedia.org/wikipedia/commons/thumb/2/24/YouTube_Silver_Play_Button.png/1600px-YouTube_Silver_Play_Button.png';
    }
    public function getUrlRealMediaAttribute()
    {
        return url(Storage::url(''.$this->name));
    }

    public function getIsImageAttribute()
    {
        return $this->isImage();
    }
    public function isImage()
    {
        return explode('/',$this->type)[0] === 'image';
    }
}
