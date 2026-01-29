<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - SGFEL</title>
    <link rel="stylesheet" href="css/login.css">
    <script>
        // Remove todas as animações atualmente ativas
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.querySelector('.bola').classList.remove('expandir');
                document.querySelector('.bola-content').classList.remove('desaparecer');
                document.querySelector('.text-content').classList.remove('desaparecer');
                document.querySelector('.title').classList.remove('desaparecer');

                document.querySelector('.bola').classList.add('deslizarEsq'); // Desliza a bola azul para a esquerda
                document.querySelector('.bola-content').classList.add('aparecer');
            }, 1); // Pequeno delay para os textos voltarem
        });
        
           document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('cadastro').addEventListener('click', function(event) {
            event.preventDefault();

            const contentBola = document.querySelector('.bola-content');
            const contentLogin = document.querySelector('.text-content');
            const titulo = document.querySelector('.title');
            const proximaPag = 'cadastro.php'; // Próxima página que irá direcionar ao clicar
            const tempo = 500; // 0.5 segundos de espera
            
            const body = document.querySelector('body');
            const bola = document.querySelector('.bola');
            const quadrado = document.querySelector('.container');

            // Faz todo o conteúdo desaparecer
            bola.classList.remove('deslizarEsq'); // Remove a animação de deslizar
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
    <div class="bola">
        <div class="bola-content desaparecer">
            <h2>Não possui uma conta?</h2>
            <p>Crie uma conta agora e ganhe acesso gratuito aos nossos serviços!</p>
            <a href="javascript:void(0)" id="cadastro"><button class="button-c">Cadastrar</button></a>
        </div>
    </div>

    <h2 class="title">Login</h2>
    <div class="text-content">
    <form action="autentica.php" method="POST">

        <div class="box-icon"><img src="img/person.png"></div>
        <input type="email" name="email" required placeholder="E-mail"><br><br>


        <div class="box-icon"><img src="img/lock.png"></div>
        <input type="password" name="senha" required placeholder="Senha"><br><br>

        <button class="button-l" type="submit">Entrar</button>

        <div class="erro">
        <?php
    if (isset($_GET['erro'])) {
        echo "<p style='color:red'>" . htmlspecialchars($_GET['erro']) . "</p>";
    }
    ?>
        </div>
    </form>
</div>
</div>
</body>
</html>
