<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['body','user_id'];
    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return $this->user->name;
    }

    public function media()
    {
        return $this->morphToMany(Media::class, 'attachable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
