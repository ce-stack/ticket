@extends('layouts.ticket')

@section('content')

  <div class="container mt-4">
  @if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
  @endif
  <div class="card">
    <div class="card-header text-center font-weight-bold">
      Ticket
    </div>
    <div class="card-body">
      <form  method="POST" action="{{route('ticket.store')}}">
       @csrf
        <div class="form-group">
          <label for="exampleInputEmail1">Subject</label>
          <input type="text" id="title" name="subject" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" id="title" name="email" class="form-control" required>
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
