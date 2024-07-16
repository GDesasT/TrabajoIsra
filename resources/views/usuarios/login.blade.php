@extends('templates.crud')

@section('title', 'Login')

@section('styles')
<style>
    .body {
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
@endsection

@section('body')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="body">
    <div class="form-box">
        <h2>Login</h2>
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="inputbox">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="inputbox">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Log in</button>
            <div class="register">
                <p>No tienes cuenta? <a href="{{ route('registro.vista') }}">Regístrate</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
