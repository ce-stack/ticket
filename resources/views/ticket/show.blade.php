@extends('layouts.ticket')

@section('content')

    <div class="container mt-4">
        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="card my-2">
            <div class="card-header text-center font-weight-bold">
                Ticket content
            </div>

            <div class="card-body text-center">
                {!! strip_tags($ticket->content,["div","br","p"]) !!}
            </div>
        </div>

        <div class="card my-2">
            <div class="card-header text-center font-weight-bold">
                Ticket replies
            </div>

            <div class="card-body text-center">
                @foreach($ticket->replies as $reply)
                    <div class="card my-2">
                        <div class="card-body">
                            <p>
                                {{$reply->created_at->format('Y-m-d g:i A')}}
                            </p>
                            <p>
                                {!! strip_tags($reply->content,["div","br","p"]) !!}
                            </p>

                        </div>

                    </div>
                @endforeach
            </div>
        </div>
        <div class="card">
            <div class="card-header text-center font-weight-bold">
                Ticket
            </div>
            <div class="card-body">
                <form  method="POST" action="{{ route('reply.store') }}">
                    @csrf

                    <div class="form-group">
                        <input  type="hidden" id="title" name="ticket_id" value="{{ $ticket->id }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Content</label>
                        <textarea name="content" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
