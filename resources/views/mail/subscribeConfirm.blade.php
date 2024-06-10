@extends('layouts.mail')

@section('email-content')
    <div>
        <p style="text-align: left">@lang('message.subscribe_confirm_subject')</p>
        <a href="{{ $verifyLink }}" target="_blank">
            Подтвердить
        </a>
    </div>
@endsection
