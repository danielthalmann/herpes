@extends('herpes::layouts.app')

@section('content')

    <x-herpes.layout>

        <x-slot name="appid">
            tickets
        </x-slot>
        <x-slot name="name">
            Tickets
        </x-slot>
        <x-slot name="index">
            {{ route('ticket.index') }}
        </x-slot>
        <x-slot name="store">
            {{ route('ticket.store') }}
        </x-slot>
        <x-slot name="create">
            {{ route('ticket.create') }}
        </x-slot>
        <x-slot name="destroy">
            {{ route('ticket.destroy', ['ticket' => '|id|']) }}
        </x-slot>
        <x-slot name="update">
            {{ route('ticket.update', ['ticket' => '|id|']) }}
        </x-slot>
        <x-slot name="breadcrumb">
            {{ json_encode([
                [
                    'label' => 'Tickets',
                    'url' => route('ticket')
                ],
                [
                    'label' => 'List',
                ],
            ])  }}
        </x-slot>

    </x-herpes.layout>

@endsection
