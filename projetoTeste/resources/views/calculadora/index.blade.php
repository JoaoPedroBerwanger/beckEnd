@extends('layouts.app')
@section('title', 'Calculadora')
@section('content')

<h1>Calculadora Simples</h1>

@if ($errors->any())
    @foreach ($errors->all() as $erro)
        <p style="color:red">{{ $erro }}</p>
    @endforeach
@endif

<form method="POST" action="/calculadora">
    @csrf
    <p>
        <label>Primeiro número: <input type="number" step="any" name="num1" value="{{ old('num1', $num1 ?? '') }}"></label>
    </p>
    <p>
        <label>Segundo número: <input type="number" step="any" name="num2" value="{{ old('num2', $num2 ?? '') }}"></label>
    </p>
    <p>
        <label>Operação:
            <select name="operacao">
                <option value="+" {{ old('operacao', $operacao ?? '') == '+' ? 'selected' : '' }}>Adição (+)</option>
                <option value="-" {{ old('operacao', $operacao ?? '') == '-' ? 'selected' : '' }}>Subtração (-)</option>
                <option value="*" {{ old('operacao', $operacao ?? '') == '*' ? 'selected' : '' }}>Multiplicação (*)</option>
                <option value="/" {{ old('operacao', $operacao ?? '') == '/' ? 'selected' : '' }}>Divisão (/)</option>
            </select>
        </label>
    </p>
    <button type="submit">Calcular</button>
</form>

@isset($resultado)
    <p>Resultado: {{ $num1 }} {{ $operacao }} {{ $num2 }} = {{ $resultado }}</p>
@endisset

@endsection
