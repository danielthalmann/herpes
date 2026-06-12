@extends('herpes::layouts.app')

@section('content')

    <x-herpes.layout>

        <x-slot name="appid">
            address-customer
        </x-slot>
        <x-slot name="name">
            Addresses
        </x-slot>
        <x-slot name="index">
            {{ route('customer.address.index', ['customer' => $customer]) }}
        </x-slot>
        <x-slot name="store">
            {{ route('customer.address.store', ['customer' => $customer]) }}
        </x-slot>
        <x-slot name="destroy">
            {{ route('customer.address.destroy', ['customer' => $customer, 'address' => '|id|']) }}
        </x-slot>
        <x-slot name="update">
            {{ route('customer.address.update', ['customer' => $customer, 'address' => '|id|']) }}
        </x-slot>

    </x-herpes.layout>

@endsection
