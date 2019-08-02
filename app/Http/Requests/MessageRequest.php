<?php

namespace App\Http\Requests;

use App\Events\newMessageEvent;

use App\Message;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

/**
 * @property string body
 * @property array  media
 */
class MessageRequest extends FormRequest
{
    /**
     * @var User
     */
    private $user;

    /**
     * MessageRequest constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = auth()->user();
    }

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

    /**
     * @return Message
     */
    public function createMessage()
    {
        /** @var Message $message */
        $message = $this->user->messages()->create([
            'body' => $this->body
        ]);

        if (count($this->media)) {
            $message->media()->sync(Arr::pluck($this->media,'id'));
            $message->load('media');
        }


        broadcast(new newMessageEvent($message))->toOthers();;

        return $message;
    }
}
