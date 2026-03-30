@extends('layouts.app')
@section('title', 'Tabuada e Fatorial')
@section('content')

<h1>Tabuada e Fatorial</h1>

@if ($errors->any())
    @foreach ($errors->all() as $erro)
        <p style="color:red">{{ $erro }}</p>
    @endforeach
@endif

<form method="POST" action="/tabuada">
    @csrf
    <label>Número (0 a 20): <input type="number" name="numero" min="0" max="20" value="{{ old('numero', $numero ?? '') }}"></label>
    <button type="submit">Calcular</button>
</form>

@isset($numero)
    <h2>Tabuada do {{ $numero }}</h2>
    <table border="1">
        @foreach ($tabuada as $i => $resultado)
            <tr>
                <td>{{ $numero }} x {{ $i }} = {{ $resultado }}</td>
            </tr>
        @endforeach
    </table>

    <h2>Fatorial</h2>
    <p>{{ $numero }}! = {{ $fatorial }}</p>
@endisset

@endsection
