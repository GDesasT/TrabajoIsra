<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class TicTacToeController extends Controller
{
    public function index()
    {
        $game = Player::latest()->first();

        if ($game) {
            $board = $game->board;
            $player = $game->current_player;
        } else {
            $board = array_fill(0, 9, '');
            $player = 'X';
        }

        return view('tictactoe', compact('board', 'player'));
    }

    public function play(Request $request)
    {
        $game = Player::latest()->first();

        if (!$game) {
            $game = new Player([
                'board' => array_fill(0, 9, ''),
                'current_player' => 'X',
            ]);
        }

        $board = $game->board;
        $player = $game->current_player;

        $position = $request->input('position');

        if ($board[$position] === '') {
            $board[$position] = $player;

            $winner = $this->checkWinner($board);

            if ($winner) {
                return response()->json([
                    'success' => true,
                    'board' => $board,
                    'player' => $player,
                    'winner' => $winner,
                ]);
            }

            $player = $player === 'X' ? 'O' : 'X';
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Posición inválida. Por favor, selecciona una celda vacía.',
            ], 400);
        }

        $game->board = $board;
        $game->current_player = $player;
        $game->save();

        return response()->json([
            'success' => true,
            'board' => $board,
            'player' => $player,
            'winner' => null,
        ]);
    }

    public function reset()
    {
        Player::truncate();

        return redirect()->route('tictactoe')->with('success', 'Juego reiniciado correctamente.');
    }

    private function checkWinner($board)
    {
        $winningConditions = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8], // Filas
            [0, 3, 6], [1, 4, 7], [2, 5, 8], // Columnas
            [0, 4, 8], [2, 4, 6], // Diagonales
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
