<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game History</title>
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
            font-family: 'Poppins', sans-serif;
        }
        .history-box {
            max-width: 1000px;
            width: 90%;
            margin: 20px;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
            border-left: 5px solid #007bff;
        }
        .history-box h1 {
            font-size: 2em;
            text-align: center;
            color: #343a40;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }
        .table th, .table td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
            text-align: center;
        }
        .table thead th {
            background-color: #007bff;
            color: white;
        }
        .table tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }
        .btn-danger {
            background-color: #e74c3c;
            border: none;
            padding: 5px 10px;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="history-box">
        <h1>Historial de Partidas</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Resultado</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($games as $game)
                    <tr>
                        <td>
                            @if ($game->winner_id)
                                @if ($game->winner_id == Auth::id())
                                    Victoria {{ Auth::user()->name }}
                                @else
                                    Victoria del oponente
                                @endif
                            @elseif ($game->player2_win)
                                Derrota {{ Auth::user()->name }}
                            @else
                                Empate
                            @endif
                        </td>
                        <td>{{ $game->created_at }}</td>
                        <td>
                            <form action="{{ route('game.delete', $game->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('dashboard') }}" class="btn-back">Regresar al Dashboard</a>
    </div>
</body>
</html>
