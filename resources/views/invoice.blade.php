<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Facture {{ $invoice['ref'] }}</title>
    <link href="theme.css" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta name="description" content="">
    <meta name="author" content="Daniel Thalmann (white-ermine.ch)">
    <link rel="icon" href="images/logo-white-sans-32x32.svg" sizes="32x32" />
</head>
<body class="text-[10pt]">

    <section class="mb-25">
        <div class="mx-auto px-2 max-w-5xl grid grid-cols-2">
            <div class="flex flex-col">
                <div class="mx-auto max-w-5lg w-full flex">
                    <div class="">
                        <img class=" ml-auto h-30" src="{{ url('images/logo_white_ermine.svg') }}">
                    </div>
                    <div class="m-5">
                        White Ermine Game Studio<br>
                        Daniel Thalmann<br>
                        Chemin des Carroux 15<br>
                        1744 Chénens<br>
                    </div>
                </div>
                <div class=" grow flex items-end">
                    <div>
                        <div class="grid grid-cols-2">
                            <span>Numéro de facture&nbsp;</span> <div>:&nbsp;<span class="font-bold">{{ $invoice['ref'] }}</span></div>
                            <span>Date de la facture&nbsp;</span> <div>:&nbsp;<span class="font-bold">{{ \Carbon\Carbon::parse($invoice['invoice_date'])->format('d.m.Y') }}</span></div>
                        </div>
                        <span>Payable sous 30 jours.</span>
                    </div>
                </div>
            </div>
            <div class="pl-10 mt-34">

                {{ $invoice['customer_company'] ?? '' }}<br>
                @if(isset($invoice['customer_department'])) {{ $invoice['customer_department'] ?? '' }}<br> @endif
                {{ $invoice['customer_name'] ?? '' }}<br>
                {{ $invoice['customer_street'] }}<br>
                {{ $invoice['customer_zipcode'] }} {{ $invoice['customer_city'] }}<br>

            </div>
        </div>
    </section>

    <section class="mb-15">
        <div class="mx-auto p-2 max-w-5xl grid grid-cols-13 gap-2 bg-gray-200 font-bold">
            <div class="">
                Pos.
            </div>
            <div class="col-span-6">
                Descriptions
            </div>
            <div class="col-span-2 text-right">
                Quantité
            </div>
            <div class="col-span-2 text-right">
                Prix unit.
            </div>
            <div class="col-span-2 text-right">
                Total
            </div>
        </div>
        <div class="mx-auto p-2 max-w-5xl grid grid-cols-13 gap-2">
        @php
            $total = 0;
        @endphp
    @foreach($invoice->invoiceItems as $position)
        @if($position['unit_price'] > 0)
            <div class="">
                {{ $position['no'] }}
            </div>
            <div class="col-span-6">
                {{ $position['description'] }}
            </div>
            <div class="col-span-2 text-right">
                {{ $position['quantity'] }}
                {{ $position['quantity_type'] }}
            </div>
            <div class="col-span-2 text-right">
                {{ number_format($position['unit_price'], 2, '.', '\'') }}
            </div>
            <div class="col-span-2 text-right">
                {{ number_format($position['quantity'] * $position['unit_price'], 2, '.', '\'') }}
            </div>
            @php
                $total += $position['quantity'] * $position['unit_price']
            @endphp
        @endif
    @endforeach

        </div>

        <div class="mx-auto px-2 py-2 max-w-5xl grid grid-cols-13 gap-2 bg-gray-200 font-bold">
            <div class="col-span-11 text-right">
                Total intermédiaire
            </div>
            <div class="col-span-2 text-right">
            {{ number_format($total, 2, '.', '\'') }}
            </div>
        </div>
        <div class="mx-auto p-2 max-w-5xl grid grid-cols-13 gap-2">

    @foreach ($invoice->invoiceItems as $position)
        @if ($position['unit_price'] <= 0)

            <div class="">
                {{ $position['no'] }}
            </div>
            <div class="col-span-10">
                {{ $position['description'] }}
            </div>
            <div class="col-span-2 text-right">
                {{ number_format($position['quantity'] * $position['unit_price'], 2, '.', '\'') }}
            </div>
            @php
                $total += $position['quantity'] * $position['unit_price']
            @endphp

        @endif
    @endforeach

        </div>
        <div class="mx-auto p-2 max-w-5xl grid grid-cols-13 gap-2 bg-gray-200 font-bold">
            <div class="col-span-11 text-right">
                Montant total à payer
            </div>
            <div class="col-span-2 text-right">
                {{ number_format($total, 2, '.', '\'') }}
            </div>
        </div>

    </section>


    <section class="mb-10">
        <div class="mx-auto p-2 max-w-5xl grid grid-cols-2">
            <div>
                Merci beaucoup pour votre commande. <br><br>
                Daniel Thalmann

            </div>
            <div class="pl-10">

                <span class="font-bold">Coordonnées bancaires pour le versement :</span><br>
                <br>

                CH38 0900 0000 1701 3164 2<br>
                Thalmann Daniel<br>
                Chemin des Carroux 15<br>
                1744 Chénens<br>

            </div>
        </div>
    </section>

</body>
</html>
