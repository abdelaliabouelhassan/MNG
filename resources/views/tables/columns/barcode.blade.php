<div>
  @if ($getRecord()->barcode)
  <div class=" w-full bg-white p-2">
    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($getRecord()->barcode, 'UPCA',2,70)}}" class=" w-full h-full" alt="Barcode">
  </div>

  @else
  -
  @endif
   
    
</div>
