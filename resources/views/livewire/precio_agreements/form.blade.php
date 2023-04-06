@include('common.modalHead')

<div class="row">
	
<div class="col-sm-12 col-md-4">
	<div class="form-group">
		<label>Línea</label>
		<select wire:model='line' class="form-control">
					<option value="Elegir" selected>Elegir</option>	
					<option value="HOGAR">Hogar</option>
					<option value="HORECA">Horeca</option>
					<option value="INSTITUCIONAL">Institucional</option>
					<option value="FAMAS">Famas</option>								
		</select>
		@error('line') <span class="text-danger er">{{ $message}}</span>@enderror		
	</div>
</div>

<div class="col-sm-12 col-md-4">
	<div class="form-group">
		<label>Acuerdo</label>
		<select wire:model='agreementid' class="form-control">
			<option value="Elegir" disabled>Elegir</option>
			@foreach($agreements as $agreement)
			<option value="{{$agreement->id}}" >{{$agreement->name}}</option>
			@endforeach
		</select>
		@error('agreementid') <span class="text-danger er">{{ $message}}</span>@enderror
	</div>
</div>

<div class="col-sm-12 col-md-4">
	<div class="form-group">
		<label >Producto</label>
		<select wire:model='productid' class="form-control">
			<option value="Elegir" disabled>Elegir</option>
			@foreach($products as $product)
			<option value="{{$product->id}}" >{{$product->name}}</option>
			@endforeach
		</select>		
		@error('productid') <span class="text-danger er">{{ $message}}</span>@enderror
	</div>
</div>

<div class="col-sm-12 col-md-4">
	<div class="form-group">
		<label >Precio</label>
		<input type="number"  wire:model.lazy="precio" class="form-control" placeholder="ej: 35000" >
		@error('precio') <span class="text-danger er">{{ $message}}</span>@enderror
	</div>
</div>

<div class="col-sm-12 col-md-4">
	<div class="form-group">
		<label >Vendedor</label>                          
          <select wire:model="vendedor" class="form-control">
                 <option value="Elegir" disabled>Elegir</option>
                   @foreach($users as $user)
                  <option value="{{$user->id}}">{{$user->name}}</option>
                   @endforeach
          </select>                              
		@error('vendedor') <span class="text-danger er">{{ $message}}</span>@enderror
	</div>
</div>

<div class="col-sm-12 col-md-4">
	<div class="form-group">
		<label >Descuento</label>
		<input type="number"  wire:model.lazy="descuento" class="form-control" placeholder="ej: 100" >
		@error('descuento') <span class="text-danger er">{{ $message}}</span>@enderror
	</div>
</div>


</div>


@include('common.modalFooter')
