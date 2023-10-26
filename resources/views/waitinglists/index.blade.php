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
    <div class="pull-left">
        <h2>{{ Auth::user()->name}} 's WaitingList</h2>
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
            </tr>
            @endforeach
        </table>
    </div>
@endsection
