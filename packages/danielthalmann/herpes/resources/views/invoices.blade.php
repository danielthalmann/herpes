@extends('herpes::layouts.app')

@section('content')

    <x-herpes.layout>

        <x-slot name="appid">
            invoices
        </x-slot>
        <x-slot name="name">
            Invoices
        </x-slot>
        <x-slot name="index">
            {{ route('invoice.index') }}
        </x-slot>
        <x-slot name="store">
            {{ route('invoice.store') }}
        </x-slot>
        <x-slot name="create">
            {{ route('invoice.create') }}
        </x-slot>
        <x-slot name="destroy">
            {{ route('invoice.destroy', ['invoice' => '|id|']) }}
        </x-slot>
        <x-slot name="update">
            {{ route('invoice.update', ['invoice' => '|id|']) }}
        </x-slot>
        <x-slot name="open">
            {{ route('invoice.item', ['invoice' => '|id|']) }}
        </x-slot>
        <x-slot name="breadcrumb">
            {{ json_encode([
                [
                    'label' => 'Invoices',
                    'url' => route('invoice')
                ],
                [
                    'label' => 'List',
                ],
            ])  }}
        </x-slot>

    </x-herpes.layout>

@endsection
