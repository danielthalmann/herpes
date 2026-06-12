@extends('herpes::layouts.app')

@section('content')

    <x-herpes.layout>

        <x-slot name="appid">
            address-customer
        </x-slot>
        <x-slot name="index">
            {{ route('address-customer.index', ['customer' => $customer]) }}
        </x-slot>
        <x-slot name="store">
            {{ route('address-customer.store', ['customer' => $customer]) }}
        </x-slot>
        <x-slot name="destroy">
            {{ route('address-customer.destroy', ['customer' => $customer, 'address' => '|id|']) }}
        </x-slot>
        <x-slot name="update">
            {{ route('address-customer.update', ['customer' => $customer, 'address' => '|id|']) }}
        </x-slot>

    </x-herpes.layout>

@endsection
