<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Move;

class TicTacToeController extends Controller
{
    private $board;
    private $currentPlayer;

    public function __construct()
    {
        $this->board = array_fill(0, 9, '');
        $this->currentPlayer = 'X';
    }

    public function index()
    {
        $moves = Move::all();

        $board = $this->board;
        $player = $this->currentPlayer;

        foreach ($moves as $move) {
            $board[$move->position] = $move->player;
        }

        $lastMove = $moves->last();
        if ($lastMove) {
            $player = $lastMove->player === 'X' ? 'O' : 'X';
        }

        return view('tictactoe', compact('board', 'player', 'moves'));
    }

    public function play(Request $request)
    {
        $position = $request->input('position');
        $player = $this->currentPlayer;

        if ($this->board[$position] === '') {
            $this->board[$position] = $player;

            // Guardar el movimiento
            Move::create([
                'player_id' => 1, // Asume que el jugador es el ID 1. Ajusta según tu lógica de jugador.
                'player' => $player,
                'position' => $position
            ]);

            $winner = $this->checkWinner($this->board);

            if ($winner) {
                return response()->json([
                    'success' => true,
                    'board' => $this->board,
                    'player' => $player,
                    'winner' => $winner,
                ]);
            }

            $player = $player === 'X' ? 'O' : 'X';
            $this->currentPlayer = $player;
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Posición inválida. Por favor, selecciona una celda vacía.',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'board' => $this->board,
            'player' => $player,
            'winner' => null,
        ]);
    }

    public function reset()
    {
        Move::truncate();

        return redirect()->route('tictactoe')->with('success', 'Juego reiniciado correctamente.');
    }

    private function checkWinner($board)
    {
        $winningConditions = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8],
            [0, 3, 6], [1, 4, 7], [2, 5, 8],
            [0, 4, 8], [2, 4, 6],
        ];

        foreach ($winningConditions as $condition) {
            [$a, $b, $c] = $condition;
            if ($board[$a] !== '' && $board[$a] === $board[$b] && $board[$b] === $board[$c]) {
                return $board[$a];
            }
        }

        return null;
    }
}
