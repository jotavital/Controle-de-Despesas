<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/bulma.css">
    <link rel="stylesheet" href="/style/main.css">
    <title>Controle de Despesas - Cadastro</title>
</head>
<body>
    <div id="container">
        <div class="divForm">
            <form action="#" method="" class="box" id="formulario">
                <h1 class="title">Cadastrar-se</h1>
                <div class="field">
                    <label class="label" for="nome">Nome:</label>
                    <div class="control">
                        <input class="input is-rounded" id ="nome" type="text" placeholder="Seu nome">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="sobrenome">Sobrenome (opcional):</label>
                    <div class="control">
                        <input class="input is-rounded" id="sobrenome" type="text" placeholder="Seu sobrenome">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="usuario">Nome de usuário:</label>
                    <div class="control">
                        <input class="input is-rounded" id="usuario" type="text" placeholder="Escolha um nome de usuário">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="senha">Senha:</label>
                    <div class="control">
                        <input class="input is-rounded" id="senha" type="password" placeholder="Escolha uma senha forte">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="confirmaSenha">Confirme a senha:</label>
                    <div class="control">
                        <input class="input is-rounded" id="confirmaSenha" type="password" placeholder="Digite sua senha novamente">
                    </div>
                </div>
                <div class="block">
                <p>Já é cadastrado? <a href="login.php">Entre!</a></p>
                </div>
                <div class="buttons is-centered">
                    <button class="button is-success">
                        <span class="icon is-small">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        <span>Cadastrar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
<script src="https://kit.fontawesome.com/2ecaa7524c.js" crossorigin="anonymous"></script>
</body>

</html>