@extends('herpes::layouts.app')

@section('content')

    <x-herpes.layout>

        <x-slot name="appid">
            balancesheets
        </x-slot>
        <x-slot name="name">
            Balance Sheets
        </x-slot>
        <x-slot name="index">
            {{ route('balancesheet.index') }}
        </x-slot>
        <x-slot name="store">
            {{ route('balancesheet.store') }}
        </x-slot>
        <x-slot name="create">
            {{ route('balancesheet.create') }}
        </x-slot>
        <x-slot name="destroy">
            {{ route('balancesheet.destroy', ['balancesheet' => '|id|']) }}
        </x-slot>
        <x-slot name="update">
            {{ route('balancesheet.update', ['balancesheet' => '|id|']) }}
        </x-slot>
        <x-slot name="open">
            {{ route('balancesheet.item', ['balancesheet' => '|id|']) }}
        </x-slot>
        <x-slot name="api.print">
            {{ route('balancesheet.print', ['id' => '|id|']) }}
        </x-slot>
        <x-slot name="breadcrumb">
            {{ json_encode([
                [
                    'label' => 'Balance Sheets',
                    'url' => route('balancesheet')
                ],
                [
                    'label' => 'List',
                ],
            ])  }}
        </x-slot>

    </x-herpes.layout>

@endsection
