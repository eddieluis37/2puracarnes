<div class="card">
    <div class="card-body d-flex justify-content-center">
        <div>
            <input type="hidden" value="0" name="transferId" id="transferId">
        </div>
        <div class="row g-12">
            <div class="col-md-6">
                <div class="task-header">
                    <div class="form-group">
                        <label for="" class="form-label">Centro costo origen</label>
                        <select class="form-control form-control-sm input" name="centrocostoorigen" id="centrocostoorigen" onchange="actualizarStockActualOrigen()" required>
                            <option value="">Seleccione el centro de costo</option>
                            @foreach($costcenter as $option)
                            <option value="{{ $option['id'] }}" data="{{$option}}">{{ $option['name'] }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-message"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="task-header">
                    <div class="form-group">
                        <label for="" class="form-label">Centro costo destino</label>
                        <select class="form-control form-control-sm input" name="centrocostodestino" id="centrocostodestino" onchange="ProductsByCostcenterDest(); actualizarStockActualDest()" required>
                            <option value="">Seleccione el centro de costo</option>
                            @foreach($costcenter as $option)
                            <option value="{{ $option['id'] }}" data="{{$option}}">{{ $option['name'] }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-message"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>