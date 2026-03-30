@extends('layouts.app')
@section('title', 'Calculadora de IMC')
@section('content')

<h1>Calculadora de IMC</h1>

@if ($errors->any())
    @foreach ($errors->all() as $erro)
        <p style="color:red">{{ $erro }}</p>
    @endforeach
@endif

<form method="POST" action="/imc">
    @csrf
    <p>
        <label>Peso (kg): <input type="number" step="0.1" name="peso" value="{{ old('peso', $peso ?? '') }}"></label>
    </p>
    <p>
        <label>Altura (m): <input type="number" step="0.01" name="altura" value="{{ old('altura', $altura ?? '') }}"></label>
    </p>
    <button type="submit">Calcular</button>
</form>

@isset($imc)
    <p>IMC: <strong>{{ number_format($imc, 2, ',', '.') }}</strong></p>
    <p>Classificação: <strong>{{ $classificacao['texto'] }}</strong></p>

    <table border="1">
        <tr><th>IMC</th><th>Classificação</th></tr>
        <tr><td>Abaixo de 18,5</td><td>Abaixo do peso</td></tr>
        <tr><td>18,5 – 24,9</td><td>Peso normal</td></tr>
        <tr><td>25,0 – 29,9</td><td>Sobrepeso</td></tr>
        <tr><td>30,0 – 34,9</td><td>Obesidade Grau I</td></tr>
        <tr><td>35,0 – 39,9</td><td>Obesidade Grau II</td></tr>
        <tr><td>Acima de 40</td><td>Obesidade Grau III</td></tr>
    </table>
@endisset

@endsection
