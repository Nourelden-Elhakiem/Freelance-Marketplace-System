import { animate, createTimeline, splitText, stagger } from '../vendor/anime.esm.min.js';

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function revealElement(element, delay = 0) {
  animate(element, {
    opacity: { from: 0, to: 1 },
    y: { from: 18, to: 0 },
    duration: 620,
    delay,
    ease: 'outCubic'
  });
}

function initSectionMotion() {
  const targets = document.querySelectorAll('.reveal, .sr-hidden, .section-card, .table-card, .info-card');
  if (!targets.length) return;

  if (reducedMotion || !('IntersectionObserver' in window)) {
    targets.forEach((target) => target.classList.add('is-visible', 'sr-visible'));
    return;
  }

  targets.forEach((target) => {
    target.style.opacity = '0';
    target.style.transform = 'translateY(18px)';
  });

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;
      entry.target.classList.add('is-visible', 'sr-visible');
      revealElement(entry.target);
      observer.unobserve(entry.target);
    });
  }, { threshold: .08, rootMargin: '0px 0px -40px 0px' });

  targets.forEach((target) => observer.observe(target));
}

function initCardAndRowMotion() {
  if (reducedMotion) return;

  const cards = document.querySelectorAll('.nav-card, .stat-box, .module-card, .diagram-card, .detail-item');
  if (cards.length) {
    animate(cards, {
      opacity: { from: 0, to: 1 },
      y: { from: 12, to: 0 },
      duration: 520,
      delay: stagger(35),
      ease: 'outCubic'
    });
  }

  const rows = document.querySelectorAll('tbody tr');
  if (rows.length) {
    animate(rows, {
      opacity: { from: 0, to: 1 },
      x: { from: -8, to: 0 },
      duration: 420,
      delay: stagger(18),
      ease: 'outCubic'
    });
  }
}

function initHeroMotion() {
  if (reducedMotion) return;

  const hero = document.querySelector('.home-hero');
  if (!hero) return;

  animate('.hero-copy > .eyebrow, .hero-copy h2, .hero-copy p, .hero-actions', {
    opacity: { from: 0, to: 1 },
    y: { from: 18, to: 0 },
    duration: 700,
    delay: stagger(80),
    ease: 'outCubic'
  });

  animate('.hero-visual', {
    opacity: { from: 0, to: 1 },
    y: { from: 18, to: 0 },
    scale: { from: .985, to: 1 },
    duration: 780,
    delay: 220,
    ease: 'outCubic'
  });

  animate('.hero-panel', {
    opacity: { from: 0, to: 1 },
    x: { from: 24, to: 0 },
    duration: 760,
    delay: 260,
    ease: 'outCubic'
  });

  animate('.hero-abstract-dot', {
    scale: [
      { to: 1.45, duration: 900 },
      { to: 1, duration: 900 }
    ],
    opacity: [
      { to: .95, duration: 900 },
      { to: .72, duration: 900 }
    ],
    delay: stagger(180),
    loop: true,
    ease: 'inOutSine'
  });
}

function initButtonMotion() {
  if (reducedMotion) return;

  document.querySelectorAll('.btn, button, .quick-action-link, .social-link').forEach((button) => {
    button.addEventListener('pointerenter', () => {
      animate(button, {
        y: { to: -1 },
        scale: { to: 1.015 },
        duration: 180,
        ease: 'outQuad'
      });
    });

    button.addEventListener('pointerleave', () => {
      animate(button, {
        y: { to: 0 },
        scale: { to: 1 },
        duration: 220,
        ease: 'outQuad'
      });
    });

    button.addEventListener('pointerdown', () => {
      animate(button, {
        scale: [
          { to: .985, duration: 80 },
          { to: 1, duration: 160 }
        ],
        ease: 'outQuad'
      });
    });
  });
}

function initIdentityMotion() {
  const card = document.querySelector('.developer-card');
  const stage = document.querySelector('[data-identity-stage]');
  const fullName = document.querySelector('[data-identity-full]');
  const finalIdentity = document.querySelector('[data-identity-final]');
  const badge = document.querySelector('[data-identity-badge]');

  if (!card || !stage || !fullName || !finalIdentity || !badge) return;

  if (reducedMotion) {
    stage.style.display = 'none';
    finalIdentity.style.opacity = '1';
    return;
  }

  card.classList.add('identity-animating');
  finalIdentity.style.opacity = '0';

  let chars = [];
  try {
    const split = splitText(fullName, { words: true, chars: true });
    chars = split.chars || [];
    chars.forEach((char) => char.classList.add('anime-char'));
    (split.words || []).forEach((word) => word.classList.add('anime-word'));
  } catch {
    chars = [fullName];
  }

  const timeline = createTimeline({
    defaults: { ease: 'outCubic' }
  });

  timeline
    .add(chars, {
      opacity: { from: 0, to: 1 },
      y: { from: 18, to: 0 },
      filter: { from: 'blur(8px)', to: 'blur(0px)' },
      duration: 560,
      delay: stagger(24)
    }, 80)
    .add(chars, {
      opacity: { to: .18 },
      y: { to: -12 },
      scale: { to: .92 },
      duration: 340,
      delay: stagger(10, { from: 'center' })
    }, '+=520')
    .add(stage, {
      opacity: { to: 0 },
      duration: 220
    }, '-=80')
    .add(finalIdentity, {
      opacity: { from: 0, to: 1 },
      x: { from: 26, to: 0 },
      duration: 620
    }, '-=80')
    .add(badge, {
      scale: [
        { to: .82, duration: 1 },
        { to: 1.04, duration: 280 },
        { to: 1, duration: 320 }
      ],
      rotate: { from: '-6deg', to: '0deg' },
      duration: 620
    }, '<')
    .call(() => {
      stage.style.display = 'none';
      finalIdentity.style.opacity = '1';
      card.classList.remove('identity-animating');
    });
}

export function initAnimeMotion() {
  initSectionMotion();
  initCardAndRowMotion();
  initHeroMotion();
  initButtonMotion();
  initIdentityMotion();
}
