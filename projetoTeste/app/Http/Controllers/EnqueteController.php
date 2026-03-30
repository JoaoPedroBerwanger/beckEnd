<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnqueteController extends Controller
{
    private const OPCOES = ['PHP', 'Python', 'JavaScript', 'Java', 'C++'];

    public function index()
    {
        $votos = session('votos', array_fill_keys(self::OPCOES, 0));
        $totalVotos = array_sum($votos);
        return view('enquete.index', [
            'opcoes'     => self::OPCOES,
            'votos'      => $votos,
            'totalVotos' => $totalVotos,
        ]);
    }

    public function votar(Request $request)
    {
        $request->validate([
            'opcao' => 'required|in:' . implode(',', self::OPCOES),
        ], [
            'opcao.required' => 'Selecione uma opção.',
            'opcao.in'       => 'Opção inválida.',
        ]);

        $votos = session('votos', array_fill_keys(self::OPCOES, 0));
        $votos[$request->opcao]++;
        session(['votos' => $votos]);

        return redirect()->route('enquete.index')->with('votou', $request->opcao);
    }
}
