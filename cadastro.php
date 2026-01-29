<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/cadastro.css">
    <script>
        // Remove todas as animações atualmente ativas
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
        document.querySelector('.bola').classList.remove('expandir');
                document.querySelector('.bola-content').classList.remove('desaparecer');
                document.querySelector('.text-content').classList.remove('desaparecer');
                document.querySelector('.title').classList.remove('desaparecer');

                document.querySelector('.bola').classList.add('deslizarDir'); //Desliza a bola azul pra direita
                document.querySelector('.bola-content').classList.add('aparecer');
            }, 1); // Pequeno delay para os textos voltarem
        });

           document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('login').addEventListener('click', function(event) {
            event.preventDefault();

            const contentBola = document.querySelector('.bola-content');
            const contentLogin = document.querySelector('.text-content');
            const titulo = document.querySelector('.title');
            const proximaPag = 'index.php'; // Próxima pagina que irá direcionar ao clicar
            const tempo = 500; // 0.5 segundos de espera

            const body = document.querySelector('body');
            const bola = document.querySelector('.bola');
            const quadrado = document.querySelector('.container');

            // Faz todo o conteúdo desaparecer
            bola.classList.remove('deslizarDir'); // Remove a animação de deslizar
            contentBola.classList.remove('aparecer');
            contentBola.classList.add('desaparecer');
            contentLogin.classList.add('desaparecer');
            titulo.classList.add('desaparecer');

            quadrado.classList.add('diminuir'); // diminui o quadrado
            bola.classList.add('expandir'); //expande a bola azul
            body.classList.add('trocaCor'); // troca a cor do fundo

            //depois de 200 milisegundos o quadrado aumenta denovo
            setTimeout(function() {
                quadrado.classList.remove('diminuir');
                quadrado.classList.add('aumentar');
            }, 200);

            setTimeout(function() {
                window.location.href = proximaPag;
            }, tempo); // 0.5 segundos de delay
        });
    });
    </script>
</head>
<body>
    <div class="container">
<div class="text-content desaparecer">
    <h2 class=title>Cadastro de Usuário</h2>
    <form action="salvar_cadastro.php" method="POST">

    <div class="box-icon"><img src="img/person.png"></div>
        <input type="text" name="nome" required placeholder="Nome Completo"><br><br>

    <div class="box-icon"><img src="img/email.png"></div>
        <input type="email" name="email" required placeholder="Email"><br><br>

    <div class="box-icon"><img src="img/lock.png"></div>
        <input type="password" name="senha" required placeholder="Senha"><br><br>

        <label>Tipo de usuário:</label><br>
        <select name="tipo" required>
            <option value="">Selecione...</option>
            <option value="visitante">Visitante</option>
            <option value="expositor">Expositor</option>
            <option value="admin">Administrador</option>
        </select><br><br>
        <div class="msg">
        <?php
    if (isset($_GET['msg'])) {
        echo "<p style='color:green'>" . htmlspecialchars($_GET['msg']) . "</p>";
    }
    if (isset($_GET['erro'])) {
        echo "<p style='color:red'>" . htmlspecialchars($_GET['erro']) . "</p>";
    }
    ?>
        </div>

        <button class="button-c" type="submit">Cadastrar</button>
    </form>
</div>
    <div class="bola expandir">
        <div class="bola-content desaparecer">
            <h2>Já possui conta?</h2>
            <p>Faça login para continuar usando nossos serviços.</p>
            <a id="login" href="javascript:void(0)"><button class="button-l">Fazer Login</button></a>
        </div>
    </div>
</body>
</html>
