@extends('templates.app')

@section('title', 'Gestión de Alumnos')

@section('content')
  <h1 class="text-center">Gestión de Alumnos</h1>
  <div class="mb-3">
    <div class="form-inline d-flex justify-content-center align-items-center">
      <button type="button" id="btn_agregar" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregar">Agregar <i class="bi bi-person-add"></i></button>
      <label for="search-field" class="mr-2">Buscar por:</label>
      <select id="search-field" class="form-control mr-2">
        <option value="matricula">Matrícula</option>
        <option value="nombre">Nombre</option>
        <option value="apellido">Apellido</option>
      </select>
      <input type="text" id="search-input" class="form-control mr-2" placeholder="Buscar...">
      <label for="start-date" class="mr-2">Fecha Desde:</label>
      <input type="date" id="start-date" class="form-control mr-2">
      <label for="end-date" class="mr-2">Hasta:</label>
      <input type="date" id="end-date" class="form-control mr-2">
      <label for="sort-by" class="mr-2">Ordenar por:</label>
      <select id="sort-by" class="form-control mr-2">
        <option value="asc-imc">Ascendente IMC</option>
        <option value="desc-imc">Descendente IMC</option>
        <option value="asc-matricula">Ascendente Matrícula</option>
        <option value="desc-matricula">Descendente Matrícula</option>
        <option value="asc-peso">Ascendente Peso</option>
        <option value="desc-peso">Descendente Peso</option>
        <option value="asc-estatura">Ascendente Estatura</option>
        <option value="desc-estatura">Descendente Estatura</option>
        <option value="asc-nombre">Orden alfabetico (nombre) A-Z</option>
        <option value="desc-nombre">Orden alfabetico (nombre) Z-A</option>
        <option value="asc-apellido">Orden alfabetico (apellido) A-Z</option>
        <option value="desc-apellido">Orden alfabetico (apellido) Z-A</option>
      </select>
      <button id="search-btn" class="btn btn-success">Buscar <i class="bi bi-search"></i></button>
    </div>
  </div>
  <table class="table table-sm table-bordered" id="listaAlumnos">
    <thead class="table-dark">
      <tr>
        <th scope="col">Matricula</th>
        <th scope="col">Nombre</th>
        <th scope="col">Apellido</th>
        <th scope="col">Peso</th>
        <th scope="col">Estatura</th>
        <th scope="col">IMC</th>
        <th scope="col">Clasificacion</th>
        <th scope="col">Fecha Nacimiento</th>
        <th scope="col">Borrar</th>
        <th scope="col">Editar</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
  <pre id="json-output" class="mt-3"></pre>

  <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Agrega el alumno</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p id="student-form">
            <label for="matricula">Matricula:</label>
            <input type="text" id="matricula" class="form-control mr-2">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" class="form-control mr-2">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" class="form-control mr-2">
            <label for="fecha">Fecha Nacimiento:</label>
            <input type="date" id="fecha" class="form-control mr-2">
            <label for="peso">Peso:</label>
            <input type="text" id="peso" class="form-control mr-2">
            <label for="estatura">Estatura:</label>
            <input type="text" id="estatura" class="form-control mr-2">
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="confirmarAgregarAlumno()">Guardar Alumno</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    var alumnos = [];
    var alumnoEditando = null;

    function dibujarAlumnos() {
      var listaAlumnos = document.querySelector('#listaAlumnos tbody');
      listaAlumnos.innerHTML = '';
      alumnos.forEach(function(alumno, index) {
        var imc = (alumno.peso / Math.pow(alumno.estatura, 2)).toFixed(2);
        var tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${alumno.matricula}</td>
          <td>${alumno.nombre}</td>
          <td>${alumno.apellido}</td>
          <td>${alumno.peso}</td>
          <td>${alumno.estatura}</td>
          <td>${imc}</td>
          <td>${clasificarIMC(imc)}</td>
          <td>${alumno.fecha}</td>
          <td><button type="button" class="btn btn-danger" onclick="borrarAlumno(${index})"><i class="bi bi-backspace-fill"></i></button></td>
          <td><button type="button" class="btn btn-success" onclick="prepararEditarAlumno(${index})"><i class="bi bi-pencil-fill"></i></button></td>
        `;
        listaAlumnos.appendChild(tr);
      });
    }

    function prepararAgregarAlumno() {
      alumnoEditando = null;
      limpiarInputs();
      document.querySelector('.modal-title').innerText = 'Agrega el alumno';
      document.querySelector('.btn-primary').innerText = 'Guardar Alumno';
    }

    function prepararEditarAlumno(index) {
      alumnoEditando = index;
      var alumno = alumnos[index];
      document.getElementById('matricula').value = alumno.matricula;
      document.getElementById('nombre').value = alumno.nombre;
      document.getElementById('apellido').value = alumno.apellido;
      document.getElementById('fecha').value = alumno.fecha;
      document.getElementById('peso').value = alumno.peso;
      document.getElementById('estatura').value = alumno.estatura;
      document.querySelector('.modal-title').innerText = 'Editar alumno';
      document.querySelector('.btn-primary').innerText = 'Actualizar Alumno';
      var modal = new bootstrap.Modal(document.getElementById('modalAgregar'));
      modal.show();
    }

    function confirmarAgregarAlumno() {
      var nuevaMatricula = document.getElementById('matricula').value;
      var nuevoNombre = document.getElementById('nombre').value;
      var nuevoApellido = document.getElementById('apellido').value;
      var nuevaFecha = document.getElementById('fecha').value;
      var nuevoPeso = document.getElementById('peso').value;
      var nuevaEstatura = document.getElementById('estatura').value;
      if (nuevaMatricula && nuevoNombre && nuevoApellido && nuevaFecha && nuevoPeso && nuevaEstatura) {
        var alumno = { matricula: nuevaMatricula, nombre: nuevoNombre, apellido: nuevoApellido, fecha: nuevaFecha, peso: nuevoPeso, estatura: nuevaEstatura };
        if (alumnoEditando !== null) {
          alumnos[alumnoEditando] = alumno;
          alumnoEditando = null;
        } else {
          alumnos.push(alumno);
        }
        dibujarAlumnos();
        limpiarInputs();
        cerrarModal();
      } else {
        alert('Por favor, complete todos los campos.');
      }
    }

    function limpiarInputs() {
      document.getElementById('matricula').value = '';
      document.getElementById('nombre').value = '';
      document.getElementById('apellido').value = '';
      document.getElementById('fecha').value = '';
      document.getElementById('peso').value = '';
      document.getElementById('estatura').value = '';
    }

    function borrarAlumno(index) {
      alumnos.splice(index, 1);
      dibujarAlumnos();
    }

    function clasificarIMC(imc) {
      if (imc < 18.5) return 'Bajo peso';
      else if (imc < 24.9) return 'Peso normal';
      else if (imc < 29.9) return 'Sobrepeso';
      else if (imc >= 30) return 'Obesidad';
      return '';
    }

    function cerrarModal() {
      var modalElement = document.getElementById('modalAgregar');
      var modal = bootstrap.Modal.getInstance(modalElement);
      modal.hide();
    }

    document.addEventListener('DOMContentLoaded', function() {
      dibujarAlumnos();

      document.getElementById('search-btn').addEventListener('click', function() {
        var searchField = document.getElementById('search-field').value;
        var searchValue = document.getElementById('search-input').value.toLowerCase();
        var startDate = document.getElementById('start-date').value;
        var endDate = document.getElementById('end-date').value;
        var sortBy = document.getElementById('sort-by').value;

        var filteredAlumnos = alumnos.filter(function(alumno) {
          var match = true;
          if (searchField && searchValue) {
            match = alumno[searchField].toLowerCase().includes(searchValue);
          }
          if (startDate) {
            match = match && (alumno.fecha >= startDate);
          }
          if (endDate) {
            match = match && (alumno.fecha <= endDate);
          }
          return match;
        });

        if (sortBy === 'asc-imc') {
          filteredAlumnos.sort(function(a, b) {
            return (a.peso / Math.pow(a.estatura, 2)) - (b.peso / Math.pow(b.estatura, 2));
          });
        } else if (sortBy === 'desc-imc') {
          filteredAlumnos.sort(function(a, b) {
            return (b.peso / Math.pow(b.estatura, 2)) - (a.peso / Math.pow(a.estatura, 2));
          });
        } else if (sortBy === 'asc-matricula') {
          filteredAlumnos.sort(function(a, b) {
            return a.matricula.localeCompare(b.matricula);
          });
        } else if (sortBy === 'desc-matricula') {
          filteredAlumnos.sort(function(a, b) {
            return b.matricula.localeCompare(a.matricula);
          });
        } else if (sortBy === 'asc-peso') {
          filteredAlumnos.sort(function(a, b) {
            return a.peso - b.peso;
          });
        } else if (sortBy === 'desc-peso') {
          filteredAlumnos.sort(function(a, b) {
            return b.peso - a.peso;
          });
        } else if (sortBy === 'asc-estatura') {
          filteredAlumnos.sort(function(a, b) {
            return a.estatura - b.estatura;
          });
        } else if (sortBy === 'desc-estatura') {
          filteredAlumnos.sort(function(a, b) {
            return b.estatura - a.estatura;
          });
        } else if (sortBy === 'asc-nombre') {
          filteredAlumnos.sort(function(a, b) {
            return a.nombre.localeCompare(b.nombre);
          });
        } else if (sortBy === 'desc-nombre') {
          filteredAlumnos.sort(function(a, b) {
            return b.nombre.localeCompare(a.nombre);
          });
        } else if (sortBy === 'asc-apellido') {
          filteredAlumnos.sort(function(a, b) {
            return a.apellido.localeCompare(b.apellido);
          });
        } else if (sortBy === 'desc-apellido') {
          filteredAlumnos.sort(function(a, b) {
            return b.apellido.localeCompare(a.apellido);
          });
        }

        var listaAlumnos = document.querySelector('#listaAlumnos tbody');
        listaAlumnos.innerHTML = '';
        filteredAlumnos.forEach(function(alumno, index) {
          var imc = (alumno.peso / Math.pow(alumno.estatura, 2)).toFixed(2);
          var tr = document.createElement('tr');
          tr.innerHTML = `
            <td>${alumno.matricula}</td>
            <td>${alumno.nombre}</td>
            <td>${alumno.apellido}</td>
            <td>${alumno.peso}</td>
            <td>${alumno.estatura}</td>
            <td>${imc}</td>
            <td>${clasificarIMC(imc)}</td>
            <td>${alumno.fecha}</td>
            <td><button type="button" class="btn btn-danger" onclick="borrarAlumno(${index})"><i class="bi bi-backspace-fill"></i></button></td>
            <td><button type="button" class="btn btn-success" onclick="prepararEditarAlumno(${index})"><i class="bi bi-pencil-fill"></i></button></td>
          `;
          listaAlumnos.appendChild(tr);
        });
      });
    });
  </script>
@endsection
