@extends('layouts.app')
@section('content')
    <h1>Create New Manager</h1><br>
    {!! Form::open(['url' => 'managers']) !!}
    <div class="form-group">
        {!! Form::label('first_name', 'First Name') !!}
        {!! Form::text('first_name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('middle_name', 'Middle Name') !!}
        {!! Form::text('middle_name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('last_name', 'Last Name') !!}
        {!! Form::text('last_name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('email', ' Email') !!}
        {!! Form::text('email',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('password', 'Password') !!}
        {!! Form::text('password',null,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}
@stop