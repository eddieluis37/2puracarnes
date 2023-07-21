@extends('layouts.app')
 @section('content')
    <h1>Transferencia de productos</h1>
     @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
     <form action="{{ route('transfer.store') }}" method="POST">
        @csrf
         <div>
            <label for="from_cost_center_id">Centro de costo de origen:</label>
            <select id="from_cost_center_id" name="from_cost_center_id">
                @foreach ($costCenters as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
         <div>
            <label for="to_cost_center_id">Centro de costo de destino:</label>
            <select id="to_cost_center_id" name="to_cost_center_id">
                @foreach ($costCenters as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
         <div>
            <label for="product_id">Producto:</label>
            <select id="product_id" name="product_id">
                @foreach ($products as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
         <div>
            <label for="quantity">Cantidad:</label>
            <input type="number" id="quantity" name="quantity" min="1">
        </div>
         <button type="submit">Transferir</button>
    </form>
@endsection