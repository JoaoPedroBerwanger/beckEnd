<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TabuadaController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\CalculadoraController;
use App\Http\Controllers\ConversorController;
use App\Http\Controllers\CpfController;
use App\Http\Controllers\ImcController;
use App\Http\Controllers\EnqueteController;

Route::get('/', function () {
    return view('welcome');
});

// Exercício 1 – Tabuada e Fatorial
Route::get('/tabuada', [TabuadaController::class, 'index']);
Route::post('/tabuada', [TabuadaController::class, 'calcular']);

// Exercício 2 – Feedback
Route::get('/feedback', [FeedbackController::class, 'index']);
Route::post('/feedback', [FeedbackController::class, 'enviar']);

// Exercício 3 – Cadastro de Usuário
Route::get('/cadastro', [CadastroController::class, 'index']);
Route::post('/cadastro', [CadastroController::class, 'salvar']);

// Exercício 4 – Calculadora
Route::get('/calculadora', [CalculadoraController::class, 'index']);
Route::post('/calculadora', [CalculadoraController::class, 'calcular']);

// Exercício 5 – Conversor de Temperatura
Route::get('/conversor', [ConversorController::class, 'index']);
Route::post('/conversor', [ConversorController::class, 'converter']);

// Exercício 6 – Validação de CPF
Route::get('/cpf', [CpfController::class, 'index']);
Route::post('/cpf', [CpfController::class, 'validar']);

// Exercício 7 – Calculadora de IMC
Route::get('/imc', [ImcController::class, 'index']);
Route::post('/imc', [ImcController::class, 'calcular']);

// Exercício 8 – Enquete
Route::get('/enquete', [EnqueteController::class, 'index'])->name('enquete.index');
Route::post('/enquete', [EnqueteController::class, 'votar']);
