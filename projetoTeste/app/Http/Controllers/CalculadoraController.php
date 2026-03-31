<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculadoraController extends Controller
{
    public function index()
    {
        return view('calculadora.index');
    }

    public function calcular(Request $request)
    {
        $request->validate(
        [
            'num1' => 'required|numeric',
            'num2' => 'required|numeric',
            'operacao' => 'required|in:+,-,*,/',
        ], 
        [
            'num1.required' => 'Informe o primeiro número.',
            'num1.numeric' => 'O primeiro valor deve ser numérico.',
            'num2.required' => 'Informe o segundo número.',
            'num2.numeric' => 'O segundo valor deve ser numérico.',
            'operacao.required' => 'Selecione uma operação.',
            'operacao.in' => 'Operação inválida.',
        ]);

        $num1 = (float) $request->num1;
        $num2 = (float) $request->num2;
        $operacao = $request->operacao;
        $resultado = null;
        $erro = null;

        switch ($operacao) {
            case '+': 
                $resultado = $num1 + $num2; 
            break;
            
            case '-': 
                $resultado = $num1 - $num2; 
            break;
            
            case '*': 
                $resultado = $num1 * $num2; 
            break;
            
            case '/':
                if ($num2 == 0) {
                    $erro = 'Divisão por zero não é permitida.';
                } else {
                    $resultado = $num1 / $num2;
                }
            break;
        }

        return view('calculadora.index', compact('num1', 'num2', 'operacao', 'resultado', 'erro'));
    }
}
