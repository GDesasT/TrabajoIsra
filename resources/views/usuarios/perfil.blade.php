<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .perfil-box {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.9); 
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 20px;
            padding: 40px;
            color: #333;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); 
            backdrop-filter: blur(15px);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group label {
            color: #333;
            font-weight: bold;
        }
        .form-control {
            background: transparent;
            border: 1px solid rgba(0, 0, 0, 0.2);
            color: #333;
        }
        .form-control[readonly] {
            background-color: #f8f9fa;
        }
        .btn-primary {
            width: 100%;
            border-radius: 20px;
            background: #007bff;
            border: none;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .logout-link, .dashboard-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 1em;
            font-weight: 600;
            color: #007bff;
            text-decoration: none;
            cursor: pointer;
        }
        .logout-link:hover, .dashboard-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="perfil-box">
        <h1>Perfil</h1>
        <form>
            @csrf
            <div class="form-group">
                <label for="name">Username:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ Auth::user()->name }}" readonly>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
            </div>
            <div class="form-group">
                <label for="created_at">Fecha de Registro:</label>
                <input type="text" id="created_at" name="created_at" class="form-control" value="{{ Auth::user()->created_at }}" readonly>
            </div>
        </form>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="logout-link">
            Cerrar Sesión
        </a>
        <a href="{{ route('dashboard') }}" class="dashboard-link">
            Regresar al Dashboard
        </a>
    </div>
</body>
</html>
