<?php

namespace App\Http\Requests;

use App\Events\newMessageEvent;
use App\Message;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;

class MessageRequest extends FormRequest
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
            'body' => ['required', 'max:200'],
            'media' => 'present',
        ];
    }

    public function createMessage()
    {
        $message = Auth()->user()->messages()->create([
            'body' => $this->body
        ]);

        if (count($this->media)) {
            $message->media()->sync(Arr::pluck($this->media,'id'));
            $message->load('media');
        }

        // TODO:call new event
        broadcast(new newMessageEvent($message))->toOthers();;

        return $message;
    }
}
