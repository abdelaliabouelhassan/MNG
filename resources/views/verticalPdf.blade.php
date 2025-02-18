<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="w-full">
    <div class="w-[76.2mm] h-[25.4mm] flex items-end overflow-hidden gap-1 bg-white py-0.5 pr-0.5">
        <!-- Left section with logo and strain type -->
        <div class="flex flex-col items-start gap-0.5">
            <div class="w-[15mm] h-[15mm] bg-gray-500 -rotate-90">
                <img
                    src="{{ asset('storage/' . $logo->logo) }}"
                    class="w-full h-full object-fill"
                    alt=""
                />
            </div>
            <div class="w-full flex flex-col items-end">
                <div class="w-full h-2 @if ($request['strain_type'] == 'sativa')
                    bg-red-500
                    @elseif($request['strain_type'] == 'hybrid')
                    bg-orange-400
                    @else
                    bg-blue-400
                    @endif">
                </div>
                <span class="text-xs text-black font-bold uppercase mr-0.5 mt-0.5">
                    {{ $request['strain_type'] }}
                </span>
            </div>
        </div>

        <!-- Middle section with product name -->
        <div class="text-black font-bold text-xs overflow-hidden" style="writing-mode: sideways-lr">
            <p class="whitespace-nowrap">{{ $request['name_one'] }}</p>
            <p class="whitespace-nowrap">{{ $request['name_two'] }}</p>
        </div>

        <!-- Right section with cannabinoid info and details -->
        <div class="flex h-full items-end gap-1">
            <div class="text-black font-bold text-xs border border-black" style="writing-mode: sideways-lr">
                <div class="pt-1 pb-0.5">
                    <span class="px-1 font-black whitespace-nowrap text-[6.9px]">SUM OF CANNABINOIDS:</span>
                </div>
                <p class="text-sm font-bold pb-0.5">
                    {{ $request['sum_of_cannabinoids'] }}
                </p>
            </div>

            <div class="flex flex-col items-start">
                <div class="h-[8mm] max-w-[25mm]">
                    <!-- Barcode -->
                    @if ($request['barcode_data'])
                      <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($request['barcode_data'], 'UPCA')}}" class=" w-full h-full" alt="Barcode">
                    @endif
                   
                </div>
                <p class="text-black font-bold text-[8px] leading-tight">
                    <span>SUM OF CANNABINOIDS:</span>
                    {{ $request['sum_of_cannabinoids'] }}
                </p>
                <div class="grid grid-cols-2 gap-1">
                    <p class="text-black font-bold text-[8px] leading-tight">
                        <span>TOTAL THC:</span>
                        {{ $request['total_thc'] }}
                    </p>
                    <p class="text-black font-bold text-[8px] leading-tight">
                        <span>TOTAL CBD:</span>
                        {{ $request['total_cbd'] }}
                    </p>
                </div>
                <p class="text-black font-bold text-[8px] leading-tight">
                    <span>DISTRO:</span>
                    {{ $request['distro_name'] }}
                </p>
                <p class="text-black font-bold text-[8px] leading-tight">
                    <span>LICENSE#</span>
                    {{$request['license']}}
                </p>
                <p class="text-black font-bold text-[8px] leading-tight">
                    <span>BATCH:</span>
                    {{ $request['batch'] }}
                </p>
                <p class="text-black font-bold text-[8px] leading-tight">
                    <span>{{ $request['name_one'] . ' ' .  $request['name_two']  }} - PKG'D:</span>
                    {{ $request['pkg_date'] }}
                </p>
                <p class="text-black font-bold text-[8px] leading-tight">
                    <span>UID:</span>
                    {{ $request['uid'] }}
                </p>
            </div>
        </div>
    </div>
</body>
</html>