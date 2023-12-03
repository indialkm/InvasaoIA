

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo\perdeu.css">
    <title>Invasão IA</title>
</head>
<body>
<div class="caixa01">
    <div class="palavra">
        <?php
        // Inicie a sessão nivel1
        session_name('nivel1');
        session_start();
        $palavra = "";

        // Verifique se a palavra está definida na sessão
        if (isset($_SESSION['palavra'])) {
            echo "<p>A palavra era: " . $_SESSION['palavra'].'</p>';
            session_destroy();
        }
        ?>
    </div>
    <div class="bot">
        <button><a href="inicio.html">Tentar novamente</a></button>
        <button><a href="index.php">Eu me rendo para as IAs</a></button>
        </div>
    </div>
</body>
</html>