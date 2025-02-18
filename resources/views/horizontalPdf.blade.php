<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="w-full h-10 overflow-hidden">
  <div class="bg-white mx-auto px-1 relative overflow-hidden  w-[76.2mm] h-[25.9mm]">
    <div
      class="w-4 absolute right-0 top-0 h-full  flex items-center justify-center
      @if ($request['strain_type'] == 'sativa')
        bg-red-500
        @elseif($request['strain_type'] == 'hybrid')
        bg-orange-400
        @else
        bg-blue-400
      @endif
      "
     
    >
      <span
        class="text-xs text-black font-bold uppercase"
        style="writing-mode: vertical-lr"
      >
        {{ $request['strain_type'] }}
      </span>
    </div>

    <div
     class="absolute right-6 top-7 border min-h-1 border-black min-w-14 text-xs px-px text-black"
    >
    {{ $request['sum_of_cannabinoids'] }}
    </div>

    <div class="flex w-full items-start gap-4">
      <div class="w-[20mm] h-[20mm] overflow-hidden">
        <img
          src="{{ asset('storage/' . $logo->logo) }}"
          class="w-full h-full object-fill"
          alt=""
        />
      </div>
      <div class="flex flex-col items-start">
        <div class="h-4 overflow-hidden w-full">
          <h2 class="text-black font-bold text-[10px] mt-0.5">
            {{ $request['strain_name'] }}
          </h2>
        </div>
    
        <p class="text-black font-bold text-[6px] leading-tight">
          <span> SUM OF CANNABINOIDS: </span>
          {{ $request['sum_of_cannabinoids'] }}
        </p>
        <p class="text-black font-bold text-[6px] leading-tight">
          <span> TOTAL THC: </span>
          {{ $request['total_thc'] }}
        </p>
        <p class="text-black font-bold text-[6px] leading-tight">
          <span>TOTAL CBD: </span>
          {{ $request['total_cbd'] }}
        </p>
        <p class="text-black font-bold text-[6px] leading-tight">
          <span> PKG DATE: </span>
          {{ $request['pkg_date'] }}
        </p>
        <p class="text-black font-bold text-[6px] leading-tight">
          <span> BATCH: </span>
          {{ $request['batch'] }}
        </p>
        <p class="text-black font-bold text-[6px] leading-tight">
          <span> UID: </span>
          {{ $request['uid'] }}
        </p>
      </div>
    </div>

    <div class="flex justify-between gap-x-1 mb-1 pr-5  w-full items-center pt-px ">
      <div>
        <p class="text-black font-bold text-[6px] leading-tight whitespace-nowrap">
           {{ $request['distro_name'] }}
        </p>
        <p class="text-black font-bold text-[6px] leading-tight">{{$request['license']}}</p>
      </div>

      <div class="h-[5.4mm] max-w-[25mm]">
        <!-- Barcode -->
        @if ($request['barcode_data'])
           <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($request['barcode_data'], 'UPCA')}}" class=" w-full h-full" alt="Barcode">
        @endif
     </div>

      
    </div>
  </div>
</body>
</html>