<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('feedback.index');
    }

    public function enviar(Request $request)
    {
        $dados = $request->validate(
        [
            'nome' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'comentario' => 'required|string|max:1000',
            'avaliacao' => 'required|integer|min:1|max:5',
        ], 
        [
            'nome.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'comentario.required'=> 'O comentário é obrigatório.',
            'avaliacao.required' => 'Selecione uma avaliação.',
            'avaliacao.min' => 'A avaliação deve ser entre 1 e 5.',
            'avaliacao.max' => 'A avaliação deve ser entre 1 e 5.',
        ]);

        return view('feedback.index', ['enviado' => true, 'dados' => $dados]);
    }
}
