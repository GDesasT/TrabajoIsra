<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game History</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap">
    <style>
        body {
            background-color: #f8f9fa;
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
            padding: 40px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            overflow-x: auto;
        }
        .history-box h1 {
            font-size: 2em;
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }
        .table th, .table td {
            padding: 1.25rem;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
            text-align: center;
        }
        .table thead th {
            background-color: #007bff;
            color: white;
        }
        .table tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 123, 255, 0.15);
        }
        .btn-danger {
            border-radius: 20px;
        }
        .btn-back {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            text-align: center;
            background-color: #007bff;
            color: white;
            border-radius: 20px;
            text-decoration: none;
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
