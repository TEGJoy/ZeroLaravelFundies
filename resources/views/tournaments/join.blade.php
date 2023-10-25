@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>join {{ $tournament->name }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('tournaments.index') }}">Back</a>
        </div>
    </div>
</div>



<form action="{{ route('tournaments.joinHandler', $tournament->id) }}" method="POST">
    @csrf
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Do you want to join {{ $tournament->name }}?</strong>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Yes!</button>
        </div>
    </div>
</form>
@endsection
