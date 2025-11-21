// === Carrossel Automático ADPB ===
const carrossel = document.getElementById("meuCarrossel");
const items = document.querySelectorAll("#meuCarrossel .item");

let indexAtual = 0;
const total = items.length;
const intervalo = 4000; // 4 segundos (podes ajustar)

// Função para mostrar o item desejado
function mostrarItem(novoIndex) {
  const larguraItem = items[0].offsetWidth + 20; // inclui o gap/margem
  carrossel.scrollTo({
    left: larguraItem * novoIndex,
    behavior: "smooth"
  });
}

// Função para rolar manualmente
function rolarCarrossel(direcao) {
  indexAtual += direcao;

  // Faz o loop infinito
  if (indexAtual < 0) indexAtual = total - 1;
  if (indexAtual >= total) indexAtual = 0;

  mostrarItem(indexAtual);
}

// ⏱️ Avanço automático
let autoSlide = setInterval(() => {
  indexAtual = (indexAtual + 1) % total;
  mostrarItem(indexAtual);
}, intervalo);

// Liga as setas
const setaEsquerda = document.querySelector(".seta-esquerda");
const setaDireita = document.querySelector(".seta-direita");

if (setaEsquerda && setaDireita) {
  setaEsquerda.addEventListener("click", () => {
    clearInterval(autoSlide); // pausa o automático
    rolarCarrossel(-1);
    reiniciarAutoSlide();
  });

  setaDireita.addEventListener("click", () => {
    clearInterval(autoSlide);
    rolarCarrossel(1);
    reiniciarAutoSlide();
  });
}

// 🔁 Reinicia o avanço automático após clique
function reiniciarAutoSlide() {
  autoSlide = setInterval(() => {
    indexAtual = (indexAtual + 1) % total;
    mostrarItem(indexAtual);
  }, intervalo);
}

