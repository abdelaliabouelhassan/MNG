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
  <div class="bg-red-500 mx-auto px-1 relative overflow-hidden  w-[76.2mm] h-[25.9mm]">
    <div
      class="w-4 absolute right-0 top-0 h-full  flex items-center justify-center
      
        bg-red-500
      
       
      "
     
    >
      <span
        class="text-xs text-black font-bold uppercase"
        style="writing-mode: vertical-lr"
      >
       dfdsfsdf
      </span>
    </div>

    <div
     class="absolute right-6 top-7 border min-h-1 border-black min-w-14 text-xs px-px text-black"
    >
   12
    </div>

    <div class="flex w-full items-start gap-4">
      <div class="w-[20mm] h-[20mm] overflow-hidden">
        <img
          src="{{ asset('storage/') }}"
          class="w-full h-full object-fill"
          alt=""
        />
      </div>
      <div class="flex flex-col items-start">
        <div class="h-4 overflow-hidden w-full">
          <h2 class="text-black font-bold text-[10px] mt-0.5">
           test lab
          </h2>
        </div>
    
        <p class="text-black font-bold text-[6px] leading-tight">
          <span> SUM OF CANNABINOIDS: </span>
          12
        </p>
        <p class="text-black font-bold text-[6px] leading-tight">
          <span> TOTAL THC: </span>
          12
        </p>
        <p class="text-black font-bold text-[6px] leading-tight">
          <span>TOTAL CBD: </span>
            12
        </p>
        <p class="text-black font-bold text-[6px] leading-tight">
          <span> PKG DATE: </span>
          12
        </p>
        <p class="text-black font-bold text-[6px] leading-tight">
          <span> BATCH: </span>
          12
        </p>
        <p class="text-black font-bold text-[6px] leading-tight">
          <span> UID: </span>
          12
        </p>
      </div>
    </div>

    <div class="flex justify-between pr-5   gap-1 w-full items-center pt-px ">
      <div>
        <p class="text-black font-bold text-[6px] leading-tight whitespace-nowrap">
          dsfsdfdsfsdf dsfdsfsd fsdf
        </p>
        <p class="text-black font-bold text-[6px] leading-tight">sfdsfds fsdfds fsdf</p>
      </div>


      <div class="h-[5.5mm] max-w-[25mm]">
        <!-- Barcode placeholder -->
      
          <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG('1', 'UPCA')}}" class=" w-full h-full" alt="Barcode">
       
       
    </div>

      
    </div>
  </div>
</body>
</html>