@extends('layouts.theme.app')

@section('content')
<div class="container">
    <h1>Arrastrar y Soltar</h1>

    <h2>Tabla de Origen</h2>
    <div id="tabla-origen">
        @foreach($listaprecios as $listaprecio)
        <div class="drag-item" data-listaprecio-id="{{ $listaprecio->id }}">{{ $listaprecio->nombre }}</div>
        @endforeach
    </div>

    <h2>Tabla de Destino</h2>
    <div id="tabla-destino" class="drop-area"></div>
</div>


<script>
    $(function() {
        $('.drag-item').draggable({
            revert: 'invalid',
            cursor: 'move'
        });

        $('.drop-area').droppable({
            accept: '.drag-item',
            drop: function(event, ui) {
                var listaprecioId = $(ui.draggable).data('listaprecio-id');
                $(this).append(ui.draggable);

                // Realiza una solicitud AJAX para manejar el arrastrar y soltar en el backend
                $.ajax({
                    url: '/drag-drop',
                    type: 'POST',
                    data: {
                        listaprecio_id: listaprecioId
                    },
                    success: function(response) {
                        console.log(response.message);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
    });
</script>
@endsection

@section('script')

@endsection