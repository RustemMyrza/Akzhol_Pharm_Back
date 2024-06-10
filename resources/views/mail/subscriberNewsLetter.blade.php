@extends('layouts.mail')

@section('email-content')
    <div>
        <h4 style="text-align: left">{{ $title }}</h4>
        {!! $description !!}
    </div>
@endsection
