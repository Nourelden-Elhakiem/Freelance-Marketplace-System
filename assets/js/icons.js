const icons = {
  activity: '<path d="M3 12h4l2-4 4 8 2-4h6"/>',
  'alert-circle': '<circle cx="12" cy="12" r="9"/><path d="M12 8v5"/><path d="M12 16h.01"/>',
  'align-left': '<path d="M4 6h16"/><path d="M4 12h12"/><path d="M4 18h16"/>',
  'arrow-left': '<path d="M19 12H5"/><path d="m11 18-6-6 6-6"/>',
  'bar-chart-3': '<path d="M5 19V9"/><path d="M12 19V5"/><path d="M19 19v-8"/>',
  briefcase: '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5.8A1.8 1.8 0 0 1 9.8 4h4.4A1.8 1.8 0 0 1 16 5.8V7"/><path d="M3 12h18"/>',
  calendar: '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4"/><path d="M8 3v4"/><path d="M3 10h18"/>',
  check: '<path d="m5 12.5 4 4L19 7"/>',
  'check-circle': '<circle cx="12" cy="12" r="9"/><path d="m8.5 12.5 2.5 2.5 4.8-5"/>',
  compass: '<circle cx="12" cy="12" r="9"/><path d="m15 9-2.2 5.8L7 17l2.2-5.8z"/>',
  database: '<ellipse cx="12" cy="5" rx="7" ry="3"/><path d="M5 5v7c0 1.7 3.1 3 7 3s7-1.3 7-3V5"/><path d="M5 12v7c0 1.7 3.1 3 7 3s7-1.3 7-3v-7"/>',
  'dollar-sign': '<path d="M12 3v18"/><path d="M16.5 7.5A3.5 3.5 0 0 0 13 5h-2a3 3 0 0 0 0 6h2a3 3 0 0 1 0 6h-2a3.5 3.5 0 0 1-3.5-2.5"/>',
  'file-signature': '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="m9 15 2 2 4-4"/>',
  'file-text': '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M8.5 12h7"/><path d="M8.5 16h7"/><path d="M8.5 19H13"/>',
  flag: '<path d="M5 21V4"/><path d="M5 5h9l-1.8 3L14 11H5"/>',
  'folder-kanban': '<path d="M3 8.2A2.2 2.2 0 0 1 5.2 6h4l1.8 1.8h7A2.9 2.9 0 0 1 21 10.7v6.1A2.2 2.2 0 0 1 18.8 19H5.2A2.2 2.2 0 0 1 3 16.8z"/><path d="M3 11h18"/><path d="M8 14h3"/><path d="M14 14h2"/>',
  'graduation-cap': '<path d="m3 9 9-4 9 4-9 4z"/><path d="M7 11v3c0 1.3 2.2 2.5 5 2.5s5-1.2 5-2.5v-3"/><path d="M20 10v5"/>',
  image: '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m8 14 2.5-2.5 3 3L16 12l4 4"/><circle cx="8" cy="9" r="1.3"/>',
  inbox: '<path d="M4 6h16l-2 12H6z"/><path d="M7.5 13.5h2l1.5 2h2l1.5-2h2"/>',
  info: '<circle cx="12" cy="12" r="9"/><path d="M12 10.5v5"/><path d="M12 7.5h.01"/>',
  'layers-3': '<path d="m12 4 8 4-8 4-8-4z"/><path d="m4 12 8 4 8-4"/><path d="m4 16 8 4 8-4"/>',
  'layout-dashboard': '<rect x="3" y="4" width="8" height="7" rx="1.5"/><rect x="13" y="4" width="8" height="5" rx="1.5"/><rect x="13" y="11" width="8" height="9" rx="1.5"/><rect x="3" y="13" width="8" height="7" rx="1.5"/>',
  link: '<path d="M10 13.5 8 15.5a3 3 0 1 1-4.2-4.2L7 8.1"/><path d="m14 10.5 2-2a3 3 0 1 1 4.2 4.2L17 15.9"/><path d="M9 15l6-6"/>',
  lock: '<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/>',
  mail: '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/>',
  menu: '<path d="M4 7h16"/><path d="M4 12h16"/><path d="M4 17h16"/>',
  pencil: '<path d="m4 20 4.5-1 9-9a2 2 0 0 0-2.8-2.8l-9 9z"/><path d="m13 7 4 4"/>',
  plus: '<path d="M12 5v14"/><path d="M5 12h14"/>',
  'plus-circle': '<circle cx="12" cy="12" r="9"/><path d="M12 8v8"/><path d="M8 12h8"/>',
  search: '<circle cx="11" cy="11" r="6"/><path d="m20 20-4.2-4.2"/>',
  sparkles: '<path d="m12 3 2.1 4.9 5.2.7-3.8 3.5.9 5.2L12 15.8l-4.4 2.5.9-5.2-3.8-3.5 5.2-.7z"/>',
  target: '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r="1.5"/>',
  'trash-2': '<path d="M3 6h18"/><path d="M8 6V4.8A1.8 1.8 0 0 1 9.8 3h4.4A1.8 1.8 0 0 1 16 4.8V6"/><path d="M6.5 6 7.4 20h9.2l.9-14"/><path d="M10 10.5v6"/><path d="M14 10.5v6"/>',
  type: '<path d="M5 6h14"/><path d="M12 6v12"/><path d="M8.5 18h7"/>',
  user: '<circle cx="12" cy="8" r="3.2"/><path d="M5.5 18.5c.8-2.8 3-4.5 6.5-4.5s5.7 1.7 6.5 4.5"/>',
  'user-check': '<circle cx="10" cy="8" r="3.2"/><path d="M4.7 18.5c.8-2.8 2.9-4.5 5.3-4.5 2.5 0 4.6 1.7 5.4 4.5"/><path d="m16.5 11.7 1.7 1.7 3.2-3.1"/>',
  users: '<circle cx="9" cy="8" r="3.2"/><path d="M3.8 18.5c.7-2.7 2.9-4.5 5.2-4.5 2.4 0 4.6 1.8 5.3 4.5"/><path d="M16.2 18.5c.4-1.8 1.5-3.2 3-3.9"/><path d="M15.8 5.1a3 3 0 0 1 0 5.8"/>',
  x: '<path d="M6 6l12 12"/><path d="M18 6 6 18"/>',
  zap: '<path d="M13 2 5 13h5l-1 9 8-11h-5z"/>'
};

function buildIcon(markup, extraClasses) {
  const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
  svg.setAttribute('viewBox', '0 0 24 24');
  svg.setAttribute('fill', 'none');
  svg.setAttribute('stroke', 'currentColor');
  svg.setAttribute('stroke-width', '1.9');
  svg.setAttribute('stroke-linecap', 'round');
  svg.setAttribute('stroke-linejoin', 'round');
  svg.setAttribute('class', ['app-icon', ...extraClasses].join(' '));
  svg.setAttribute('aria-hidden', 'true');
  svg.setAttribute('focusable', 'false');
  svg.innerHTML = markup;
  return svg;
}

export function renderIcons(root = document) {
  root.querySelectorAll('i[class*="lucide-"]').forEach((node) => {
    const classes = Array.from(node.classList);
    const iconClass = classes.find((className) => className.startsWith('lucide-'));
    if (!iconClass) return;

    const iconName = iconClass.replace('lucide-', '');
    const extraClasses = classes.filter((className) => !className.startsWith('lucide-'));
    const svg = buildIcon(icons[iconName] || icons.info, extraClasses);

    if (node.hasAttribute('aria-label')) {
      svg.setAttribute('role', 'img');
      svg.setAttribute('aria-label', node.getAttribute('aria-label') || iconName);
      svg.removeAttribute('aria-hidden');
    }

    node.replaceWith(svg);
  });
}
