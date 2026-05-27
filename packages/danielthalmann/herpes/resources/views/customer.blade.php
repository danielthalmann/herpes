@extends('herpes::layouts.app')

@section('content')

    <x-herpes.layout>

        <x-slot name="appid">
            customer
        </x-slot>
        <x-slot name="url">
            {{ route ('customer.index') }}
        </x-slot>

    </x-herpes.layout>

@endsection

