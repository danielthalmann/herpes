<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Bilan</title>
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

    <section class="mb-15">
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
            </div>
            <div class="pl-10 mt-34">

            </div>
        </div>
    </section>

    <section class="mb-5">
        <div class="mx-auto max-w-5xl font-bold text-lg ">
            <h1 class="">Bilan au 31 decembre 2025</h1>
        </div>
    </section>

    <section class="mb-15">
        <div class="mx-auto max-w-5xl grid grid-cols-2">
            <div class=" border-r">
                @php
                $total = 0;
                @endphp

                <div class="p-2 border-b font-bold">Actif</div>

                <div class="mx-auto p-2 max-w-5xl grid grid-cols-6 gap-2">
                    @foreach($items->clone()->where('balance_type', 'ACTIF')->get() as $item)
                        <div class="col-span-4">
                            {{ $item['description'] }}
                        </div>
                        <div class="col-span-2 text-right">
                            {{ number_format($item['amount'] / 100, 2) }}
                        </div>
                        @php
                        $total += ($item['amount'] / 100);
                        @endphp
                    @endforeach
                </div>

            </div>
            <div class="">
                @php
                $total_passif = 0;
                @endphp

                <div class="p-2 border-b font-bold">Passif</div>

                <div class="mx-auto p-2 max-w-5xl grid grid-cols-6 gap-2">
                    @foreach($items->clone()->where('balance_type', 'PASSIF')->get() as $item)
                        <div class="col-span-4">
                            {{ $item['description'] }}
                        </div>
                        <div class="col-span-2 text-right">
                            {{ number_format($item['amount'] / 100, 2) }}
                        </div>
                        @php
                        $total_passif += ($item['amount'] / 100);
                        @endphp
                    @endforeach
                </div>

            </div>
        </div>

        <div class="mx-auto max-w-5xl grid grid-cols-2 border-t-2 border-b-2">
            <div class=" border-r">
                <div class="mx-auto p-2 max-w-5xl grid grid-cols-6 gap-2 font-bold">
                    <div class="col-span-4">
                        TOTAL
                    </div>
                    <div class="col-span-2 text-right">
                        {{ number_format($total, 2) }}
                    </div>
                </div>
            </div>
            <div class="">

                <div class="mx-auto p-2 max-w-5xl grid grid-cols-6 gap-2 font-bold">
                    <div class="col-span-4">
                        TOTAL
                    </div>
                    <div class="col-span-2 text-right">
                        {{ number_format($total_passif, 2) }}
                    </div>
                </div>

            </div>
        </div>

    </section>

    <section class="mb-5">
        <div class="mx-auto max-w-5xl font-bold text-lg ">
            <h1 class="">Pertes et profits du 1er janvier au 31 decembre 2025</h1>
        </div>
    </section>

    <section class="mb-5">
        @php
            $total_benefit = 0;
        @endphp
        <div class="mx-auto p-2 max-w-5xl grid grid-cols-6 gap-2">
            @foreach($items->clone()->where('balance_type', 'PERTE_PROFFIT')->get() as $item)
                <div class="col-span-4">
                    {{ $item['description'] }}
                </div>
                <div class="col-span-2 text-right">
                    {{ number_format($item['amount'] / 100, 2) }}
                </div>
                @php
                $total_benefit += ($item['amount'] / 100);
                @endphp
            @endforeach
        </div>
        <div class="mx-auto p-2 max-w-5xl grid grid-cols-6 gap-2 font-bold border-t-2 border-b-2">
            <div class="col-span-4">
                Bénéfice brut
            </div>
            <div class="col-span-2 text-right">
                {{ number_format($total_benefit, 2) }}
            </div>
        </div>

    </section>

    <section class="mb-2">
        <div class="mx-auto max-w-5xl font-bold text-lg ">
            <h1 class="">Frais de fonctionnement</h1>
        </div>
    </section>

    <section class="mb-15">
        @php
            $total = 0;
        @endphp
        <div class="mx-auto p-2 max-w-5xl grid grid-cols-6 gap-2">
            @foreach($items->clone()->where('balance_type', 'FRAIS_FONCTIONNEMENT')->get() as $item)
                <div class="col-span-4">
                    {{ $item['description'] }}
                </div>
                <div class="col-span-2 text-right">
                    {{ number_format($item['amount'] / 100, 2) }}
                </div>
                @php
                $total += ($item['amount'] / 100);
                @endphp
            @endforeach
        </div>
        <div class="mx-auto p-2 max-w-5xl grid grid-cols-6 gap-2 font-bold border-t-2 border-b-2">
            <div class="col-span-4">
                Total des charges
            </div>
            <div class="col-span-2 text-right">
                {{ number_format($total, 2) }}
            </div>
        </div>

        <div class="mx-auto mt-1 p-2 max-w-5xl grid grid-cols-6 gap-2 font-bold border-b-2">
            <div class="col-span-4">
                Revenus nets
            </div>
            <div class="col-span-2 text-right">
                @php
                $revenus = $total_benefit - $total
                @endphp
                {{ number_format($revenus, 2) }}
            </div>
        </div>

    </section>


    <section class="mb-5 break-before-page mt-15">
        <div class="mx-auto max-w-5xl font-bold text-lg ">
            <h1 class="">Capital au 31 decembre 2025</h1>
        </div>
    </section>

    <section class="mb-5">
        @php
            $total = 0;
        @endphp
        <div class="mx-auto p-2 max-w-5xl grid grid-cols-6 gap-2">
            @foreach($items->clone()->where('balance_type', 'CAPITAL')->get() as $item)
                <div class="col-span-4">
                    {{ $item['description'] }}
                </div>
                <div class="col-span-2 text-right">
                    {{ number_format( abs( $item['amount'] ) / 100, 2) }}
                </div>
                @php
                $total += ($item['amount'] / 100);
                @endphp
            @endforeach
        </div>
        <div class="mx-auto p-2 max-w-5xl grid grid-cols-6 gap-2 font-bold border-t-2 border-b-2">
            <div class="col-span-4">
                Total
            </div>
            <div class="col-span-2 text-right">
                {{ number_format($total, 2) }}
            </div>
        </div>
    </section>

</body>
</html>
