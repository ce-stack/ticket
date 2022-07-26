@extends('layouts.ticket')

@section('content')
<style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    td, th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }
    </style>

<table>

  <tr>
    <th>ID</th>
    <th>Subjects</th>
    <th>Email</th>
    <th>No: of Reply</th>
    <th>Add Reply</th>
    <th>Edit</th>
    <th>Delete</th>
  </tr>
  @foreach ($tickets as $ticket)
  <tr>

    <td>{{ $ticket->id }}</td>
    <td>{{ $ticket->subject }}</td>
    <td>{{$ticket->email}}</td>
    <td>{{  $ticket->replies_count  }}</td>
    <td><a href="{{ route('ticket.show' , [$ticket->id]) }}">Add Reply</td>
    <td><a href="{{ route('ticket.edit' , $ticket->id) }}">Edit </a></td>
    <td><form action="{{ route('ticket.destroy', $ticket->id)}}" method="post">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit">Delete</button>
      </form></td>

  </tr>
  @endforeach


</table>


{!! $tickets->links() !!}
@endsection
