@extends('layouts.mail')

@section('email-content')
    <div>
        <h4 style="text-align: center">
            Сcылка для восстановления пароля:

            <a href="{{ $resetPasswordLink }}" target="_blank">
                перейти
            </a>
        </h4>
    </div>
@endsection
