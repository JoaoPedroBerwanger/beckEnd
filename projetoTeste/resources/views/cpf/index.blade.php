@extends('layouts.app')
@section('title', 'Validação de CPF')
@section('content')

<h1>Validação de CPF</h1>

@if ($errors->any())
    @foreach ($errors->all() as $erro)
        <p style="color:red">{{ $erro }}</p>
    @endforeach
@endif

<form method="POST" action="/cpf">
    @csrf
    <label>CPF: <input type="text" name="cpf" value="{{ old('cpf', $cpf ?? '') }}" placeholder="000.000.000-00"></label>
    <button type="submit">Validar</button>
</form>

@isset($valido)
    @if ($valido)
        <p style="color:green">CPF <strong>{{ $cpf }}</strong> é VÁLIDO.</p>
    @else
        <p style="color:red">CPF <strong>{{ $cpf }}</strong> é INVÁLIDO.</p>
    @endif
@endisset

@endsection
