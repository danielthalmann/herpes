@extends('herpes::layouts.app')

@section('content')

    <x-herpes.layout>

        <x-slot name="appid">
            customer
        </x-slot>
        <x-slot name="index">
            {{ route ('customer.index') }}
        </x-slot>
        <x-slot name="store">
            {{ route ('customer.store') }}
        </x-slot>
        <x-slot name="destroy">
            {{ route ('customer.destroy' , ['customer' => '|id|']) }}
        </x-slot>
        <x-slot name="update">
            {{ route ('customer.update' , ['customer' => '|id|']) }}
        </x-slot>

    </x-herpes.layout>

@endsection

