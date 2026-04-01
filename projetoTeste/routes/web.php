<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Exercício 1 – Tabuada e Fatorial
    Route::get('/tabuada', [TabuadaController::class, 'index'])->name('tabuada.index');
    Route::post('/tabuada', [TabuadaController::class, 'calcular'])->name('tabuada.index');

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

});

require __DIR__ . '/auth.php';
