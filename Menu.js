

document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.getElementById("hamburger");
  const navMenu = document.getElementById("navMenu");

  if (hamburger && navMenu) {
    hamburger.addEventListener("click", () => {
      navMenu.classList.toggle("ativo");
    });
  }
});


document.addEventListener("DOMContentLoaded", () => {
  const counters = document.querySelectorAll(".contador");

  const animateCount = (el) => {
    const target = +el.getAttribute("data-target");
    const duration = 1500;
    const start = 0;
    const step = (timestamp, startTime) => {
      const progress = Math.min((timestamp - startTime) / duration, 1);
      el.textContent = Math.floor(progress * target);
      if (progress < 1) requestAnimationFrame((t) => step(t, startTime));
      else el.textContent = target;
    };
    requestAnimationFrame((t) => step(t, performance.now()));
  };

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting && !entry.target.classList.contains("done")) {
          animateCount(entry.target);
          entry.target.classList.add("done");
        }
      });
    },
    { threshold: 0.6 }
  );

  counters.forEach((counter) => observer.observe(counter));
});

document.addEventListener("DOMContentLoaded", () => {
  const grid = document.querySelector(".ultimos-resultados .resultados-grid");
  const prevBtn = document.querySelector(".ultimos-resultados .carousel-btn.prev");
  const nextBtn = document.querySelector(".ultimos-resultados .carousel-btn.next");

  if (!grid || !prevBtn || !nextBtn) return;

  const getStep = () => {
    const card = grid.querySelector(".resultado-card");
    if (!card) return grid.clientWidth;
    const styles = window.getComputedStyle(grid);
    const gap = parseInt(styles.columnGap || styles.gap || "0", 10);
    return card.offsetWidth + (Number.isNaN(gap) ? 0 : gap);
  };

  prevBtn.addEventListener("click", () => {
    grid.scrollBy({ left: -getStep(), behavior: "smooth" });
  });

  nextBtn.addEventListener("click", () => {
    grid.scrollBy({ left: getStep(), behavior: "smooth" });
  });
});
