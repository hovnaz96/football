<?php

namespace App\Http\Controllers\Home\User;

use App\Events\MessageSent;
use App\Http\Requests\ChatRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{

    protected $ERROR_STATUS_CODE = 400;
    protected $ERROR_VALIDATE_CODE = 422;
    protected $SUCCESS_STATUS_CODE = 200;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('home/user/chat');
    }


    public function fetchUsers()
    {
        $messages = new Message();
        return $messages->users_who_have_messages;
    }

    public function getMessagesByID($id)
    {
        $auth_id = Auth::user()->id;
        Message::where('from_id', $id)->where('to_id', $auth_id)->update(['is_seen' => true]);

        $data = Message::select(['message', 'from_id', 'to_id', 'created_at'])->where('from_id', $id)->where('to_id', $auth_id)->orWhere(function ($q) use ($id, $auth_id) {
            $q->where('to_id', $id)->where('from_id', $auth_id);
        })->with(['FromId' => function ($query) {
            $query->select(['id', 'firstname', 'lastname', 'slug']);
        }])->orderBy('id', 'desc')->take(20)->get();

        $data = array_reverse($data->toArray());

        return $data;
    }


    public function fetchMessages()
    {
        return Message::with('user')->limit(20)->get();
    }

    public function fetchUsersHeader()
    {
        $messages = new Message();
        return $messages->users_who_have_messages_header;
    }


    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $message = Message::create([
           'from_id'=>$user->id,
           'to_id'=>$request->input('to_id'),
           'message'=>$request->input('message'),
        ]);


        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }

    public function sendMessageAjax(ChatRequest $request)
    {
        $response  = new Response();
        if($request->ajax()){
            $user = Auth::user();

            $message = Message::create([
                'from_id'=>$user->id,
                'to_id'=>$request->input('to_id'),
                'message'=>$request->input('message'),
            ]);

            if($message){
                broadcast(new MessageSent($user, $message))->toOthers();

                return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
            }

            return $response->setStatusCode($this->ERROR_STATUS_CODE);
        }
    }
}
