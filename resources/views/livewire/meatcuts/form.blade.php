@include('common.modalHead')

<div class="row">

	<div class="col-sm-12 col-md-8">
		<div class="form-group">
			<label>Nombre</label>
			<input type="text" wire:model.lazy="name" class="form-control product-name" placeholder="ej: Nombre del producto" autofocus>
			@error('name') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Descripción</label>
			<input type="text" wire:model.lazy="description" class="form-control" placeholder="ej: No tiene hijos">
			@error('description') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	
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
	
</div>

@include('common.modalFooter')
