<?php

namespace App\Http\Controllers;

use App\Mail\NotifyMail;
use App\Models\Reply;
use App\Http\Requests\StoreReplyRequest;
use App\Http\Requests\UpdateReplyRequest;
use App\Models\Ticket;

class ReplyController extends Controller
{

    public function store(StoreReplyRequest $request)
    {
        $ticket = Ticket::findOrFail($request->ticket_id);
        $reply = Reply::create([
            'ticket_id' => $request->ticket_id,
            'content' => $request->content,
        ]);






        \Illuminate\Support\Facades\Mail::to($ticket->email)->send(new NotifyMail($reply->content,$ticket->id));

        return redirect()->back()->with('message' , 'reply added succefully!');
    }


}
