<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\{CommentRequest, UploadMediaRequest};
use Illuminate\Support\Facades\Cache;


class CommentController extends Controller
{

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('Comment.home');
    }



    /**
     * @param CommentRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CommentRequest $request)
    {
        return $request->createComment();
    }


    /**
     * @param UploadMediaRequest $request
     *
     * @return array
     */
    public function upload(UploadMediaRequest $request)
    {
       return (Array) $request->createMedia();
    }

    public function messages()
    {
        return Comment::orderby('created_at','desc')->with('media')->get();//->toArray();
    }
}
