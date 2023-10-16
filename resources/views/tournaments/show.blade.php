@extends('tournaments.layout')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ $tournament->name }} </h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('tournaments.index') }}"> Back</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Tournament name:</strong>
            {{ $tournament->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Maximum participants:</strong>
            {{ $tournament->max }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Description:</strong>
            <textarea value="{{ $tournament->description }}"></textarea>
        </div>
    </div>
</div>
@endsection
