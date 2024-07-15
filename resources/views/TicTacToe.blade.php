@extends('templates.crud')

@section('title', 'Tic Tac Toe')

@section('styles')
<style>
    .board {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        max-width: 300px;
        margin: 0 auto;
    }
    .cell {
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        background-color: #fff;
    }
    .btn-light {
        font-size: 2rem;
        border: none;
        background: none;
        padding: 0;
        width: 100%;
        height: 100%;
    }
    .table {
        margin-top: 20px;
        width: 100%;
        border-collapse: collapse;
    }
    .table th,
    .table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    .table th {
        background-color: #f2f2f2;
    }
</style>
@endsection

@section('body')
<div class="container">
    <h1 class="text-center my-4">Tic Tac Toe</h1>
    <div class="board">
        @for ($i = 0; $i < 9; $i++)
            <div class="cell" data-position="{{ $i }}">
                <button type="button" class="btn btn-light">
                    <span>{{ $board[$i] }}</span>
                </button>
            </div>
        @endfor
    </div>
    <div class="text-center mt-4">
        <p>Current Player: <strong id="player">{{ $player }}</strong></p>
    </div>
    <div id="message" class="text-center mt-4">
        <p><strong id="winnerMessage"></strong></p>
        <button id="resetButton" class="btn btn-primary">Reset Game</button>
    </div>
    <div id="errors" class="alert alert-danger" style="display: none;"></div>

    @if ($moves->isNotEmpty())
        <h2 class="mt-4">Historial de movimientos</h2>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Jugador</th>
                    <th>Posición</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($moves as $move)
                    <tr>
                        <td>{{ $move->player }}</td>
                        <td>{{ $move->position }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        var gameEnded = false;

        $('.cell').click(function() {
            if (gameEnded) return;

            var position = $(this).data('position');
            $.ajax({
                url: '/tictactoe/play',
                type: 'POST',
                data: {
                    position: position,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        updateBoard(response.board);
                        updatePlayer(response.player);

                        var winner = response.winner;
                        if (winner) {
                            gameEnded = true;
                            $('#winnerMessage').text('¡El jugador ' + winner + ' ha ganado!');
                            $('#message').show();
                        }
                    } else {
                        $('#errors').text(response.message).show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        $('#resetButton').click(function() {
            $.ajax({
                url: '/tictactoe/reset',
                type: 'GET',
                success: function(response) {
                    updateBoard(Array(9).fill(''));
                    updatePlayer('X');
                    gameEnded = false;
                    $('#winnerMessage').text('');
                    $('#message').hide();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        function updateBoard(board) {
            $('.cell span').each(function(index) {
                $(this).text(board[index]);
            });
        }

        function updatePlayer(player) {
            $('#player').text(player);
        }
    });
</script>
@endsection
