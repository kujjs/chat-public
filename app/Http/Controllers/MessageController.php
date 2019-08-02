<?php

namespace App\Http\Controllers;

use App\Message;
use App\Http\Requests\{MessageRequest, MediaRequest};



class MessageController extends Controller
{
    /**
     * @param MessageRequest $request
     *
     * @return Message
     */
    public function store(MessageRequest $request)
    {
        return $request->createMessage();
    }

    /**
     * @param MediaRequest $media
     * @return \App\Media
     */
    public function upload(MediaRequest $media)
    {
       return  $media->upload();
    }


}
