import { animate } from '../vendor/anime.esm.min.js';

export function initDiagramLightbox() {
  const lightbox = document.getElementById('diagramLightbox');
  if (!lightbox) return;

  if (lightbox.parentElement !== document.body) {
    document.body.appendChild(lightbox);
  }

  const image = document.getElementById('diagramLightboxImage');
  const title = document.getElementById('diagramLightboxTitle');
  const caption = document.getElementById('diagramLightboxCaption');
  const dialog = lightbox.querySelector('.image-lightbox__dialog');
  const backdrop = lightbox.querySelector('.image-lightbox__backdrop');
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  let lastTrigger = null;
  let closing = false;

  function open(trigger) {
    closing = false;
    lastTrigger = trigger;
    image.src = trigger.dataset.diagramSrc || '';
    image.alt = trigger.querySelector('img')?.alt || 'Project diagram';
    title.textContent = trigger.dataset.diagramTitle || 'Project Diagram';
    caption.textContent = trigger.dataset.diagramCaption || '';
    lightbox.hidden = false;
    document.body.classList.add('lightbox-open');

    if (!reduceMotion) {
      animate(backdrop, {
        opacity: { from: 0, to: 1 },
        duration: 260,
        ease: 'outQuad'
      });

      animate(dialog, {
        opacity: { from: 0, to: 1 },
        y: { from: 18, to: 0 },
        scale: { from: .965, to: 1 },
        duration: 360,
        ease: 'outCubic'
      });

      animate(image, {
        opacity: { from: 0, to: 1 },
        scale: { from: .985, to: 1 },
        duration: 420,
        delay: 80,
        ease: 'outCubic'
      });
    }

    lightbox.querySelector('[data-lightbox-close]')?.focus();
  }

  function close() {
    if (lightbox.hidden || closing) return;
    closing = true;

    const finish = () => {
      lightbox.hidden = true;
      document.body.classList.remove('lightbox-open');
      image.src = '';
      image.alt = '';
      closing = false;
      lastTrigger?.focus();
    };

    if (reduceMotion) {
      finish();
      return;
    }

    animate(dialog, {
      opacity: { to: 0 },
      y: { to: 12 },
      scale: { to: .985 },
      duration: 220,
      ease: 'inCubic'
    });

    animate(backdrop, {
      opacity: { to: 0 },
      duration: 220,
      ease: 'inQuad'
    });

    window.setTimeout(finish, 230);
  }

  document.addEventListener('click', (event) => {
    const card = event.target.closest('.diagram-card[data-diagram-src]');
    if (!card || lightbox.contains(card)) return;
    open(card);
  });

  document.addEventListener('keydown', (event) => {
    const card = event.target.closest?.('.diagram-card[data-diagram-src]');
    if (card && (event.key === 'Enter' || event.key === ' ')) {
      event.preventDefault();
      open(card);
      return;
    }

    if (event.key === 'Escape') close();
  });

  lightbox.addEventListener('click', (event) => {
    const closeTarget = event.target.closest('[data-lightbox-close]');
    const clickedOutsideDialog = !event.target.closest('.image-lightbox__dialog');

    if (closeTarget || clickedOutsideDialog) {
      close();
    }
  });

}
