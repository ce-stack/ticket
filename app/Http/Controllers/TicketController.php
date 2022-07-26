<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Mail\NotifyMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Mail;
class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $tickets = Ticket::withCount('replies')->orderBy('id','desc')->paginate(20);

        return view('ticket.index' , compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ticket.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create([
            'subject' => $request->subject,
            'content' => $request->content,
            'email' => $request->email
        ]);

        $data = [
            'email' => $request->email,
            'content' => $request->content,
            'subject' => $request->email
        ];



        \Illuminate\Support\Facades\Mail::to($data['email'])->send(new NotifyMail($data['content'],$ticket->id));

        return redirect()->back()->with('message' , 'ticket added succefully check email you have entered now!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::with('replies')->findOrFail($id);
        return view('ticket.show' , compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::find($id);
        //  dd($ticket);
        return view('ticket.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTicketRequest  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {

        // dd($ticket);
        $ticket->update($request->all());

        return redirect()->back()->with('message' , 'ticket updated succefully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {

        $ticket->delete();
        return redirect()->back()->with('message' , 'ticket deleted succefully!');

    }
}
