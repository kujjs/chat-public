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
        $name = Cache::get('name');

        $comments = Cache::remember('comments', 5, function() {
            return Comment::orderby('created_at','desc')->with('media')->get();
        });

        return view('Comment.home',compact('name','comments'));
    }



    /**
     * @param CommentRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CommentRequest $request)
    {
        if($request->createComment()){
            Cache::put('name',$request->name,5);
            Cache::forget('comments');
            return back();
        }
        return redirect()->route('home.comment,')->setStatusCode(400);
    }


    /**
     * @param UploadMediaRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(UploadMediaRequest $request)
    {
        $file = $request->createMedia();
        return response()->json(['url'=>$file->url,'name'=>$file->name],200);
    }
}
