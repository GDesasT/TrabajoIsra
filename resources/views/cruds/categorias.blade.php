@extends('templates.crud')

@section('title', 'Categorias')

@section('body')
<meta name="csrf-token" content="{{ csrf_token() }}">
<h1 class="h2">Categorias</h1>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#categoriaModal" onclick="clearForm()">
        Añadir Categoria
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
    <tbody id="categoriasTableBody">
        
    </tbody>
</table>

<div class="modal fade" id="categoriaModal" tabindex="-1" aria-labelledby="categoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="categoriaForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="categoriaModalLabel">Añadir/Editar Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="categoria_id" name="id">
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
    $(document).ready(function () {
        fetchCategorias();

        $('#categoriaForm').on('submit', function (e) {
            e.preventDefault();
            console.log("llega")
            let id = $('#categoria_id').val();
            console.log(id)
            let url = id ? `/update/categoria/${id}` : '/insert/categoria';
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: $('#categoriaForm').serialize(),
                success: function (response) {
                    $('#categoriaModal').modal('hide');
                    fetchCategorias();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
        $('#search-btn').on('click', function () {
        applyFiltersCat();
        });
    });


    function fetchCategorias() {
        $.get('/get/categorias', function (data) {
            categorias = data; 
            renderCategorias(categorias); 
        });
    }

    function renderCategorias(data) {
        let tableBody = $('#categoriasTableBody');
        tableBody.empty();
        data.forEach(categoria => {
            tableBody.append(`
                <tr>
                    <td>${categoria.id}</td>
                    <td>${categoria.nombre}</td>
                    <td>
                        <button class="btn btn-warning" onclick="editCategoria(${categoria.id})"><i class="bi bi-pencil-fill"></i></button>
                        <button class="btn btn-danger" onclick="deleteCategoria(${categoria.id})"><i class="bi bi-backspace-fill"></i></button>
                    </td>
                </tr>
            `);
        });
    }

    function applyFiltersCat() {
        let searchValue = $('#search-input').val().toLowerCase();

        let filteredCategorias = categorias.filter(function (categoria) {
            let match = true;

            if (searchValue) {
                match = categoria.nombre.toLowerCase().includes(searchValue);
            }

            return match;
        });

        renderCategorias(filteredCategorias);
    }


    function editCategoria(id) {
        $.get(`/get/categoria/${id}`, function (categoria) {
            $('#categoria_id').val(categoria.id);
            $('#nombre').val(categoria.nombre);
            $('#categoriaModal').modal('show');
        });
    }

    function deleteCategoria(id) {
        $.ajax({
            url: `/delete/categoria/${id}`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'DELETE',
            success: function () {
                fetchCategorias();
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function clearForm() {
        $('#categoria_id').val('');
        $('#categoriaForm')[0].reset();
    }

    
        
</script>
@endsection