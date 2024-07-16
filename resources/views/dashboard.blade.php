@auth
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHq6/2bT/5qD1vFf1c5lt4YP4Crw5j+f1q6H/A9b6xeYq+ikRQ0w0m1UBK5k3e1vB8o/aW1g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand img {
            width: 70px;
            margin-left: 20px;
        }
        .navbar-nav {
            margin: 0 auto; 
        }
        .main-content {
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 56px); 
        }
        .form-container {
            max-width: 600px;
            width: 100%;
            padding: 40px;
            background-color: #fff; 
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .form-container h2 {
            margin-bottom: 30px;
            font-weight: bold;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 4px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 30px;
            font-size: 1.2em;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('perfil.vista') }}">Ver Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('history') }}">Historial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main-content">
        <div class="form-container">
            <h2>Iniciar Nueva Partida</h2>
            <form action="{{ route('game.create') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="player2_name">Nombre del Jugador 2:</label>
                    <input type="text" name="player2_name" class="form-control" placeholder="Ingrese el nombre del jugador 2" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-play"></i> Iniciar Partida
                </button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
@endauth

@guest
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acceso Restringido</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
                font-family: 'Arial', sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #f8f9fa;
            }
            .container {
                text-align: center;
                max-width: 600px;
                padding: 40px;
                background-color: #fff; 
                border-radius: 8px;
                box-shadow: 0 0 15px rgba(0,0,0,0.1);
            }
            .title {
                font-size: 2em;
                margin-bottom: 20px;
                color: #333;
            }
            .meme {
                margin-bottom: 20px;
                max-width: 100%;
                border-radius: 8px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2 class="title">Acceso Restringido</h2>
            <img src="https://cdn.memegenerator.es/imagenes/memes/thumb/30/74/30741918.jpg" alt="Meme Enfadado">
            <p>¿Qué intentas hacer? ¡Mal parido!</p>
        </div>
    </body>
    </html>
@endguest