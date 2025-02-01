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
    <div class="w-full flex items-end h-[290px] overflow-hidden gap-2 bg-white py-2 pr-2">
        <div class="flex flex-col items-start gap-2">
                <div class="w-40 h-40 bg-gray-500 -rotate-90">
                    <img
                    src="{{ asset('storage/' . $logo->logo) }}"
                    class="w-full h-full object-fill"
                    alt=""
                    />
                </div>
                <div class="w-full flex flex-col items-end">
                    <div class="w-full h-10   @if ($request['strain_type'] == 'sativa')
                bg-red-500
                @elseif($request['strain_type'] == 'hybrid')
                bg-orange-400
                @else
                bg-blue-400
            @endif"></div>
            <span class="text-4xl text-black font-bold uppercase mr-2 mt-1"
              >   {{ $request['strain_type'] }}</span
            >
          </div>
        </div>
  
        <div
          class="text-black font-bold text-2xl overflow-hidden "
          style="writing-mode: sideways-lr"
        >
          <p  class="whitespace-nowrap">{{ $request['name_one'] }}</p>
          <p  class="whitespace-nowrap">{{ $request['name_two'] }}</p>
        </div>
  
        <div class="flex h-full items-end gap-2">
          <div
            class="text-black font-bold text-xl border-4 border-black"
            style="writing-mode: sideways-lr"
          >
            <div class="pt-4 pb-1">
              <span class="px-4 font-black whitespace-nowrap">SUM OF CANNABINOIDS:</span>
            </div>
            <p class="text-5xl font-bold pb-1">
                {{ $request['sum_of_cannabinoids'] }}
            </p>
          </div>
  
          <div class="flex flex-col items-start">
            <div class="h-20 max-w-[365px]">
              <img  class="w-full h-full" src="data:image/jpeg;base64,{{DNS1D::getBarcodeJPG($request['barcode_data'], 'C128')}}" alt="barcode"   />
            </div>
            <p class="text-black font-bold text-lg">
              <span> SUM OF CANNABINOIDS: </span>
              {{ $request['sum_of_cannabinoids'] }}
            </p>
         <div class=" grid grid-cols-2 gap-2">
            <p class="text-black font-bold text-lg">
                <span> TOTAL THC: </span>
                {{ $request['total_thc'] }}
              </p>
              <p class="text-black font-bold text-lg">
                <span>TOTAL CBD: </span>
                {{ $request['total_cbd'] }}
              </p>
         </div>
            <p class="text-black font-bold text-lg">
                <span>DISTRO: </span>
                {{ $request['distro_name'] }}
              </p>
              <p class="text-black font-bold text-lg">
                <span>LICENSE# </span>
                {{$request['license']}}
              </p>
              <p class="text-black font-bold text-lg">
                <span> BATCH: </span>
                {{ $request['batch'] }}
              </p>
            <p class="text-black font-bold text-lg">
              <span> {{ $request['name_one'] . ' ' .  $request['name_two']  }} - PKG'D: </span>
              {{ $request['pkg_date'] }}
            </p>
           
            <p class="text-black font-bold text-lg">
              <span> UID: </span>
              {{ $request['uid'] }}
            </p>
          </div>
        </div>
      </div>
</body>
</html>