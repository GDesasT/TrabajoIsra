@extends('templates.app')

@section('title', 'Gestión de Alumnos')

@section('content')

    <div class="container mt-5">
        <h1 class="text-center">Gestión de Alumnos</h1>
        <button id="add-student-btn" class="btn btn-primary mb-3" data-toggle="modal" data-target="#studentModal">Agregar Alumno</button>
        
        <div class="mb-3">
            <div class="form-inline">
                <label for="search-field" class="mr-2">Buscar por:</label>
                <select id="search-field" class="form-control mr-2">
                    <option value="matricula">Matrícula</option>
                    <option value="nombre">Nombre</option>
                    <option value="apellido">Apellido</option>
                </select>
                <input type="text" id="search-input" class="form-control mr-2" placeholder="Buscar...">
                <label for="start-date" class="mr-2">Fecha de Nacimiento Desde:</label>
                <input type="date" id="start-date" class="form-control mr-2">
                <label for="end-date" class="mr-2">Hasta:</label>
                <input type="date" id="end-date" class="form-control">
                <button id="search-btn" class="btn btn-secondary ml-2">Buscar</button>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Edad</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="students-list">
                <!-- Aquí se mostrarán los alumnos -->
            </tbody>
        </table>
        <pre id="json-output" class="mt-3"></pre>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Agregar Alumno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="buscarAlumnos()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="student-form">
                        <div class="form-group">
                            <label for="student-matricula">Matrícula</label>
                            <input type="text" class="form-control" id="student-matricula" required>
                        </div>
                        <div class="form-group">
                            <label for="student-nombre">Nombre</label>
                            <input type="text" class="form-control" id="student-nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="student-apellido">Apellido</label>
                            <input type="text" class="form-control" id="student-apellido" required>
                        </div>
                        <div class="form-group">
                            <label for="student-edad">Edad</label>
                            <input type="number" class="form-control" id="student-edad" required>
                        </div>
                        <div class="form-group">
                            <label for="student-fecha-nacimiento">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="student-fecha-nacimiento" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
        $(document).ready(function() {
            let students = [];

            const renderStudents = (studentsToRender) => {
                const $studentsList = $('#students-list');
                $studentsList.empty();
                studentsToRender.forEach((student, index) => {
                    const $listItem = $(`
                        <tr>
                            <td>${student.matricula}</td>
                            <td>${student.nombre}</td>
                            <td>${student.apellido}</td>
                            <td>${student.edad}</td>
                            <td>${student.fechaNacimiento}</td>
                            <td><button class="btn btn-danger btn-sm remove-student" data-index="${index}">Eliminar</button></td>
                        </tr>
                        `);
                    $studentsList.append($listItem);
                });
                $('#json-output').text(JSON.stringify(students, null, 2));
            };

            const filterStudents = () => {
                const searchTerm = $('#search-input').val().toLowerCase();
                const searchBy = $('#search-field').val();
                const start = new Date($('#start-date').val());
                const end = new Date($('#end-date').val());

                const filteredStudents = students.filter(student => {
                    const studentField = student[searchBy].toLowerCase();
                    const studentDate = new Date(student.fechaNacimiento);
                    return studentField.includes(searchTerm) &&
                        (!$('#start-date').val() || studentDate >= start) &&
                        (!$('#end-date').val() || studentDate <= end);
                });

                renderStudents(filteredStudents);
            };

            var formStudent = document.getElementById('student-form')
            $('#student-form').submit(function(e) {
                e.preventDefault();
                const student = {
                    matricula: $('#student-matricula').val(),
                    nombre: $('#student-nombre').val(),
                    apellido: $('#student-apellido').val(),
                    edad: $('#student-edad').val(),
                    fechaNacimiento: $('#student-fecha-nacimiento').val()
                };

                students.push(student);
                renderStudents(students);
                $('#studentModal').modal('hide');
                this.reset();
            });

            $('#students-list').on('click', '.remove-student', function() {
                const index = $(this).data('index');
                students.splice(index, 1);
                renderStudents(students);
            });

            $('#search-btn').click(filterStudents);

            $('#add-student-btn').click(function() {
                $('#student-form')[0].reset();
            });

            renderStudents(students);
        });

    </script>
@endsection
