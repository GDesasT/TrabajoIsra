<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Move;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function history(){
        $userId = Auth::id();
        $games = Game::where('player1_id', $userId)->with('player1', 'moves')->get();
    
        return view('game.history', compact('games'));
    }

    public function delete($id)
    {
        $game = Game::find($id);
        if ($game) {
            $game->delete();
        }
        return redirect()->route('history');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function createGame(Request $request)
    {
        $game = Game::create([
            'player1_id' => Auth::id(),
            'board' => '---------',
        ]);

        session(['player2_name' => $request->input('player2_name'), 'player2_id' => Auth::id()]);

        return redirect()->route('game.show', $game->id);
    }

    public function showGame($id)
    {
        $game = Game::with('moves')->find($id);

        if (!$game) {
            abort(404, 'Game not found');
        }

        $player2_name = session('player2_name', 'Player 2');
        $moves = $game->moves;
        $currentSymbol = $this->getCurrentSymbol($game->board);
        $currentTurn = $currentSymbol == 'X' ? $game->player1->name : $player2_name;

        return view('game.show', compact('game', 'player2_name', 'moves', 'currentSymbol', 'currentTurn'));
    }

    public function makeMove(Request $request, $id)
    {
        $game = Game::find($id);
        $position = $request->position;
        $playerSymbol = $this->getCurrentSymbol($game->board);
    
        $board = str_split($game->board);
        if ($board[$position] == '-') {
            $board[$position] = $playerSymbol;
            $game->board = implode('', $board);
            $game->save();
    
            Move::create([
                'game_id' => $game->id,
                'user_id' => Auth::id(),
                'symbol' => $playerSymbol,
                'position' => $position
            ]);
    
            $winnerSymbol = $this->checkWinner($board);
            if ($winnerSymbol) {
                if ($winnerSymbol == 'X') {
                    $game->winner_id = $game->player1_id;
                } else {
                    $game->winner_id = null; // No establecer winner_id para jugador 2
                    $game->player2_win = true; // Marcar que el jugador 2 ganó
                }
                $game->save();
    
                return response()->json([
                    'success' => true,
                    'symbol' => $playerSymbol,
                    'position' => $position,
                    'winner' => $winnerSymbol == 'X' ? $game->player1->name : session('player2_name'),
                    'redirect' => true
                ]);
            }
    
            if (!in_array('-', $board)) {
                return response()->json([
                    'success' => true,
                    'symbol' => $playerSymbol,
                    'position' => $position,
                    'draw' => true,
                    'redirect' => true // Redirigir después de un empate
                ]);
            }
    
            return response()->json([
                'success' => true,
                'symbol' => $playerSymbol,
                'position' => $position,
                'nextTurn' => $playerSymbol == 'X' ? session('player2_name') : $game->player1->name
            ]);
        }
    
        return response()->json(['success' => false], 400);
    }
    

    private function getCurrentSymbol($board)
    {
        $moves = strlen(str_replace('-', '', $board));
        return $moves % 2 == 0 ? 'X' : 'O';
    }

    private function checkWinner($board)
    {
        $winning_combinations = [
            [0, 1, 2],
            [3, 4, 5],
            [6, 7, 8],
            [0, 3, 6],
            [1, 4, 7],
            [2, 5, 8],
            [0, 4, 8],
            [2, 4, 6],
        ];

        foreach ($winning_combinations as $combination) {
            if ($board[$combination[0]] != '-' &&
                $board[$combination[0]] == $board[$combination[1]] &&
                $board[$combination[0]] == $board[$combination[2]]) {
                return $board[$combination[0]];
            }
        }

        return null;
    }
}
