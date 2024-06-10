@extends('errors.minimal')

@section('title',  $title ?? __('Server Error'))
@section('code', $code ?? '500')
@section('message', $message ?? __('Server Error'))
