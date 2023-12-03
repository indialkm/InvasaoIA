<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo/entrenivel.css">
    <title>Invasão IA</title>
</head>
<body>
    <div class="faixa01">

    </div>

    <div class="nivel">
        <p>NÍVEL 3 DE SEGURANÇA</p>''
        <br><br>
        <p id="tempoRestante">Contagem regressiva <span id="contador">5</span></p>
    </div>

    <div class="faixa02">

    </div>

    <script>
        var tempoRestante = 5; // Tempo inicial em segundos
      var contador = document.getElementById("contador");

      var contagemRegressiva = setInterval(function () {
          if (tempoRestante > 0) {
              tempoRestante--;
              contador.textContent = tempoRestante;
          } else {
              clearInterval(contagemRegressiva);
              window.location.href = 'nivel03.php';
          }
      }, 1000);
      </script>
</body>
</html>
