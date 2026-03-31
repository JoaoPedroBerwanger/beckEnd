@extends('layouts.app')
@section('title', 'Cadastro de Usuário')
@section('content')

<h1>Cadastro de Usuário</h1>

@if ($errors->any())
    @foreach ($errors->all() as $erro)
        <p style="color:red">{{ $erro }}</p>
    @endforeach
@endif

@if (!empty($cadastrado))
    <p>Cadastro realizado com sucesso! Bem-vindo(a), {{ $nome }}!</p>
@else
    <form method="POST" action="/cadastro">
        @csrf
        <p>
            <label>Nome: <input type="text" name="nome" value="{{ old('nome') }}"></label>
        </p>
        <p>
            <label>E-mail: <input type="email" name="email" value="{{ old('email') }}"></label>
        </p>
        <p>
            <label>Senha: <input type="password" name="password"></label>
        </p>
        <p>
            <label>Confirmar Senha: <input type="password" name="password_confirmation"></label>
        </p>
        <button type="submit">Cadastrar</button>
    </form>
@endif

@endsection
