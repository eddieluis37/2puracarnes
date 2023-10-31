@include('common.modalHead')

<div class="row">

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Nombres</label>
			<input type="text" wire:model.lazy="name" class="form-control product-name" placeholder="ej: Nombre del cliente o proveedor" autofocus>
			@error('name') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Tipo de ID</label>
			<select wire:model='type_identificationid' class="form-control">
				<option value="Elegir" disabled>Elegir</option>
				@foreach($type_identifications as $type_identification)
				<option value="{{$type_identification->id}}">{{$type_identification->name}}</option>
				@endforeach
			</select>
			@error('type_identificationid') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>


	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Identificación</label>
			<input type="text" wire:model.lazy="identification" class="form-control" {{ $selected_id > 0 ? 'disabled' : '' }} placeholder="ej: 1018478965">
			@error('identification') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>DigitoVerificación</label>
			<input type="text" wire:model.lazy="digito_verificacion" class="form-control" placeholder="ej: 9">
			@error('digito_verificacion') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Centro-Costo</label>
			<select wire:model='officeid' class="form-control">
				<option value="Elegir" disabled>Elegir</option>
				@foreach($offices as $office)
				<option value="{{$office->id}}">{{$office->name}}</option>
				@endforeach
			</select>
			@error('officeid') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Acuerdo</label>
			<select wire:model='agreementid' class="form-control">
				<option value="Elegir" disabled>Elegir</option>
				@foreach($agreements as $agreement)
				<option value="{{$agreement->id}}">{{$agreement->name}}</option>
				@endforeach
			</select>
			@error('agreementid') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Tipo Regimen IVA</label>
			<select wire:model='type_regimen_ivaid' class="form-control">
				<option value="Elegir" disabled>Elegir</option>
				@foreach($type_regimen_ivas as $type_regimen_iva)
				<option value="{{$type_regimen_iva->id}}">{{$type_regimen_iva->name}}</option>
				@endforeach
			</select>
			@error('type_regimen_ivaid') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Dirección</label>
			<input type="text" wire:model.lazy="direccion" class="form-control" placeholder="ej: Calle 109 # 98 - 57">
			@error('direccion') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Ciudad</label>
			<select wire:model='provinceid' class="form-control">
				<option value="Elegir" disabled>Elegir</option>
				@foreach($provinces as $province)
				<option value="{{$province->id}}">{{$province->name}}</option>
				@endforeach
			</select>
			@error('provinceid') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Celular</label>
			<input type="number" wire:model.lazy="celular" class="form-control" placeholder="ej: 310 254 7899">
			@error('celular') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Nombre Contacto </label>
			<input type="text" wire:model.lazy="nombre_contacto" class="form-control" placeholder="ej: Juan Perez">
			@error('nombre_contacto') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Email</label>
			<input type="text" wire:model.lazy="correo" class="form-control" placeholder="ej: luis.gonzalez@gmail.com">
			@error('correo') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group form-check-inline">
			<input type="checkbox" wire:model.lazy="is_client" class="form-check-input" id="is_client">
			<label class="form-check-label" for="is_client">Cliente</label>
		</div>
	</div>

	<div class="col-sm-12 col-md-4">
		<div class="form-group form-check-inline">
			<input type="checkbox" wire:model.lazy="is_provider" class="form-check-input" id="is_provider">
			<label class="form-check-label" for="is_provider">Proveedor</label>
		</div>
	</div>
	<div class="col-sm-12 col-md-4">
		<div class="form-group form-check-inline">
			<input type="checkbox" wire:model.lazy="is_seller" class="form-check-input" id="is_seller">
			<label class="form-check-label" for="is_seller">Vendedor</label>
		</div>
	</div>
	<div class="col-sm-12 col-md-4">
		<div class="form-group form-check-inline">
			<input type="checkbox" wire:model.lazy="is_courier" class="form-check-input" id="is_courier">
			<label class="form-check-label" for="is_courier">Domiciliario</label>
		</div>
	</div>
	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Precios por nicho</label>
			<select wire:model='listaprecio_nichoId' class="form-control">
				<option value="Elegir" disabled>Elegir</option>
				@foreach($listapreciosN as $listaprecio)
				<option value="{{$listaprecio->id}}">{{$listaprecio->nombre}}</option>
				@endforeach
			</select>
			@error('provinceid') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>
	<div class="col-sm-12 col-md-4">
		<div class="form-group">
			<label>Precios standar</label>
			<select wire:model='listaprecio_genericId' class="form-control">
				<option value="Elegir" disabled>Elegir</option>
				@foreach($listapreciosG as $listaprecio)
				<option value="{{$listaprecio->id}}">{{$listaprecio->nombre}}</option>
				@endforeach
			</select>
			@error('provinceid') <span class="text-danger er">{{ $message}}</span>@enderror
		</div>
	</div>

</div>

@include('common.modalFooter')