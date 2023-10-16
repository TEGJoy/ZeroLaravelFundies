@extends('tournaments.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tourney overview</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('tournaments.create') }}"> Create New tournament</a>
            </div>
        </div>
    </div>
    <form action="{{ route('tournaments.index') }}" method="GET" role="search">
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
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Total Signups</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($tournaments as $tournament)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $tournament->name }}</td>
            <td>{{ $tournament->max }}</td>
            <td>
                <form action="{{ route('tournaments.destroy',$tournament->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('tournaments.show',$tournament->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('tournaments.edit',$tournament->id) }}">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
