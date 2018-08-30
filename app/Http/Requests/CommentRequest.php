<?php

namespace App\Http\Requests;

use App\Comment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Redis;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the name is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>['present','max:100'],
            'body'=>['required','max:200'],
            'media'=>'present',
        ];
    }

    public function createComment()
    {
        $comment = Comment::create([
            'name' => $this->name,
            'body' => $this->body
        ]);
        $comment->attachMedia($this->media);
//
        $medias = [];
        if($this->media){
            foreach ($comment->media as $media){
                array_push($medias, ['url'=>$media->url_real_media,'is_image'=>$media->isImage()]);
            }

        }
        $comment = [
            'name' => $comment->name,
            'body' => $comment->body,
            'media' => $medias,
            'created_at' =>(string)$comment->created_at
        ];
        Redis::publish('canal', json_encode($comment));
        return $comment;
    }
}
