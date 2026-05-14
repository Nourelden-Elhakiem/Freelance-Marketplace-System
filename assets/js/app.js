import { renderIcons } from './icons.js';
import { initHeroCanvas } from './hero.js';
import { initDiagramLightbox } from './lightbox.js';
import { initAnimeMotion } from './animations.js';

function initNavigation() {
  const nav = document.getElementById('mainNav');
  const toggle = document.getElementById('navToggle');
  const list = document.getElementById('navList');

  if (nav) {
    const updateShadow = () => nav.classList.toggle('scrolled', window.scrollY > 8);
    updateShadow();
    window.addEventListener('scroll', updateShadow, { passive: true });
  }

  if (toggle && list) {
    toggle.addEventListener('click', () => {
      const open = list.classList.toggle('open');
      toggle.classList.toggle('open', open);
      toggle.setAttribute('aria-expanded', String(open));
    });
  }
}

function initCounters() {
  const counters = document.querySelectorAll('[data-count]');
  if (!counters.length) return;

  const animate = (element) => {
    const target = Number(element.dataset.count || 0);
    const start = performance.now();
    const duration = 900;

    const step = (now) => {
      const progress = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      element.textContent = String(Math.round(target * eased));
      if (progress < 1) requestAnimationFrame(step);
    };

    requestAnimationFrame(step);
  };

  if (!('IntersectionObserver' in window)) {
    counters.forEach(animate);
    return;
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        animate(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: .35 });

  counters.forEach((counter) => observer.observe(counter));
}

function initReveal() {
  const elements = document.querySelectorAll('.reveal, .sr-hidden');
  if (!elements.length) return;

  if (!('IntersectionObserver' in window)) {
    elements.forEach((element) => element.classList.add('is-visible', 'sr-visible'));
    return;
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible', 'sr-visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: .08, rootMargin: '0px 0px -30px 0px' });

  elements.forEach((element) => observer.observe(element));
}

function initCursorGlow() {
  const canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  if (!canHover || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  const glow = document.createElement('div');
  glow.className = 'cursor-glow';
  glow.setAttribute('aria-hidden', 'true');
  document.body.appendChild(glow);

  let targetX = window.innerWidth / 2;
  let targetY = window.innerHeight / 2;
  let currentX = targetX;
  let currentY = targetY;

  window.addEventListener('pointermove', (event) => {
    targetX = event.clientX;
    targetY = event.clientY;
  }, { passive: true });

  function animate() {
    currentX += (targetX - currentX) * .13;
    currentY += (targetY - currentY) * .13;
    glow.style.transform = `translate3d(${currentX}px, ${currentY}px, 0) translate(-50%, -50%)`;
    requestAnimationFrame(animate);
  }

  animate();
}

document.addEventListener('DOMContentLoaded', () => {
  renderIcons();
  initNavigation();
  initCounters();
  initAnimeMotion();
  initHeroCanvas();
  initDiagramLightbox();
  initCursorGlow();
});
