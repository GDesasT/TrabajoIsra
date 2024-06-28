@extends('templates.crud')

@section('title', 'Productoras')

@section('body')
<meta name="csrf-token" content="{{ csrf_token() }}">
<h1 class="h2">Productoras</h1>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#productoraModal" onclick="clearForm()">
        Añadir Productora
    </button>
    <input type="text" id="search-input" class="form-control mr-2" placeholder="Buscar por nombre...">
    <button id="search-btn" class="btn btn-secondary">Buscar <i class="bi bi-search"></i></button>
</div>

<table class="table table-sm table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Editar/Eliminar</th>
        </tr>
    </thead>
    <tbody id="productorasTableBody">
        
    </tbody>
</table>

<div class="modal fade" id="productoraModal" tabindex="-1" aria-labelledby="productoraModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="productoraForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="productoraModalLabel">Añadir/Editar Productora</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="productora_id" name="id">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var productoras = [];

    $(document).ready(function () {
        fetchProductoras();

        $('#productoraForm').on('submit', function (e) {
            e.preventDefault();

            let id = $('#productora_id').val();
            let url = id ? `/update/productora/${id}` : '/insert/productora';
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: $('#productoraForm').serialize(),
                success: function (response) {
                    $('#productoraModal').modal('hide');
                    fetchProductoras();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        $('#search-btn').on('click', function () {
            applyFiltersDes();
        });
    });

    function fetchProductoras() {
        $.get('/get/productoras', function (data) {
            productoras = data; 
            renderProductoras(productoras); 
        });
    }

    function renderProductoras(data) {
        let tableBody = $('#productorasTableBody');
        tableBody.empty();
        data.forEach(productora => {
            tableBody.append(`
                <tr>
                    <td>${productora.id}</td>
                    <td>${productora.nombre}</td>
                    <td>
                        <button class="btn btn-warning" onclick="editProductora(${productora.id})"><i class="bi bi-pencil-fill"></i></button>
                        <button class="btn btn-danger" onclick="deleteProductora(${productora.id})"><i class="bi bi-backspace-fill"></i></button>
                    </td>
                </tr>
            `);
        });
    }

    function applyFiltersDes() {
        let searchValue = $('#search-input').val().toLowerCase();

        let filteredProductoras = productoras.filter(function (productora) {
            let match = true;

            if (searchValue) {
                match = productora.nombre.toLowerCase().includes(searchValue);
            }

            return match;
        });

        renderProductoras(filteredProductoras);
    }

    function editProductora(id) {
        $.get(`/get/productora/${id}`, function (productora) {
            $('#productora_id').val(productora.id);
            $('#nombre').val(productora.nombre);
            $('#productoraModal').modal('show');
        });
    }

    function deleteProductora(id) {
        $.ajax({
            url: `/delete/productora/${id}`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'DELETE',
            success: function () {
                fetchProductoras();
            },
            error: function (error) {
                console.log(error);
            }
        });
    }


    function clearForm() {
        $('#productora_id').val('');
        $('#productoraForm')[0].reset();
    }
</script>
@endsection
