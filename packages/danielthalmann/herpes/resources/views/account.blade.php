@extends('herpes::layouts.app')

@section('content')

    <x-herpes.layout>

        <x-slot name="appid">
            accounts
        </x-slot>
        <x-slot name="name">
            Accounts
        </x-slot>
        <x-slot name="index">
            {{ route('account.index') }}
        </x-slot>
        <x-slot name="store">
            {{ route('account.store') }}
        </x-slot>
        <x-slot name="create">
            {{ route('account.create') }}
        </x-slot>
        <x-slot name="destroy">
            {{ route('account.destroy', ['account' => '|id|']) }}
        </x-slot>
        <x-slot name="update">
            {{ route('account.update', ['account' => '|id|']) }}
        </x-slot>
        <x-slot name="breadcrumb">
            {{ json_encode([
                [
                    'label' => 'Accounts',
                    'url' => route('account')
                ],
                [
                    'label' => 'List',
                ],
            ])  }}
        </x-slot>

    </x-herpes.layout>

@endsection
