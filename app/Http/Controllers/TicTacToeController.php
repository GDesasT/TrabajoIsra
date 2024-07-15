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
            $players = json_decode($game->moves, true); // Decodifica el campo JSON 'moves'
        } else {
            $board = array_fill(0, 9, '');
            $player = 'X';
            $players = [];
        }

        return view('tictactoe', compact('board', 'player', 'players'));
    }

    public function play(Request $request)
    {
        $game = Player::latest()->first();

        if (!$game) {
            $game = new Player([
                'board' => array_fill(0, 9, ''),
                'current_player' => 'X',
                'moves' => json_encode([]), // Inicializa el historial de movimientos como un array vacío en JSON
            ]);
        }

        $board = $game->board;
        $player = $game->current_player;

        $position = $request->input('position');

        if ($board[$position] === '') {
            $board[$position] = $player;

            $winner = $this->checkWinner($board);

            if ($winner) {
                $this->saveMove($game, $player, $position); // Guarda el movimiento ganador antes de responder
                return response()->json([
                    'success' => true,
                    'board' => $board,
                    'player' => $player,
                    'winner' => $winner,
                    'players' => json_decode($game->moves, true), // Envía el historial actualizado de movimientos
                ]);
            }

            $player = $player === 'X' ? 'O' : 'X';
            $this->saveMove($game, $player, $position); // Guarda el movimiento antes de cambiar de jugador
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
            'players' => json_decode($game->moves, true), // Envía el historial actualizado de movimientos
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

    private function saveMove($game, $player, $position)
    {
        $moves = json_decode($game->moves, true);
        $moves[] = [
            'player' => $player,
            'position' => $position,
        ];
        $game->moves = json_encode($moves);
        $game->save();
    }
}
