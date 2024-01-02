<div class="card">
  <div class="card-body">
    <div>
      <input type="hidden" value="0" name="transferId" id="transferId">
    </div>
    <div class="row g-3 justify-content-center"> <!-- Añadido justify-content-center para centrar los campos horizontalmente -->
 
      <div class="col">
        <div class="task-header">
          <div class="form-group">
            <label for="centrocostoOrigen" class="form-label">Centro de costo origen</label>
            <select class="form-control form-control-sm input" name="centrocostoOrigen" id="centrocostoOrigen" required>
              <option value="">Seleccione el centro de costo</option>
              @foreach($centros as $option)
              <option value="{{ $option['id'] }}" data="{{ $option }}">{{ $option['name'] }}</option>
              @endforeach
            </select>
            <span class="text-danger error-message"></span>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="task-header">
          <div class="form-group">
            <label for="centrocostoDestino" class="form-label">Centro de costo Destino</label>
            <select class="form-control form-control-sm input" name="centrocostoDestino" id="centrocostoDestino" required>
              <option value="">Seleccione el centro de costo</option>
              @foreach($centros as $option)
              <option value="{{ $option['id'] }}" data="{{ $option }}">{{ $option['name'] }}</option>
              @endforeach
            </select>
            <span class="text-danger error-message"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>