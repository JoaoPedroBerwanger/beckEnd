@extends('layouts.app')
@section('title', 'Conversor de Temperatura')
@section('content')

<h1>Conversor de Temperatura</h1>

@if ($errors->any())
    @foreach ($errors->all() as $erro)
        <p style="color:red">{{ $erro }}</p>
    @endforeach
@endif

<form method="POST" action="/conversor">
    @csrf
    <p>
        <label>Temperatura: <input type="number" step="any" name="temperatura" value="{{ old('temperatura', $temp ?? '') }}"></label>
    </p>
    <p>
        <label><input type="radio" name="tipo" value="celsius" {{ old('tipo', $tipo ?? 'celsius') == 'celsius' ? 'checked' : '' }}> Celsius para Fahrenheit</label>
        <label><input type="radio" name="tipo" value="fahrenheit" {{ old('tipo', $tipo ?? '') == 'fahrenheit' ? 'checked' : '' }}> Fahrenheit para Celsius</label>
    </p>
    <button type="submit">Converter</button>
</form>

@isset($resultado)
    <p>{{ $temp }}° ({{ $de }}) = <strong>{{ number_format($resultado, 2, ',', '.') }}° ({{ $para }})</strong></p>
@endisset

@endsection
