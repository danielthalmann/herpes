@extends('herpes::layouts.app')

@section('content')

    <x-herpes.layout>
        <x-slot name="appid">
            timesheets
        </x-slot>
        <x-slot name="name">
            Timesheets
        </x-slot>
        <x-slot name="index">
            {{ route('timesheet.index') }}
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
                    'label' => 'Timesheets',
                    'url' => route('timesheet')
                ],
                [
                    'label' => 'Calendar',
                ],
            ])  }}
        </x-slot>
        <x-slot>

        </x-slot>
    </x-herpes.layout>

@endsection
