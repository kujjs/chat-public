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
        $comment->load('media');

//        Redis::publish('canal', json_encode($comment));
        return $comment;
    }
}
