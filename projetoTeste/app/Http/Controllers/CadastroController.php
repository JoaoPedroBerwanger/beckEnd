<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CadastroController extends Controller
{
    public function index()
    {
        return view('cadastro.index');
    }

    public function salvar(Request $request)
    {
        $request->validate([
            'nome'                  => 'required|string|max:100',
            'email'                 => 'required|email|max:150',
            'password'              => 'required|string|min:6|confirmed',
        ], [
            'nome.required'              => 'O nome é obrigatório.',
            'email.required'             => 'O e-mail é obrigatório.',
            'email.email'                => 'Informe um e-mail válido.',
            'password.required'          => 'A senha é obrigatória.',
            'password.min'               => 'A senha deve ter pelo menos 6 caracteres.',
            'password.confirmed'         => 'As senhas não coincidem.',
        ]);

        return view('cadastro.index', ['cadastrado' => true, 'nome' => $request->nome]);
    }
}
