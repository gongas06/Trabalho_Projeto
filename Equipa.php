<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Equipa</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- 🔻 Cabeçalho -->
  <header class="topo">
    <img src="Imagens/Gerais/Logotipo ADPB_projeto.png" alt="Logo ADPB" class="logo">


    <button class="hamburger" id="hamburger">☰</button>

    <nav class="nav-principal" id="navMenu">

      <ul>
        <li><a href="index.php">Início</a></li>
        <li><a href="história.php">História</a></li>
        <li><a href="noticias.php">Noticias</a></li>
        <li><a href="resultados.php">Resultados</a></li>
        <li><a href="agenda.php">Agenda</a></li>
        <li><a href="Equipa.php" class="ativo">Equipa</a></li>
        <li><a href="galeria.php">Galeria</a></li>
        <li><a href="contactos.php">Contactos</a></li>
        
        

<?php if (isset($_SESSION['username'])): ?>
  <li class="user-info">
    <a href="Utilizador/perfil.php" class="user-link">
       <?php echo htmlspecialchars($_SESSION['username']); ?>
    </a>
    <a href="admin/logout.php" class="logout-link">Sair</a>
  </li>
<?php else: ?>
  <li><a href="admin/login.php">Entrar</a></li>
<?php endif; ?>


      </ul>
    </nav>

  </header>


<section class="equipa-section">
   <h1>A Nossa Equipa</h1>

  <h2 class="subtitulo">Jogadores</h2>

<!-- Modal Helder -->
<div id="modal-helder" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('helder')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Helder_Cerqueira.jpeg" alt="Helder Cerqueira">
      <div>
        <h2>Helder Cerqueira</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Hélder Fernando Fonte Cerqueira</p>
      <p><strong>Data de nascimento:</strong> 10 de maio de 1990</p>
      <p><strong>Nacionalidade:</strong>Portuguesa</p>
      <p><strong>Posição:</strong> Guarda-Redes</p>
      <p><strong>Número:</strong> 1</p>
    </div>
  </div>
</div>

<!-- Card Helder -->
  <div class="equipa-grid">
    <div class="jogador-card" onclick="abrirModal('helder')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Helder_Cerqueira.jpeg" alt="Jogador" class="foto">
      <div class="nome">Helder Cerqueira</div>
      <div class="posicao"> Guarda-Redes</div>
      <div class="extra">🇵🇹  | #1</div>
    </div>


<!-- Modal Luís -->

<div id="modal-Luis" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Luis')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Luís_Araújo.jpeg " alt="Luis Araújo">
      <div>
        <h2>Luís Araújo</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Luís Miguel Cunha Araújo</p>
      <p><strong>Data de nascimento:</strong> 22 de janeiro de 2007</p>
      <p><strong>Nacionalidade:</strong> Portuguesa</p>
      <p><strong>Posição:</strong> Guarda-Redes</p>
      <p><strong>Número:</strong> 22</p>
    </div>
  </div>
</div>


<!-- Card Luís -->

        <div class="jogador-card" onclick="abrirModal('Luis')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Luís_Araújo.jpeg" alt="Jogador" class="foto">
      <div class="nome">Luís Araújo</div>
      <div class="posicao"> Guarda-Redes</div>
      <div class="extra">🇵🇹  | #22</div>
    </div>

<!-- Modal Nuno Duarte -->
<div id="modal-Nuno_Duarte" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Nuno_Duarte')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Nuno_Duarte.jpeg" alt="Nuno Duarte'">
      <div>
        <h2>Nuno Duarte</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Nuno Filipe Gonçalves Duarte</p>
      <p><strong>Data de nascimento:</strong> 29 de agosto de 1983</p>
      <p><strong>Nacionalidade:</strong>Portuguesa</p>
      <p><strong>Posição:</strong> Guarda-Redes</p>
      <p><strong>Número:</strong> 31</p>
    </div>
  </div>
</div>

<!-- Card Nuno Duarte -->

        <div class="jogador-card" onclick="abrirModal('Nuno_Duarte')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Nuno_Duarte.jpeg" alt="Jogador" class="foto">
      <div class="nome">Nuno Duarte</div>
      <div class="posicao"> Guarda-Redes</div>
      <div class="extra">🇵🇹  | #31</div>
    </div>


<!-- Modal Tiago-->

<div id="modal-Tiago" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Tiago')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_ Tiago_Almeida.jpeg " alt="Tiago Almeida">
      <div>
        <h2>Tiago Almeida</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Tiago Rebelo Almeida</p>
      <p><strong>Data de nascimento:</strong> 25 de novembro de 2001</p>
      <p><strong>Nacionalidade:</strong>Portuguesa</p>
      <p><strong>Posição:</strong> Defesa</p>
      <p><strong>Número:</strong> 4</p>
    </div>
  </div>
</div>

<!-- Card Tiago-->
    <div class="jogador-card" onclick="abrirModal('Tiago')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_ Tiago_Almeida.jpeg" alt="Jogador" class="foto">
      <div class="nome">Tiago Almeida</div>
      <div class="posicao"> Defesa</div>
      <div class="extra">🇵🇹  | #4</div>
    </div>


<!-- Modal Nuno-->
<div id="modal-Nuno" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Nuno')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Nuno_Esteves.jpeg" alt="Nuno Esteves">
      <div>
        <h2>Nuno Esteves</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Nuno Alves Silva Martins Esteves</p>
      <p><strong>Data de nascimento:</strong> 4 de dezembro de 2006</p>
      <p><strong>Nacionalidade:</strong>Portuguesa</p>
      <p><strong>Posição:</strong> Defesa</p>
      <p><strong>Número:</strong> 44</p>
    </div>
  </div>
</div>

<!-- Card Nuno -->
 
    <div class="jogador-card" onclick="abrirModal('Nuno')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Nuno_Esteves.jpeg" alt="Jogador" class="foto">
      <div class="nome">Nuno Esteves</div>
      <div class="posicao"> Defesa</div>
      <div class="extra">🇵🇹 | #44</div>
    </div>

<!-- Modal Wilson -->

<div id="modal-Wilson" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Wilson')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Wilson_Alves.jpeg" alt="Wilson Alves">
      <div>
        <h2>Wilson Alves</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Wilson Andre Rodrigues Alves</p>
      <p><strong>Data de nascimento:</strong> 9 de fevereiro de 2002</p>
      <p><strong>Nacionalidade:</strong> Portuguesa</p>
      <p><strong>Posição:</strong> Defesa</p>
      <p><strong>Número:</strong> 7</p>
    </div>
  </div>
</div>

<!-- Card Wilson -->

    <div class="jogador-card" onclick="abrirModal('Wilson')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Wilson_Alves.jpeg" alt="Jogador" class="foto">
      <div class="nome">Wilson Alves</div>
      <div class="posicao"> Defesa</div>
      <div class="extra">🇵🇹 | #7</div>
    </div>

<!-- Modal José Santos -->

<div id="modal-José" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('José')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_José_Santos.jpeg" alt="Wilson Alves">
      <div>
        <h2>José Santos</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> José Pedro Silva Vieira Santos</p>
      <p><strong>Data de nascimento:</strong> 17 de março de 1993</p>
      <p><strong>Nacionalidade:</strong> Portuguesa</p>
      <p><strong>Posição:</strong> Defesa</p>
      <p><strong>Número:</strong> 24</p>
    </div>
  </div>
</div>


<!-- Card José Santos -->

  <div class="jogador-card" onclick="abrirModal('José')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_José_Santos.jpeg" alt="Jogador" class="foto">
      <div class="nome">José Santos</div>
      <div class="posicao"> Defesa</div>
      <div class="extra">🇵🇹 | #24</div>
    </div>

<!-- Modal David Caravalho -->

<div id="modal-David" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('David')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_David.jpeg" alt="Wilson Alves">
      <div>
        <h2>David Carvalho</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> David Manuel Fernades Carvalho</p>
      <p><strong>Data de nascimento:</strong> 8 de fevereiro de 1994</p>
      <p><strong>Nacionalidade:</strong> Portuguesa</p>
      <p><strong>Posição:</strong> Defesa</p>
      <p><strong>Número:</strong> 25</p>
    </div>
  </div>
</div>



<!-- Card David Carvalho -->
<div class="jogador-card" onclick="abrirModal('David')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_David.jpeg" alt="Jogador" class="foto">
      <div class="nome">David Carvalho</div>
      <div class="posicao"> Defesa</div>
      <div class="extra">🇵🇹 | #25</div>
    </div>

<!-- Modal Matheus -->

<div id="modal-Matheus" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Matheus')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Matheus.jpeg" alt="Wilson Alves">
      <div>
        <h2>Matheus Conceição</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Mateus Henrique Da Conceição</p>
      <p><strong>Data de nascimento:</strong> 16 de janeiro de 2003</p>
      <p><strong>Nacionalidade:</strong>Brasileira</p>
      <p><strong>Posição:</strong> Defesa</p>
      <p><strong>Número:</strong> 2</p>
    </div>
  </div>
</div>


   <!-- Card Matehus --> 
<div class="jogador-card" onclick="abrirModal('Matheus')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Matheus.jpeg" alt="Jogador" class="foto">
      <div class="nome">Matheus Conceição</div>
      <div class="posicao"> Defesa</div>
      <div class="extra">🇧🇷 | #2</div>
    </div>

<!-- Modal Gabriel -->
<div id="modal-Gabriel" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Gabriel')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Gabriel.jpeg" alt="Wilson Alves">
      <div>
        <h2>Gabriel Branco</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Gabriel Neves Da Rocha Branco</p>
      <p><strong>Data de nascimento:</strong> 30 de janeiro de 1999</p>
      <p><strong>Nacionalidade:</strong> Brasileira</p>
      <p><strong>Posição:</strong> Defesa</p>
      <p><strong>Número:</strong> 12</p>
    </div>
  </div>
</div>


<!-- Card Gabriel --> 
   <div class="jogador-card" onclick="abrirModal('Gabriel')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Gabriel.jpeg" alt="Jogador" class="foto">
      <div class="nome">Gabriel Branco</div>
      <div class="posicao"> Defesa</div>
      <div class="extra">🇧🇷  | #12</div>
    </div>

    
<!-- Modal Fillipe -->
<div id="modal-Fellipe" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Fellipe')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Filipe.jpeg" alt="Filipe Fernades">
      <div>
        <h2>Fellipe Fernades</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Fellipe Barbosa Fernandes</p>
      <p><strong>Data de nascimento:</strong> 15 de abril de 2003</p>
      <p><strong>Nacionalidade:</strong> Brasileira</p>
      <p><strong>Posição:</strong> Defesa</p>
      <p><strong>Número:</strong> 5</p>
    </div>
  </div>
</div>


<!-- Card Filipe --> 
      <div class="jogador-card" onclick="abrirModal('Fellipe')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Filipe.jpeg" alt="Jogador" class="foto">
      <div class="nome">Fellipe Fernades</div>
      <div class="posicao"> Defesa</div>
      <div class="extra">🇧🇷  | #5</div>
    </div>


<!-- Modal Gonçalo -->
<div id="modal-Goncalo" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Goncalo')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Gonçalo_Matos.jpeg"alt="Gonaçalo Matos">
      <div>
        <h2>Gonçalo Matos</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Goncalo Cerqueira Matos</p>
      <p><strong>Data de nascimento:</strong> 13 de janeiro de 2003</p>
      <p><strong>Nacionalidade:</strong>Portuguesa</p>
      <p><strong>Posição:</strong> Médio</p>
      <p><strong>Número:</strong> 14</p>
    </div>
  </div>
</div>

<!-- Card Gonçalo -->

    <div class="jogador-card"  onclick="abrirModal('Goncalo')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Gonçalo_Matos.jpeg" alt="Jogador" class="foto">
      <div class="nome">Gonçalo Matos</div>
      <div class="posicao">Médio</div>
      <div class="extra">🇵🇹  | #14</div>
    </div>
    

<!-- Modal José Rego -->
<div id="modal-José Rego" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('José Rego')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_José_Rego.jpeg" alt="José Rego">
      <div>
        <h2>José Rego</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Jose Fernando Sousa Rego</p>
      <p><strong>Data de nascimento:</strong> 20 de abril de 1996</p>
      <p><strong>Nacionalidade:</strong> Portuguesa</p>
      <p><strong>Posição:</strong> Médio</p>
      <p><strong>Número:</strong> 6</p>
    </div>
  </div>
</div>


 <!-- Card José Rego -->    
<div class="jogador-card" onclick="abrirModal('José Rego')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_José_Rego.jpeg" alt="Jogador" class="foto">
      <div class="nome">José Rego</div>
      <div class="posicao"> Médio</div>
      <div class="extra">🇵🇹 | #6</div>
    </div>

<!-- Modal Nuno Rego -->
<div id="modal-Nuno Rego" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Nuno Rego')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Nuno_Rego.jpeg "alt="Nuno Rego">
      <div>
        <h2>Nuno Rego</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Nuno Miguel Dias Rego</p>
      <p><strong>Data de nascimento:</strong> 6 de agosto de 2001</p>
      <p><strong>Nacionalidade:</strong> Portuguesa</p>
      <p><strong>Posição:</strong> Médio</p>
      <p><strong>Número:</strong> 8</p>
    </div>
  </div>
</div>

<!-- Card Nuno Rego -->  
    <div class="jogador-card" onclick="abrirModal('Nuno Rego')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Nuno_Rego.jpeg" alt="Jogador" class="foto">
      <div class="nome">Nuno Rego</div>
      <div class="posicao"> Médio</div>
      <div class="extra">🇵🇹 | #8</div>
    </div>

<!-- Modal Rodrigo Airosa -->
<div id="modal-Rodrigo" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Rodrigo')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagens_Jogador_Rodrigo_Airosa.jpeg" alt="José Rego">
      <div>
        <h2>Rodrigo Airosa</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Rodrigo Castro Airosa</p>
      <p><strong>Data de nascimento:</strong> 17 de agosto de 2006</p>
      <p><strong>Nacionalidade:</strong> Portuguesa</p>
      <p><strong>Posição:</strong> Médio</p>
      <p><strong>Número:</strong> 20</p>
    </div>
  </div>
</div>


<!-- Card Rodrigo Airosa -->  
<div class="jogador-card" onclick="abrirModal('Rodrigo')">
      <img src="Imagens/Equipa/Jogadores/Imagens_Jogador_Rodrigo_Airosa.jpeg" alt="Jogador" class="foto">
      <div class="nome">Rodrigo Airosa</div>
      <div class="posicao"> Médio</div>
      <div class="extra">🇵🇹  | #20</div>
    </div>


<!-- Modal Allasan -->
<div id="modal-Allasan" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Allasan')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Alsan.jpeg" alt="José Rego">
      <div>
        <h2>Alsan Mendes</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Alsan Bobo Mendes</p>
      <p><strong>Data de nascimento:</strong> 10 de maio de 2003</p>
      <p><strong>Nacionalidade:</strong> Guineense</p>
      <p><strong>Posição:</strong> Médio</p>
      <p><strong>Número:</strong> 17</p>
    </div>
  </div>
</div>

<!-- Card Allasan-->  
    <div class="jogador-card" onclick="abrirModal('Allasan')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Alsan.jpeg" alt="Jogador" class="foto">
      <div class="nome">Alsan Mendes</div>
      <div class="posicao"> Médio</div>
      <div class="extra">🇬🇼  | #17</div>
    </div>

<!-- Modal Adam -->
<div id="modal-Adam" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Adam')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Adam.jpeg" alt="José Rego">
      <div>
        <h2>Adam Kuczynski</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Adam Kuczynski </p>
      <p><strong>Data de nascimento:</strong> 7 de Março de 2006</p>
      <p><strong>Nacionalidade:</strong>Polonês</p>
      <p><strong>Posição:</strong> Médio</p>
      <p><strong>Número:</strong> 15</p>
    </div>
  </div>
</div>


<!-- Card Adam -->  
    <div class="jogador-card" onclick="abrirModal('Adam')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Adam.jpeg" alt="Jogador" class="foto">
      <div class="nome">Adam Kuczynsky</div>
      <div class="posicao"> Médio</div>
      <div class="extra">🇵🇱 | #15</div>
    </div>


    <!-- Modal Leonardo -->
<div id="modal-Leonardo" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Leonardo')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Leonardo.jpeg" alt="José Rego">
      <div>
        <h2>Leonardo Soares</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Leonardo Emanuel Beito Soares</p>
      <p><strong>Data de nascimento:</strong> 5 de janeiro de 1995</p>
      <p><strong>Nacionalidade:</strong> Portuguesa</p>
      <p><strong>Posição:</strong> Médio</p>
      <p><strong>Número:</strong> 23</p>
    </div>
  </div>
</div>

<!-- Card Leonardo -->  
    <div class="jogador-card" onclick="abrirModal('Leonardo')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Leonardo.jpeg"alt="Jogador" class="foto">
      <div class="nome">Leonardo Soares</div>
      <div class="posicao"> Médio</div>
      <div class="extra">🇵🇹  | #23</div>
    </div>


    <!-- Modal Joao Silva -->
<div id="modal-Joao Silva" class="modal"> 
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Joao Silva')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_João_Silva.jpeg" alt="José Rego">
      <div>
        <h2>João Silva</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Joao Miguel Araujo Silva</p>
      <p><strong>Data de nascimento:</strong> 2 de setembro de 2006</p>
      <p><strong>Nacionalidade:</strong> Portuguesa</p>
      <p><strong>Posição:</strong> Médio</p>
      <p><strong>Número:</strong> 21</p>
    </div>
  </div>
</div>

<!-- Card Joao Silva -->  
    <div class="jogador-card" onclick="abrirModal('Joao Silva')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_João_Silva.jpeg" alt="Jogador" class="foto">
      <div class="nome">João Silva</div>
      <div class="posicao"> Médio</div>
      <div class="extra">🇵🇹  | #21</div>
    </div>


<!-- Modal Bruno-->
<div id="modal-Bruno" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Bruno')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Bruno.jpeg" alt="José Rego">
      <div>
        <h2>Bruno Filipe</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Bruno Miguel Teixeira Filipe</p>
      <p><strong>Data de nascimento:</strong> 25 de agosto de 1998</p>
      <p><strong>Nacionalidade:</strong> Português </p>
      <p><strong>Posição:</strong> Médio</p>
      <p><strong>Número:</strong> 10</p>
    </div>
  </div>
</div>

<!-- Card Bruno -->  
    <div class="jogador-card" onclick="abrirModal('Bruno')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Bruno.jpeg" alt="Jogador" class="foto">
      <div class="nome">Bruno Filipe</div>
      <div class="posicao"> Médio</div>
      <div class="extra">🇵🇹  | #10</div>
    </div>

<!-- Modal Danilo -->

<div id="modal-Danilo" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Danilo')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Danilo.jpeg" alt="Danilo Oliveira">
      <div>
        <h2>Danilo Oliveira</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Danilo Constantino Azevedo Oliveira</p>
      <p><strong>Data de nascimento:</strong> 25 de julho de 2004</p>
      <p><strong>Nacionalidade:</strong> Portuguesa</p>
      <p><strong>Posição:</strong> Avançado</p>
      <p><strong>Número:</strong> 18</p>
    </div>
  </div>
</div>

<!-- Card Danilo -->  
    <div class="jogador-card" onclick="abrirModal('Danilo')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Danilo.jpeg" alt="Jogador" class="foto">
      <div class="nome">Danilo Oliveira</div>
      <div class="posicao"> Avançado</div>
      <div class="extra">🇵🇹  | #18</div>
    </div>


<!-- Modal Luis Guerra -->
<div id="modal-Luis Guerra" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Luis Guerra')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Luís_Guerra.jpeg" alt="José Rego">
      <div>
        <h2>Luís Guerra</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Luis Miguel Monteiro Guerra</p>
      <p><strong>Data de nascimento:</strong> 1 de março de 2000</p>
      <p><strong>Nacionalidade:</strong> Portuguesa</p>
      <p><strong>Posição:</strong> Avançado</p>
      <p><strong>Número:</strong> 9</p>
    </div>
  </div>
</div>

<!-- Card Luis Guerra-->  
    <div class="jogador-card" onclick="abrirModal('Luis Guerra')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Luís_Guerra.jpeg" alt="Jogador" class="foto">
      <div class="nome">Luís Guerra</div>
      <div class="posicao">Avançado</div>
      <div class="extra">🇵🇹  | #9</div>
    </div>

<!-- Modal Miguel -->
<div id="modal-Miguel" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Miguel')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Miguel.jpeg" alt="José Rego">
      <div>
        <h2>Miguel Loubane</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Miguel Silva Loubane</p>
      <p><strong>Data de nascimento:</strong> 25 de novembro de 2004</p>
      <p><strong>Nacionalidade:</strong> Portuguesa</p>
      <p><strong>Posição:</strong> Avançado</p>
      <p><strong>Número:</strong> 11</p>
    </div>
  </div>
</div>


<!-- Card Miguel-->  
    <div class="jogador-card" onclick="abrirModal('Miguel')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Miguel.jpeg" alt="Jogador" class="foto">
      <div class="nome">Miguel Loubane</div>
      <div class="posicao"> Avançado</div>
      <div class="extra">🇵🇹  | #11</div>
    </div>

<!-- Modal Coutinho -->
<div id="modal-Coutinho" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Coutinho')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Coutinho.jpeg" alt="José Rego">
      <div>
        <h2>Ricardo Coutinho</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Ricardo Inacio Silva Coutinho</p>
      <p><strong>Data de nascimento:</strong> 2 de novembro de 1989</p>
      <p><strong>Nacionalidade:</strong> Portuguesa</p>
      <p><strong>Posição:</strong> Avançado</p>
      <p><strong>Número:</strong> 19</p>
    </div>
  </div>
</div>


<!-- Card Coutinho-->  
    <div class="jogador-card" onclick="abrirModal('Coutinho')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Coutinho.jpeg" alt="Jogador" class="foto">
      <div class="nome">Ricardo Coutinho</div>
      <div class="posicao"> Avançado</div>
      <div class="extra">🇵🇹  | #19</div>
    </div>

<!-- Modal Claudio -->
<div id="modal-Claudio" class="modal">
  <div class="modal-conteudo-ficha">
    <span class="fechar" onclick="fecharModal('Claudio')">&times;</span>
    <div class="ficha-header">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Claúdio.jpeg" alt="José Rego">
      <div>
        <h2>Claudio Dantas</h2>
        <p><strong>Modalidade:</strong> Futebol</p>
        <p><strong>Clube Atual:</strong> AD Ponte da Barca</p>
      </div>
    </div>
    <hr>
    <div class="ficha-bio">
      <h3>BIO</h3>
      <p><strong>Nome completo:</strong> Claudio Alexandre Lamas Corredoura Dantas</p>
      <p><strong>Data de nascimento:</strong> 18 de abril de 1995</p>
      <p><strong>Nacionalidade:</strong> Portuguesa</p>
      <p><strong>Posição:</strong>Avançado</p>
      <p><strong>Número:</strong> 18</p>
    </div>
  </div>
</div>


<!-- Card Claudio -->  
    <div class="jogador-card" onclick="abrirModal('Claudio')">
      <img src="Imagens/Equipa/Jogadores/Imagem_Jogador_Claúdio.jpeg" alt="Jogador" class="foto">
      <div class="nome">Claúdio Dantas</div>
      <div class="posicao"> Avançado</div>
      <div class="extra">🇵🇹  | #18</div>
    </div>


  </div> 
</section>

    <h2 class="subtitulo">Equipa Técnica</h2>
    <div class="equipa-grid">
      <div class="jogador-card">
        <img src="Imagens/Equipa/Treinadores/Imagem_Treinador_Fernado_Rego.png" alt="Treinador" class="foto">
        <div class="nome">Fernando Rego</div>
        <div class="posicao">Treinador Principal</div>
      </div>



      <div class="jogador-card">
        <img src="Imagens/Equipa/Treinadores/Imagem_Treinador_Beto_Sá.png" alt="Treinador Adjunto" class="foto">
        <div class="nome">Beto Sá</div>
        <div class="posicao">Treinador Adjunto</div>
      </div>

      <div class="jogador-card">
        <img src="Imagens/Equipa/Treinadores/Imagem_Treinador_Rui_Almeida.png" alt="Treinador Adjunto" class="foto">
        <div class="nome">Rui Almeida</div>
        <div class="posicao">Treinador de Guarda-Redes</div>
      </div>

        <div class="jogador-card">
        <img src="Imagens/Equipa/Treinadores/Imagem_Fisioterapeuta_Mónica.png" alt="Fisioterapeuta" class="foto">
        <div class="nome">Mónica Machado</div>
        <div class="posicao">Fisioterapeuta</div>
      </div>


     </div> 
</section>

<?php include 'footer.php'; ?>

<script>
function abrirModal(id) {
  document.getElementById('modal-' + id).style.display = 'flex';
}

function fecharModal(id) {
  document.getElementById('modal-' + id).style.display = 'none';
}

// Fecha ao clicar fora do modal
window.onclick = function(event) {
  document.querySelectorAll('.modal').forEach(modal => {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  });
};
</script>

<script src="Menu.js"></script>



</body>
</html>
