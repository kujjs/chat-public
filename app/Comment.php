<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['name','body'];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name??'anonimo';
    }

    public function attachMedia($media = '')
    {
        if ($media == '')
            return;

        $media = explode(',', $media);

        Media::whereIn('name',$media)->update([
            'attach_id' => $this->id,
            'attach_type' => get_class($this)
            ]);

    }

    public function media()
    {
        return $this->morphMany(Media::class, 'attach');
    }
}
