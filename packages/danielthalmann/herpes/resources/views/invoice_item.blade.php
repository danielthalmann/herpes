@extends('herpes::layouts.app')

@section('content')

    <x-herpes.layout>

        <x-slot name="appid">
            invoice-item
        </x-slot>
        <x-slot name="name">
            Invoice Items
        </x-slot>
        <x-slot name="index">
            {{ route('invoice.item.index', ['invoice' => $invoice]) }}
        </x-slot>
        <x-slot name="store">
            {{ route('invoice.item.store', ['invoice' => $invoice]) }}
        </x-slot>
        <x-slot name="create">
            {{ route('invoice.item.create', ['invoice' => $invoice]) }}
        </x-slot>
        <x-slot name="destroy">
            {{ route('invoice.item.destroy', ['invoice' => $invoice, 'item' => '|id|']) }}
        </x-slot>
        <x-slot name="update">
            {{ route('invoice.item.update', ['invoice' => $invoice, 'item' => '|id|']) }}
        </x-slot>
        <x-slot name="breadcrumb">
            {{ json_encode([
                [
                    'label' => 'Invoices',
                    'url' => route('invoice')
                ],
                [
                    'label' => 'Items',
                    'url' => route('invoice.item', ['invoice' => $invoice])
                ],
                [
                    'label' => 'List',
                ],
            ])  }}
        </x-slot>

    </x-herpes.layout>

@endsection
