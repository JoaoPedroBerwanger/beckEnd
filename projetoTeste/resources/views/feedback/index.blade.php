@extends('layouts.app')
@section('title', 'Feedback')
@section('content')

<h1>Formulário de Feedback</h1>

@if ($errors->any())
    @foreach ($errors->all() as $erro)
        <p style="color:red">{{ $erro }}</p>
    @endforeach
@endif

@if (!empty($enviado))
    <p>Obrigado, <strong>{{ $dados['nome'] }}</strong>! Sua avaliação foi: <strong>{{ $dados['avaliacao'] }}/5</strong></p>
@else
    <form method="POST" action="/feedback">
        @csrf
        <p>
            <label>Nome: <input type="text" name="nome" value="{{ old('nome') }}"></label>
        </p>
        <p>
            <label>E-mail: <input type="email" name="email" value="{{ old('email') }}"></label>
        </p>
        <p>
            <label>Comentário:<br>
                <textarea name="comentario" rows="4" cols="40">{{ old('comentario') }}</textarea>
            </label>
        </p>
        <p>Avaliação:
            @for ($i = 1; $i <= 5; $i++)
                <label><input type="radio" name="avaliacao" value="{{ $i }}" {{ old('avaliacao') == $i ? 'checked' : '' }}> {{ $i }}</label>
            @endfor
        </p>
        <button type="submit">Enviar</button>
    </form>
@endif

@endsection
