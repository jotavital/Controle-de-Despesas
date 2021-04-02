<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function index(){
        return view('index');
    }

    public function create(){
        return view('users.create');
    }

    public function login(){
        return view('users.login');
    }

    public function store(Request $request){
        
        $usuario = new Usuario;

        $usuario->nome = $request->inputNome;
        $usuario->sobrenome = $request->inputSobrenome;
        $usuario->nome_usuario = $request->inputUsername;
        $usuario->senha = $request->inputSenha;

        $usuario->save();

        return redirect('users/create');
    }
}
