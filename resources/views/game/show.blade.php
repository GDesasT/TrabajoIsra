<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        .game-container {
            display: flex;
            max-width: 800px;
            padding: 40px;
            background-color: #ffffff;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .game-box {
            text-align: center;
            flex: 2;
        }
        .board {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 10px;
            margin-top: 20px;
        }
        .cell {
            width: 100px;
            height: 100px;
            background-color: #ffffff;
            border: 1px solid #ced4da;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 3em;
            color: #007bff;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
            border-radius: 10px;
        }
        .cell:hover {
            background-color: #f1f1f1;
            transform: scale(1.05);
        }
        .cell::after {
            content: '';
            display: block;
        }
        .movements {
            flex: 1;
            margin-right: 20px;
        }
        .movements h2 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 10px;
        }
        .movements table {
            width: 100%;
            border-collapse: collapse;
        }
        .movements th, .movements td {
            border: 1px solid #ced4da;
            padding: 8px;
            text-align: left;
        }
        .movements th {
            background-color: #f8f9fa;
            color: #333;
        }
        .movements td {
            font-size: 1em;
            color: #555;
        }
        .winner {
            font-size: 2em;
            color: #28a745;
            margin-top: 20px;
        }
        .draw {
            font-size: 2em;
            color: #dc3545;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="game-container">
        <div class="movements">
            <h2>Movimientos Recientes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Jugador</th>
                        <th>Movimiento</th>
                        <th>Posición</th>
                    </tr>
                </thead>
                <tbody id="movement-list">
                    @foreach ($moves as $move)
                        <tr>
                            <td>{{ $move->user->name }}</td>
                            <td>{{ $move->symbol }}</td>
                            <td>{{ $move->position }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="game-box">
            <h1>Tic Tac Toe</h1>
            <p>Jugador 1: {{ $game->player1->name }}</p>
            <p>Jugador 2: {{ $player2_name }}</p>
            <p>Turno de: <span id="current-turn">{{ $currentTurn }}</span></p>
            <div class="board" id="board">
                @for ($i = 0; $i < 9; $i++)
                    <div class="cell" data-position="{{ $i }}" role="button" aria-label="Posición {{ $i + 1 }}">
                        {{ $game->board[$i] }}
                    </div>
                @endfor
            </div>
            <form id="move-form" action="{{ route('game.move', $game->id) }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="position" id="position">
            </form>
            <div id="winner-message" class="winner" style="display: none;"></div>
            <div id="draw-message" class="draw" style="display: none;">¡Empate! El juego ha terminado.</div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.cell').click(function() {
                const position = $(this).data('position');
                $('#position').val(position);

                $.ajax({
                    url: $('#move-form').attr('action'),
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    data: {
                        position: position
                    },
                    success: function(data) {
                        console.log(data);

                        if (data.success) {
                            $(`.cell[data-position="${position}"]`).text(data.symbol);
                            $('#current-turn').text(data.nextTurn);

                            if (data.winner) {
                                $('#winner-message').text(data.winner + ' gana!').show();
                                setTimeout(function() {
                                    window.location.href = '/history';
                                }, 2000);
                            }

                            if (data.draw) {
                                $('#draw-message').show();
                                setTimeout(function() {
                                    window.location.href = '/history';
                                }, 2000);
                            }

                            const newMovement = `<tr><td>${data.user}</td><td>${data.symbol}</td><td>${data.position}</td></tr>`;
                            $('#movement-list').append(newMovement);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Hubo un error al realizar el movimiento. Por favor, inténtalo nuevamente.');
                    }
                });
            });
        });
    </script>
</body>
</html>
