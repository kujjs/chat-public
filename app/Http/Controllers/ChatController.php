<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('Home');
    }
    public function messages()
    {
        return Message::orderby('created_at','desc')->with('media','user:id,name')->get()->toArray();
    }
    public function login(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|string|email'
        ]);
        $user = User::firstOrCreate([
            'name'     => $request->name,
            'email'    => $request->email,
        ]);

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->save();

        return response()->json([
            'name'         => $user->name,
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at)
                ->toDateTimeString(),
        ]);
    }
}
