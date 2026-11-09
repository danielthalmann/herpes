@extends('herpes::layouts.app')

@section('content')

    <x-herpes.layout>
        <x-slot name="appid">
            tickettimesheets
        </x-slot>
        <x-slot name="name">
            Timesheets
        </x-slot>
        <x-slot name="api.ticket-show">
            {{ route('ticket.show', ['ticket' => $ticket]) }}
        </x-slot>
        <x-slot name="index">
            {{ route('ticket.timesheets.index', ['ticket' => $ticket]) }}
        </x-slot>
        <x-slot name="store">
            {{ route('timesheet.store') }}
        </x-slot>
        <x-slot name="create">
            {{ route('timesheet.create') }}
        </x-slot>
        <x-slot name="destroy">
            {{ route('timesheet.destroy', ['timesheet' => '|id|']) }}
        </x-slot>
        <x-slot name="update">
            {{ route('timesheet.update', ['timesheet' => '|id|']) }}
        </x-slot>
        <x-slot name="api.ticket-index">
            {{ route('ticket.index') }}
        </x-slot>
        <x-slot name="breadcrumb">
            {{ json_encode([
                [
                    'label' => 'Tickets',
                    'url' => route('ticket')
                ],
                [
                    'label' => 'Ticket',
                    'url' => route('ticket.timesheets', ['ticket' => $ticket])
                ],
                [
                    'label' => 'Detail',
                ],
            ])  }}
        </x-slot>
        <x-slot>

        </x-slot>
    </x-herpes.layout>

@endsection
