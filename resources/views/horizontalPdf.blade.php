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
  <div class="bg-white mx-auto px-2 relative overflow-hidden">
    <div
      class="w-10  absolute right-0 top-0 h-full flex items-center justify-center
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
        class="text-4xl text-black font-bold uppercase"
        style="writing-mode: vertical-lr"
      >
        {{ $request['strain_type'] }}
      </span>
    </div>

    <div
      class="absolute right-20 top-20 border-4 py-2 px-2 min-w-40 border-black"
    >
      <span class="text-4xl font-bold text-black"> {{ $request['sum_of_cannabinoids'] }}</span>
    </div>

    <div class="flex w-full items-start gap-4">
      <div class="w-[200px] h-[200px] overflow-hidden">
        <img
          src="{{ asset('storage/' . $logo->logo) }}"
          class="w-full h-full object-fill"
          alt=""
        />
      </div>
      <div class="flex flex-col items-start">
        <div class="h-14 overflow-hidden w-full">
          <h2 class="text-black font-bold text-4xl mt-2 ">
            {{ $request['strain_name'] }}
          </h2>
        </div>
    
        <p class="text-black font-bold text-lg">
          <span> SUM OF CANNABINOIDS: </span>
          {{ $request['sum_of_cannabinoids'] }}
        </p>
        <p class="text-black font-bold text-lg">
          <span> TOTAL THC: </span>
          {{ $request['total_thc'] }}
        </p>
        <p class="text-black font-bold text-lg">
          <span>TOTAL CBD: </span>
          {{ $request['total_cbd'] }}
        </p>
        <p class="text-black font-bold text-lg">
          <span> PKG DATE: </span>
          {{ $request['pkg_date'] }}
        </p>
        <p class="text-black font-bold text-lg">
          <span> BATCH: </span>
          {{ $request['batch'] }}
        </p>
        <p class="text-black font-bold text-lg">
          <span> UID: </span>
          {{ $request['uid'] }}
        </p>
      </div>
    </div>

    <div class="flex justify-between gap-4 w-full items-center pt-[20px] pr-10 pb-4">
      <div>
        <p class="text-black font-bold text-lg whitespace-nowrap">
           {{ $request['distro_name'] }}
        </p>
        <p class="text-black font-bold text-lg">{{$request['license']}}</p>
      </div>

      <div class=" h-[59px] max-w-[400px] w-full ">
        {{-- <img class=" w-full h-full object-fill" src="data:image/jpeg;base64,{{DNS1D::getBarcodeJPG($request['barcode_data'], 'C128')}}" alt="barcode"   /> --}}
        {{-- {!! DNS1D::getBarcodeHTML($request['barcode_data'], 'C128', 3, 59) !!} --}}
      </div>
    </div>
  </div>
</body>
</html>