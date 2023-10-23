@include('common.modalHead')

<div class="row">

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Categoría</label>
			<select wire:model='categoryid' class="form-control">
				<option value="Elegir" disabled>Elegir</option>
				@foreach($categories as $category)
				<option value="{{$category->id}}">{{$category->name}}</option>
				@endforeach
			</select>
			@error('categoryid') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>


	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Corte principal</label>
			<select wire:model='meatcutid' class="form-control" id="meatcutid">
				<option value="Elegir" disabled>Elegir</option>
				@foreach($cortes as $corte)
				<option value="{{$corte->id}}">{{$corte->name}}</option>
				@endforeach
			</select>
			@error('meatcutid') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Nombre</label>
			<input type="text" wire:model.lazy="name" class="form-control product-name" placeholder="ej: Nombre del producto" autofocus>
			@error('name') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Nivel</label>
			<select wire:model='levelproductid' class="form-control" id="levelproductid">
				<option value="Elegir" disabled>Elegir</option>
				@foreach($niveles as $nivel)
				<option value="{{$nivel->id}}">{{$nivel->name}}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Código</label>
			<input type="text" wire:model.lazy="code" class="form-control" placeholder="ej: PC001">
			@error('code') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>CódigoBarra</label>
			<input type="text" wire:model.lazy="barcode" class="form-control" {{ $selected_id > 0 ? 'disabled' : '' }} placeholder="ej: 7709876541">
			@error('barcode') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Precio mínino</label>
			<input type="text" wire:model.lazy="price_fama" class="form-control" placeholder="ej: 0.00">
			@error('price_fama') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Iva</label>
			<input type="text" wire:model.lazy="iva" class="form-control" placeholder="ej: 19.00 %">
			@error('iva') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<!-- 	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Precio ins</label>
			<input type="text" wire:model.lazy="price_insti" class="form-control" placeholder="ej: 0.00">
			@error('price_insti') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Precio horeca</label>
			<input type="text" wire:model.lazy="price_horeca" class="form-control" placeholder="ej: 0.00">
			@error('price_horeca') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Precio hogar</label>
			<input type="text" wire:model.lazy="price_hogar" class="form-control" placeholder="ej: 0.00">
			@error('price_hogar') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div> -->

	<!-- <div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Stock</label>
			<input type="number" wire:model.lazy="stock" class="form-control" placeholder="ej: 1000">
			@error('stock') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div> -->

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Stock Alertas</label>
			<input type="number" wire:model.lazy="alerts" class="form-control" placeholder="ej: 10">
			@error('alerts') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>


	<div class="col-sm-12 col-md-8">
		<div class="form-group custom-file">
			<input type="file" class="custom-file-input form-control" wire:model="image" accept="image/x-png, image/gif, image/jpeg">
			<label class="custom-file-label">Imágen {{$image}}</label>
			@error('image') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>



</div>

@section('script')
<script>
	document.addEventListener("livewire:load", function() {
		$('#meatcut--id').select2();

		Livewire.hook('message.processed', (message, component) => {
			$('#meatcut--id').select2();
		});
	});
</script>
@endsection



@include('common.modalFooter')