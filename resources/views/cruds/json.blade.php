@extends('templates.crud')

@section('styles')
<style>
.container {
    margin-top: 50px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.card {
    border: none;
    width: 100%;
    max-width: 500px;
}

.card-body {
    padding: 30px;
}

.card-title {
    font-size: 1.5rem;
    margin-bottom: 20px;
}

.btn-custom {
    border-radius: 25px;
    padding: 10px 20px;
    margin-top: 20px;
    margin-left: 10px;
}

.table {
    width: 100%;
    margin-top: 20px;
    border: none;
    border-radius: 10px;
    overflow: hidden;
    background-color: #ffffff;
}

.table th,
.table td {
    padding: 12px;
    text-align: center;
    border: 1px solid #dee2e6;
}

.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}

.select-custom {
    width: 100%;
    margin-top: 20px;
}
</style>
@endsection

@section('title', 'Json')

@section('body')
<body>
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title">Agregar Clave y Valor</h4>
            <div class="form-group">
                <label for="key">Key</label>
                <input type="text" class="form-control" id="key" name="key">
            </div>
            <div class="form-group">
                <label for="value">Value</label>
                <input type="text" class="form-control" id="value" name="value">
            </div>
            <button type="button" class="btn btn-danger btn-custom" onclick="addKeyValue()">Insertar datos</button>
            <button type="button" class="btn btn-warning btn-custom" onclick="createObject()">Crear objeto</button>
        </div>
    </div>
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <select id="selectObject" class="form-control select-custom" onchange="objectData()">
                <option value="-1">Usa un objeto</option>
            </select>
        </div>
    </div>
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h4 class="card-title">Datos del objeto</h4>
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered mt-3">
                    <thead class="thead-dark">
                        <tr>
                            <th>Key</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
@endsection

@section('js')
<script>
let object = [];
let currentObjectIndex = -1;

function addKeyValue() {
    let key = document.getElementById('key').value;
    let value = document.getElementById('value').value;

    if (key && value) {
        if (currentObjectIndex !== -1) {
            object[currentObjectIndex][key] = value;
            document.getElementById('key').value = "";
            document.getElementById('value').value = "";
            objectData();
        }
    }
}

function createObject() {
    let newObject = {};
    object.push(newObject);
    currentObjectIndex = object.length - 1;
    updateData();
    objectData();
}

function updateData() {
    let select = document.getElementById('selectObject');
    select.innerHTML = '';
    object.forEach((obj, index) => {
        let option = document.createElement('option');
        option.value = index;
        option.text = `objeto ${index + 1}`;
        select.add(option);
    });
    select.value = currentObjectIndex;
}

function objectData() {
    let select = document.getElementById('selectObject');
    currentObjectIndex = select.value;

    let tbody = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
    tbody.innerHTML = '';

    let selectedObject = object[currentObjectIndex];
    for (let key in selectedObject) {
        let row = tbody.insertRow();
        let cellKey = row.insertCell(0);
        let cellValue = row.insertCell(1);
        cellKey.textContent = key;
        cellValue.textContent = selectedObject[key];
    }
}
</script>
@endsection
