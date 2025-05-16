<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Jogo da Reciclagem</title>
  <!-- Bootstrap e Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background-color: #e8f5e9;
    }
    .lixeiras {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-top: 20px;
      flex-wrap: wrap;
    }
    .lixeira {
      width: 140px;
      height: 140px;
      background-color: #f0f0f0;
      border: 2px solid #bbb;
      border-radius: 15px;
      cursor: pointer;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      font-size: 16px;
      transition: 0.3s;
    }
    .lixeira:hover {
      transform: scale(1.05);
      background-color: #d1f2eb;
    }
    .lixeira i {
      font-size: 32px;
      margin-bottom: 8px;
    }
    #jogo-container, #resultado {
      display: none;
    }
  </style>
</head>
<body>

<div class="container py-4">
  <div class="card shadow-lg">
    <div class="card-body text-center">

      <h1 class="text-success"><i class="fa-solid fa-recycle"></i> Jogo da Reciclagem</h1>

      <!-- Início -->
      <form method="post" id="inicio-container" action="armazena.php">
        <input type="text" name="nomeJogador" id="nome-jogador" class="form-control w-50 mx-auto my-3" placeholder="Digite seu nome">
        <div class="d-flex justify-content-center gap-3">
          <button id="btn-iniciar" class="btn btn-primary btn-lg">Iniciar Jogo</button>
          <button id="btn-ver-ranking" class="btn btn-outline-success btn-lg">Ver Ranking</button>
        </div>
      

      <!-- Jogo -->
      <div id="jogo-container">
        <div id="palavra-lixo" class="fs-3 text-primary mb-3">Clique na lixeira correta</div>
        <div class="lixeiras">
          <div class="lixeira" data-tipo="metal"><i class="fa-solid fa-drum-steelpan"></i>Metal</div>
          <div class="lixeira" data-tipo="papel"><i class="fa-solid fa-file-lines"></i>Papel</div>
          <div class="lixeira" data-tipo="organico"><i class="fa-solid fa-leaf"></i>Orgânico</div>
          <div class="lixeira" data-tipo="plastico"><i class="fa-solid fa-bottle-water"></i>Plástico</div>
        </div>
        <div id="pontuacao" class="text-dark mt-3 fs-5">Pontuação: 0</div>
        <div id="cronometro" class="text-danger fs-5">Tempo: 30s</div>
      </div>

      <!-- Resultado -->
      <div id="resultado">
        <h3 class="text-success mt-4">🏆 Pódio</h3>
        <ul id="podio" class="list-group w-50 mx-auto"></ul>
        <h4 class="mt-4">📋 Todos os jogadores</h4>
        <ul id="ranking" class="list-group w-50 mx-auto">
          
        </ul>
        <button id="btn-reiniciar" class="btn btn-secondary mt-4">Voltar ao Início</button>
      </div>
</form>
    </div>
  </div>
</div>
<script>
  const residuos = [
    { palavra: 'Lata de refrigerante', tipo: 'metal' },
    { palavra: 'Folha de caderno', tipo: 'papel' },
    { palavra: 'Casca de banana', tipo: 'organico' },
    { palavra: 'Papelão', tipo: 'papel' },
    { palavra: 'Restos de comida', tipo: 'organico' },
    { palavra: 'Prego enferrujado', tipo: 'metal' },
    { palavra: 'Revista velha', tipo: 'papel' },
    { palavra: 'Tampa de lata', tipo: 'metal' },
    { palavra: 'Embalagem de shampoo', tipo: 'plastico' },
    { palavra: 'Garrafa PET', tipo: 'plastico' },
    { palavra: 'Sacola de supermercado', tipo: 'plastico' },
    { palavra: 'Guardanapo usado', tipo: 'organico' },
    { palavra: 'Copo plástico', tipo: 'plastico' }
  ];

  let pontuacao = 0;
  let palavraAtual = {};
  let tempoRestante = 30;
  let respostaTimeout;
  let cronometroInterval;
  let jogadorAtual = "";
  const jogadores = [];

  const btnIniciar = document.getElementById('btn-iniciar');
  const btnRanking = document.getElementById('btn-ver-ranking');
  const nomeInput = document.getElementById('nome-jogador');
  const jogoContainer = document.getElementById('jogo-container');
  const elementoPalavra = document.getElementById('palavra-lixo');
  const elementoPontuacao = document.getElementById('pontuacao');
  const elementoCronometro = document.getElementById('cronometro');
  const lixeiras = document.querySelectorAll('.lixeira');
  const resultado = document.getElementById('resultado');
  const podio = document.getElementById('podio');
  const ranking = document.getElementById('ranking');

  function novaPalavra() {
    clearTimeout(respostaTimeout);
    const indice = Math.floor(Math.random() * residuos.length);
    palavraAtual = residuos[indice];
    elementoPalavra.innerText = palavraAtual.palavra;
    respostaTimeout = setTimeout(() => {
      alert("Tempo esgotado! Era: " + palavraAtual.tipo);
      novaPalavra();
    }, 3000);
  }

  lixeiras.forEach(lixeira => {
    lixeira.addEventListener('click', () => {
      const tipoEscolhido = lixeira.getAttribute('data-tipo');
      clearTimeout(respostaTimeout);
      if (tipoEscolhido === palavraAtual.tipo) {
        pontuacao++;
        alert('Acertou! 🥳');
      } else {
        alert('Errou! 😢 Era: ' + palavraAtual.tipo);
      }
      elementoPontuacao.innerText = 'Pontuação: ' + pontuacao;
      novaPalavra();
    });
  });

  function iniciarJogo() {
    jogadorAtual = nomeInput.value.trim();
    if (jogadorAtual === "") {
      alert("Por favor, digite seu nome.");
      return;
    }
    btnIniciar.style.display = 'none';
    btnRanking.style.display = 'none';
    nomeInput.style.display = 'none';
    jogoContainer.style.display = 'block';
    cronometroInterval = setInterval(() => {
      tempoRestante--;
      elementoCronometro.innerText = 'Tempo: ' + tempoRestante + 's';
      if (tempoRestante <= 0) {
        clearInterval(cronometroInterval);
        clearTimeout(respostaTimeout);
        jogadores.push({ nome: jogadorAtual, pontos: pontuacao });
        mostrarRanking();
      }
    }, 1000);
    novaPalavra();
  }

  function mostrarRanking() {
    jogoContainer.style.display = 'none';
    resultado.style.display = 'block';
    const ordenados = jogadores.sort((a, b) => b.pontos - a.pontos);    
    podio.innerHTML = "";
    ordenados.slice(0, 3).forEach((j, i) => {
      const medalha = i === 0 ? '🥇' : i === 1 ? '🥈' : '🥉';
      podio.innerHTML += `<li class="list-group-item">${medalha} ${j.nome} - ${j.pontos} pontos</li>`;
    });
    ranking.innerHTML = "";
    ordenados.forEach(j => {
      ranking.innerHTML += `<li class="list-group-item">${j.nome} - ${j.pontos} pontos</li>`;
    });
  }

  btnIniciar.addEventListener('click', iniciarJogo);
  btnRanking.addEventListener('click', mostrarRanking);
  document.getElementById('btn-reiniciar').addEventListener('click', () => location.reload());
</script>
</body>
</html>