@extends('layouts.menuUnlogged')

@section('title', 'Cadastro')

@section('menuNav')

@section('content')
    <div id="container">
        <div class="divForm">
            <h2 class="mb-5">Crie sua conta</h2>
            <form class="formularioCadastro" action="/users" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="col-md-12">
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="inputNome" name="inputNome" placeholder="Nome">
                        <label for="inputNome">Nome</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="inputSobrenome" name="inputSobrenome" placeholder="Sobrenome">
                        <label for="inputSobrenome">Sobrenome</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="inputUsername" name="inputUsername" placeholder="Nome de Usuário">
                        <label for="inputUsername">Nome de Usuário</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="inputSenha" name="inputSenha" placeholder="Senha">
                        <label for="inputSenha">Senha</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="inputConfSenha" name="inputConfSenha" placeholder="Confirme a senha">
                        <label for="inputConfSenha">Confirme a senha</label>
                    </div>
                </div>
                <div class="col-md">
                    <p>Já é cadastrado? <a href="/users/login">Entre</a></p>
                </div>
                <div class="col-md">
                    <button type="submit" class="btn btn-success">Pronto!</button>
                </div>
            </form>
        </div>
    </div>
    
@endsection