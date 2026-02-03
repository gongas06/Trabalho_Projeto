<!-- Rodapé global com contactos, links e redes sociais. -->
<footer class="footer">
  <div class="footer-content">

    <div class="footer-section">
      <h3>Contactos</h3>
      <p><strong>Morada:</strong> Bairro Stº Antonio</p>
      <p><strong>Telefone:</strong> +351 969 810 274</p>
      <p><strong>Email:</strong> adpbarca@gmail.com</p>
    </div>

    <div class="footer-section">
      <h3>Links</h3>
      <ul>
        <li><a href="história.php">História</a></li>
        <li><a href="noticias.php">Notícias</a></li>
        <li><a href="galeria.php">Galeria</a></li>
      </ul>
    </div>

    <div class="footer-section footer-cta-section">
      <a href="patrocinadores.php" class="footer-cta">Patrocinadores</a>
    </div>

    <div class="footer-section">
      <h3>Redes Sociais</h3>
      <div class="social-icons">
        <a href="https://www.facebook.com/adpboficial"><img src="Imagens/Gerais/Facebook.png" alt="Facebook"></a>
        <a href="https://www.instagram.com/adpontedabarca/"><img src="Imagens/Gerais/Instagram.png" alt="Instagram"></a>
      </div>
    </div>

  </div>

  <div class="footer-bottom">
    <p>© <?= date("Y") ?> Associação Desportiva de Ponte da Barca - Todos os direitos reservados</p>
    <div class="footer-links">
      <a href="privacidade.php">Política de Privacidade e Cookies</a>
      <span>|</span>
      <a href="termos.php">Termos e Condições</a>
    </div>
  </div>
</footer>

<!-- Estilos específicos do rodapé (mantidos inline neste include). -->
<style>

.footer {
  background-color: #000;
  color: #fff;
  padding: 40px 20px 20px;
  font-family: Arial, sans-serif;
}

.footer-content {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
}

.footer-section {
  min-width: 250px;
  margin-bottom: 20px;
}

.footer-section h3 {
  margin-bottom: 15px;
}

.footer-section p,
.footer-section li {
  margin-bottom: 8px;
  font-size: 14px;
}

.footer-section ul {
  list-style: none;
  padding: 0;
}

.footer-section a {
  color: #fff;
  text-decoration: none;
}

.footer-section a:hover {
  text-decoration: underline;
}

.footer-cta-section {
  display: flex;
  align-items: center;
}

.social-icons img {
  width: 45px;
  margin-right: 10px;
}

.footer-bottom {
  border-top: 1px solid #444;
  margin-top: 30px;
  padding-top: 15px;
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  font-size: 13px;
  gap: 12px;
}

.footer-links a {
  color: #fff;
  text-decoration: none;
  margin: 0 5px;
}

.footer-cta {
  background: #c1272d;
  color: #fff;
  text-decoration: none;
  padding: 10px 26px;
  border-radius: 2px;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  font-weight: 700;
  display: inline-block;
}

.footer-cta:hover {
  background: #9e1b20;
}

</style>
