@extends('herpes::layouts.app')

@section('content')

    <x-herpes.layout>

        <x-slot name="appid">
            balancesheet-item
        </x-slot>
        <x-slot name="name">
            Balance Sheet Items
        </x-slot>
        <x-slot name="index">
            {{ route('balancesheet.item.index', ['balancesheet' => $balancesheet]) }}
        </x-slot>
        <x-slot name="store">
            {{ route('balancesheet.item.store', ['balancesheet' => $balancesheet]) }}
        </x-slot>
        <x-slot name="create">
            {{ route('balancesheet.item.create', ['balancesheet' => $balancesheet]) }}
        </x-slot>
        <x-slot name="destroy">
            {{ route('balancesheet.item.destroy', ['balancesheet' => $balancesheet, 'item' => '|id|']) }}
        </x-slot>
        <x-slot name="update">
            {{ route('balancesheet.item.update', ['balancesheet' => $balancesheet, 'item' => '|id|']) }}
        </x-slot>
        <x-slot name="breadcrumb">
            {{ json_encode([
                [
                    'label' => 'Balance Sheets',
                    'url' => route('balancesheet')
                ],
                [
                    'label' => 'Items',
                    'url' => route('balancesheet.item', ['balancesheet' => $balancesheet])
                ],
                [
                    'label' => 'List',
                ],
            ])  }}
        </x-slot>

    </x-herpes.layout>

@endsection
