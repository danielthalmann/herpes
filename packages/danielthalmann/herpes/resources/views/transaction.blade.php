@extends('herpes::layouts.app')

@section('content')

    <x-herpes.layout>

        <x-slot name="appid">
            transactions
        </x-slot>
        <x-slot name="name">
            Transactions
        </x-slot>
        <x-slot name="index">
            {{ route('transaction.index') }}
        </x-slot>
        <x-slot name="store">
            {{ route('transaction.store') }}
        </x-slot>
        <x-slot name="create">
            {{ route('transaction.create') }}
        </x-slot>
        <x-slot name="destroy">
            {{ route('transaction.destroy', ['transaction' => '|id|']) }}
        </x-slot>
        <x-slot name="update">
            {{ route('transaction.update', ['transaction' => '|id|']) }}
        </x-slot>
        <x-slot name="breadcrumb">
            {{ json_encode([
                [
                    'label' => 'Transactions',
                    'url' => route('transaction')
                ],
                [
                    'label' => 'List',
                ],
            ])  }}
        </x-slot>

    </x-herpes.layout>

@endsection
