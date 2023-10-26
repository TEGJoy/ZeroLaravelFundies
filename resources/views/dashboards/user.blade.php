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
            @auth
            @if($superUser >= 5)
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('tournaments.create') }}"> Create New tournament</a>
            </div>
            @endif
            @endauth
        </div>
    </div>
    <form action="{{ route('dashboard') }}" method="GET" role="search">
        <b>Search Created Tourneys</b>
        {{ csrf_field() }}
        <div class="input-group">
            <input type="text" class="form-control" name="search-created"
                placeholder="Search created tournaments"> <span class="input-group-btn">
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
                    <a class="btn btn-primary" href="{{ route('tournaments.join',$tournament->id) }}">Join</a>
                    <a class="btn btn-primary" href="{{ route('tournaments.edit',$tournament->id) }}">Edit</a>
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
