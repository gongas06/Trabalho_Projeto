// Carrossel horizontal para a secção "Últimos Resultados".
document.addEventListener("DOMContentLoaded", () => {
  const section = document.querySelector(".ultimos-resultados");
  if (!section) return;

  const grid = section.querySelector(".resultados-grid");
  const prevBtn = section.querySelector(".carousel-btn.prev");
  const nextBtn = section.querySelector(".carousel-btn.next");

  const moreLink = section.querySelector(".carousel-more");
  if (!grid || !prevBtn || !nextBtn || !moreLink) return;

  // Define o passo de scroll com base na largura do cartão + gap.
  const getStep = () => {
    const card = grid.querySelector(".resultado-card");
    if (!card) return grid.clientWidth;
    const styles = window.getComputedStyle(grid);
    const gap = parseInt(styles.columnGap || styles.gap || "0", 10);
    return card.offsetWidth + (Number.isNaN(gap) ? 0 : gap);
  };

  // Ativa/desativa setas e mostra o link "mais" quando chega ao fim.
  const updateButtons = () => {
    const maxScroll = grid.scrollWidth - grid.clientWidth;
    const atStart = grid.scrollLeft <= 2;
    const atEnd = grid.scrollLeft >= maxScroll - 2;
    prevBtn.disabled = atStart;
    nextBtn.disabled = atEnd;
    moreLink.classList.toggle("is-hidden", !atEnd);
  };

  prevBtn.addEventListener("click", () => {
    grid.scrollBy({ left: -getStep(), behavior: "smooth" });
  });

  nextBtn.addEventListener("click", () => {
    grid.scrollBy({ left: getStep(), behavior: "smooth" });
  });

  grid.addEventListener("scroll", updateButtons, { passive: true });
  window.addEventListener("resize", updateButtons);
  moreLink.classList.add("is-hidden");
  updateButtons();
});
