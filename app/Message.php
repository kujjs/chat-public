<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['body'];
    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return $this->user->name;
    }
//    public function setNameAttribute($name)
//    {
//        $this->attributes['name'] = $name ?? 'anonimo';
//    }

    public function media()
    {
        return $this->morphToMany(Media::class, 'attachable');
    }

//    public function attachMedia($media = '')
//    {
//        if ($media == '')
//            return;
//
//        $this->media()->sync($media);

//        Media::whereIn('id',array_column( (Array) $media,'id'))->update([
//            'attach_id' => $this->id,
//            'attach_type' => get_class($this)
//        ]);


//    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
