<?php
session_name('nivel1');
session_start();



$bancoDePalavrasFile = 'palavras.txt';
$palavra = "";

// Verifique se a palavra já está definida na sessão
if (!isset($_SESSION['palavra'])) {
    // Se não estiver definida, leia o banco de palavras e escolha uma palavra aleatória
    $bancoDePalavras = file($bancoDePalavrasFile, FILE_IGNORE_NEW_LINES);
    $palavraAleatoria = $bancoDePalavras[array_rand($bancoDePalavras)];

    // Armazene a palavra na sessão
    $_SESSION['palavra'] = $palavraAleatoria;
    // Defina a variável $palavra
    $palavra = $palavraAleatoria;
} else {
    // Se a palavra já estiver definida na sessão, obtenha-a a partir da sessão
    $palavra = $_SESSION['palavra'];
}

if (!isset($_SESSION['palavra']) || $_SESSION['palavra'] !== $palavra) {
    session_destroy();
    session_start();
    $_SESSION['palavra'] = $palavra;
}
// Inicialize as variáveis de jogo se a sessão não estiver configurada
if (!isset($_SESSION['erros'])) {
    $_SESSION['erros'] = 0;
    $_SESSION['palavraOculta'] = array_fill(0, strlen($palavra), '_');
    $_SESSION['letrasTentadas'] = array();
}

// Função para verificar se a letra foi tentada
function letraJaTentada($letra, $letrasTentadas)
{
    return in_array($letra, $letrasTentadas);
}

// Função para exibir a palavra oculta
function exibirPalavraOculta($palavraOculta)
{
    echo implode(" ", $palavraOculta);
}

// Verifique se a letra foi submetida pelo jogador
if (isset($_POST['letra'])) {
    $letra = strtolower($_POST['letra']);

    // Verifique se a letra ainda não foi tentada
    if (!letraJaTentada($letra, $_SESSION['letrasTentadas'])) {
        $_SESSION['letrasTentadas'][] = $letra;

        // Verifique se a letra está na palavra
        if (strpos($palavra, $letra) === false) {
            $_SESSION['erros']++;
        } else {
            for ($i = 0; $i < strlen($palavra); $i++) {
                if ($palavra[$i] == $letra) {
                    $_SESSION['palavraOculta'][$i] = $letra;
                }
            }
        }
    }
}



// Verifique se o jogador ganhou ou perdeu
if ($_SESSION['erros'] >= 6) {
    header('Location: perdeu.php');
} elseif (implode("", $_SESSION['palavraOculta']) == $palavra) {
    header('Location: entrenivel01.php');
    session_destroy();
} else {
    $porcentagemProgresso = ($_SESSION['erros'] / 6) * 100;


?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Invasão IA</title>
        <link rel="stylesheet" href="estilo/forca.css">
    </head>

    <body>

        <main>
            <div class="metade">
                
                <?php 
                if($_SESSION['erros'] >=0 && $_SESSION['erros'] <= 1)
                echo '<img class="robozin" src="imagem/robozin_n1_01.svg" alt="">';
                ?>

                <?php 
                if($_SESSION['erros'] >1 && $_SESSION['erros'] <= 3)
                echo '<img class="robozin" src="imagem/robozin02-01.svg" alt="">';
                ?>

                <?php 
                if($_SESSION['erros'] >3 && $_SESSION['erros'] <= 6)
                echo '<img class="robozin" src="imagem/robozin03-01.svg" alt="">';
                ?>
            </div>

            <div class="metade02">
                <div class="caixa1">
                    <p>Para desabilitar o carregamento<br> digite a palavra certa</p>

                    <div class="caixapalavra">
                        <p><?php exibirPalavraOculta($_SESSION['palavraOculta']); ?></p>
                    </div>

                    <p>Palavra chave: Inteligência Aritificial</p>

                    <form method="post">
                        <label for="letra"></label>
                        <input type="text" id="letra" name="letra" maxlength="1">
                        <input id="botao" type="submit" value="Tentar">
                    </form>

                    <p>Letras já tentadas: <?php echo implode(" ", $_SESSION['letrasTentadas']); ?></p>

                    <p>Carregando a IA</p>
                    <div class="barra">
                        <div style="width: <?php echo $porcentagemProgresso; ?>%;">
                    </div>
                    </div>
                    <br>
                    <div class="relogio">
                    <p id="tempoRestante">Tempo restante: <span id="contador">120</span> segundos</p>
                    </div>
                </div> <!-- caixa01 -->
            </div> <!-- metade02  -->

        </main>

        <script>
        var tempoRestante = 120; // Tempo inicial em segundos
        var contador = document.getElementById("contador");

        var contagemRegressiva = setInterval(function () {
                if (tempoRestante > 0) {
                tempoRestante--;
                contador.textContent = tempoRestante;
            } else {
                clearInterval(contagemRegressiva);
                window.location.href = 'perdeu.php';

            }
        }, 1000);
        </script>
    </body>

    </html>
<?php
}

?>