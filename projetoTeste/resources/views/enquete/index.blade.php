@extends('layouts.app')
@section('title', 'Enquete')
@section('content')

<h1>Enquete</h1>

@if (session('votou'))
    <p>Voto registrado para: <strong>{{ session('votou') }}</strong></p>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $erro)
        <p style="color:red">{{ $erro }}</p>
    @endforeach
@endif

<form method="POST" action="/enquete">
    @csrf
    <p><strong>Qual sua linguagem de programação favorita?</strong></p>
    @foreach ($opcoes as $opcao)
        <p><label><input type="radio" name="opcao" value="{{ $opcao }}"> {{ $opcao }}</label></p>
    @endforeach
    <button type="submit">Votar</button>
</form>

<h2>Resultado</h2>
<table border="1">
    <tr><th>Opção</th><th>Votos</th></tr>
    @foreach ($opcoes as $opcao)
        <tr>
            <td>{{ $opcao }}</td>
            <td>{{ $votos[$opcao] ?? 0 }}</td>
        </tr>
    @endforeach
    <tr>
        <td><strong>Total</strong></td>
        <td><strong>{{ $totalVotos }}</strong></td>
    </tr>
</table>

@endsection
