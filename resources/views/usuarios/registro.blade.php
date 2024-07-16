<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap">
    <style>
        body {
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .form-box {
            width: 100%;
            max-width: 450px;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 30px;
        }
        .form-box h2 {
            font-size: 1.8em;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .inputbox {
            position: relative;
            margin: 15px 0;
        }
        .inputbox label {
            display: block;
            color: #333;
            font-size: 0.9em;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .inputbox input {
            width: 100%;
            height: 45px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }
        .inputbox input:focus {
            border-color: #007bff;
            outline: none;
        }
        button {
            width: 100%;
            height: 45px;
            border-radius: 5px;
            background: #007bff;
            border: none;
            color: white;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background: #0056b3;
        }
        .register {
            font-size: 0.9em;
            color: #333;
            text-align: center;
            margin-top: 20px;
        }
        .register p a {
            text-decoration: none;
            color: #007bff;
            font-weight: 600;
        }
        .register p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Registra tu nueva cuenta</h2>
        <form action="{{ route('registro.post') }}" method="POST">
            @csrf
            <div class="inputbox">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="inputbox">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="inputbox">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Registrar</button>
            <div class="register">
                <p>¿Ya tienes una cuenta? <a href="{{ route('login.vista') }}">Inicia sesión</a></p>
            </div>
        </form>
    </div>
</body>
</html>
