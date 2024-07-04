@extends('templates.crud')

@section('title', 'Categorias')

@section('body')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <title>pilin</title>
</head>
<body>
    <p>
        <select class="form-select" id="functionSelector">
            <option value="changeBackgroundColor">Cambiar Color de Fondo</option>
            <option value="setRandomBackgroundColor">Color Aleatorio</option>
        </select>
        <button class="btn btn-primary" onclick="executeSelectedFunction()">Ejecutar Función</button>
    </p>
    
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">Color de Fondo</span>
        <input type="text" maxlength="10" style="max-width: 400px;" class="form-control" placeholder="Introduce un Color" aria-label="Color" value="#ff0000" id="colorpickerField" aria-describedby="addon-wrapping">
    </div>
    
    <script>
        function executeSelectedFunction() {
            var selectedFunction = document.getElementById('functionSelector').value;
            switch(selectedFunction) {
                case 'changeBackgroundColor':
                    changeBackgroundColor();
                    break;
                case 'setRandomBackgroundColor':
                    setRandomBackgroundColor();
                    break;
                default:
                    alert('Selecciona una función válida');
            }
        }

        function changeBackgroundColor() {
            var color = $('#colorpickerField').val();
            if(/^#[0-9A-F]{6}$/i.test(color) || isColorNameValid(color)) {
                $('body').css('background-color', color);
            } else {
                alert('Por favor introduce un color válido');
            }
        }

        function isColorNameValid(colorName) {
            var s = new Option().style;
            s.color = colorName;
            return s.color !== '';
        }

        function setRandomBackgroundColor() {
            var randomColor = '#' + Math.floor(Math.random()*16777215).toString(16);
            $('body').css('background-color', randomColor);
            $('#colorpickerField').val(randomColor);
        }
    </script>

</body>
</html>
@endsection
