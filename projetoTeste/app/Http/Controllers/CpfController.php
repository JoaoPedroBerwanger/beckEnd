<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CpfController extends Controller
{
    public function index()
    {
        return view('cpf.index');
    }

    public function validar(Request $request)
    {
        $request->validate(
        [
            'cpf' => 'required|string',
        ], 
        [
            'cpf.required' => 'Informe um CPF.',
        ]);

        $cpf = $request->cpf;
        $valido = $this->validarCpf($cpf);
        $cpfFormatado = $cpf;

        return view('cpf.index', compact('cpf', 'cpfFormatado', 'valido'));
    }

    // function copida da internet
    private function validarCpf(string $cpf): bool
    {
        // Remove formatação
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Deve ter exatamente 11 dígitos
        if (strlen($cpf) !== 11) {
            return false;
        }

        // Rejeita sequências de dígitos iguais (ex: 111.111.111-11)
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        // Calcula 1º dígito verificador
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += (int) $cpf[$i] * (10 - $i);
        }
        $resto = $soma % 11;
        $digito1 = $resto < 2 ? 0 : 11 - $resto;

        if ((int) $cpf[9] !== $digito1) {
            return false;
        }

        // Calcula 2º dígito verificador
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += (int) $cpf[$i] * (11 - $i);
        }
        $resto = $soma % 11;
        $digito2 = $resto < 2 ? 0 : 11 - $resto;

        return (int) $cpf[10] === $digito2;
    }
}
