@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>User overview</h2>
            </div>
            @if (Session::has('success'))
            <div class="alert alert-success">
                <h2>{!! Session::get('success') !!}</h2>
            </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    <h2>{!! Session::get('error') !!}</h2>
                </div>
            @endif
        </div>
    </div>
    <form action="{{ route('waitinglist.index') }}" method="GET" role="search">
        <b>Search Tourneys</b>
          {{ csrf_field() }}
          <div class="input-group">
              <input type="text" class="form-control" name="search"
                  placeholder="Search tournaments"> <span class="input-group-btn">
                  <button type="submit" class="btn btn-default">
                      <span class="glyphicon glyphicon-search"></span>
                  </button>
              </span>
          </div>
      </form>
    <div class="pull-left">
        <h2>{{ Auth::user()->name}} 's  Admin WaitingList</h2>
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Tournament Name</th>
                <th>Player Name</th>
                <th width="280px">Action</th>
            </tr>
            @foreach($tournamentWaitingLists as $tournament)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $tournament->tournament_name}}
                <td>{{ $tournament->name }}</td>
                <td>
                    <form action="{{ route('waitinglist.destroy',$tournament->signID) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('waitinglist.show',$tournament->tournament_id) }}">Show</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
@endsection
