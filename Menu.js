// menu.js — controla o menu hambúrguer

document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.getElementById("hamburger");
  const navMenu = document.getElementById("navMenu");

  if (hamburger && navMenu) {
    hamburger.addEventListener("click", () => {
      navMenu.classList.toggle("ativo");
    });
  }
});

// --- Animação dos contadores no Palmarés ---
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
