let threeModulePromise;

async function loadThree() {
  if (!threeModulePromise) {
    threeModulePromise = import('https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.module.js');
  }
  return threeModulePromise;
}

export function initHeroCanvas() {
  const cards = document.querySelectorAll('[data-three-marketplace]');
  if (!cards.length) return;

  loadThree()
    .then((THREE) => {
      cards.forEach((card) => initThreeMarketplaceCard(card, THREE));
    })
    .catch(() => {
      cards.forEach((card) => card.classList.add('three-marketplace-fallback'));
    });
}

function initThreeMarketplaceCard(card, THREE) {
  const canvas = card.querySelector('.three-marketplace-canvas');
  if (!canvas) return;

  const scene = new THREE.Scene();
  const camera = new THREE.OrthographicCamera(-5.2, 5.2, 2.2, -2.2, 0.1, 100);
  camera.position.set(0, 3.45, 7.15);
  camera.lookAt(0, 0, 0);

  const renderer = new THREE.WebGLRenderer({
    canvas,
    alpha: true,
    antialias: true
  });

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
  renderer.outputColorSpace = THREE.SRGBColorSpace;

  const clock = new THREE.Clock();
  const world = new THREE.Group();
  const mouse = { x: 0, y: 0 };
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  let animationFrame = null;

  scene.add(world);
  addLights(scene, THREE);
  addParticleField(world, THREE);
  addOrbits(world, THREE);

  const database = createDatabaseCore(THREE);
  database.position.set(0, -0.12, 0);
  world.add(database);

  const nodes = [];
  const nodeData = [
    { type: 'client', color: '#5fcfff', position: [-3.25, 0.44, 0.05] },
    { type: 'folder', color: '#66e7ff', position: [-1.8, 0.98, -0.15] },
    { type: 'document', color: '#6397ff', position: [1.8, 0.98, -0.15] },
    { type: 'briefcase', color: '#8b72ff', position: [-2.85, -0.82, 0.2] },
    { type: 'skill', color: '#a58cff', position: [1.75, -1.12, 0.1] },
    { type: 'freelancer', color: '#76ffd8', position: [2.95, -0.76, 0.22] }
  ];

  nodeData.forEach((item, index) => {
    const node = createMarketplaceNode(item, THREE);
    node.position.set(...item.position);
    node.userData.base = node.position.clone();
    node.userData.phase = index * 0.75;
    nodes.push(node);
    world.add(node);
  });

  const pulses = [];
  nodes.forEach((node, index) => {
    const curve = createConnectionCurve(node.position, new THREE.Vector3(0, 0.05, 0), THREE);
    const line = createCurveLine(curve, index, THREE);
    world.add(line);

    const pulse = createPulseSphere(index, THREE);
    pulse.userData.curve = curve;
    pulse.userData.offset = Math.random();
    pulse.userData.speed = 0.052 + Math.random() * 0.03;
    pulses.push(pulse);
    world.add(pulse);
  });

  const floatingDots = addFloatingDataDots(world, THREE);

  card.addEventListener('pointermove', (event) => {
    const rect = card.getBoundingClientRect();
    mouse.x = ((event.clientX - rect.left) / rect.width - 0.5) * 2;
    mouse.y = ((event.clientY - rect.top) / rect.height - 0.5) * 2;
  }, { passive: true });

  card.addEventListener('pointerleave', () => {
    mouse.x = 0;
    mouse.y = 0;
  });

  function resize() {
    const rect = card.getBoundingClientRect();
    const width = Math.max(1, rect.width);
    const height = Math.max(1, rect.height);
    const aspect = width / height;
    const viewHeight = 4.4;
    const viewWidth = viewHeight * aspect;

    camera.left = -viewWidth / 2;
    camera.right = viewWidth / 2;
    camera.top = viewHeight / 2;
    camera.bottom = -viewHeight / 2;
    camera.updateProjectionMatrix();
    renderer.setSize(width, height, false);
  }

  const observer = new ResizeObserver(resize);
  observer.observe(card);
  resize();

  function animate() {
    const elapsed = clock.getElapsedTime();

    if (!reducedMotion) {
      world.rotation.y += (mouse.x * 0.045 - world.rotation.y) * 0.035;
      world.rotation.x += (-mouse.y * 0.025 - world.rotation.x) * 0.035;

      database.position.y = -0.12 + Math.sin(elapsed * 1.35) * 0.055;
      database.rotation.y = Math.sin(elapsed * 0.45) * 0.04;

      nodes.forEach((node) => {
        const base = node.userData.base;
        const phase = node.userData.phase;
        node.position.y = base.y + Math.sin(elapsed * 1.25 + phase) * 0.055;
        node.rotation.y = Math.sin(elapsed * 0.75 + phase) * 0.08;
      });

      pulses.forEach((pulse, index) => {
        const t = (elapsed * pulse.userData.speed + pulse.userData.offset) % 1;
        const point = pulse.userData.curve.getPointAt(t);
        pulse.position.copy(point);
        pulse.scale.setScalar(0.85 + Math.sin(elapsed * 4 + index) * 0.15);
      });

      animateParticleField(world, elapsed);
      animateFloatingDots(floatingDots, elapsed);
    }

    renderer.render(scene, camera);
    animationFrame = requestAnimationFrame(animate);
  }

  document.addEventListener('visibilitychange', () => {
    if (document.hidden && animationFrame) {
      cancelAnimationFrame(animationFrame);
      animationFrame = null;
      return;
    }
    if (!document.hidden && !animationFrame) animate();
  });

  animate();
}

function addLights(scene, THREE) {
  scene.add(new THREE.AmbientLight(0x9fcfff, 1.45));

  const key = new THREE.DirectionalLight(0xffffff, 1.65);
  key.position.set(2.8, 5, 4);
  scene.add(key);

  const cyan = new THREE.PointLight(0x55e6ff, 2.8, 7);
  cyan.position.set(-1.9, 1.3, 2.2);
  scene.add(cyan);

  const blue = new THREE.PointLight(0x4d8dff, 2.4, 7);
  blue.position.set(2.1, 1.1, 2.2);
  scene.add(blue);

  const mint = new THREE.PointLight(0x63f2ca, 1.2, 6);
  mint.position.set(0, -1.2, 2.4);
  scene.add(mint);
}

function createDatabaseCore(THREE) {
  const group = new THREE.Group();
  const bodyMaterial = new THREE.MeshPhysicalMaterial({
    color: 0x4d8dff,
    roughness: 0.23,
    metalness: 0.28,
    transparent: true,
    opacity: 0.94,
    emissive: 0x113d8a,
    emissiveIntensity: 0.33
  });
  const topMaterial = new THREE.MeshPhysicalMaterial({
    color: 0x8defff,
    roughness: 0.18,
    metalness: 0.22,
    transparent: true,
    opacity: 0.88,
    emissive: 0x55e6ff,
    emissiveIntensity: 0.42
  });
  const darkMaterial = new THREE.MeshPhysicalMaterial({
    color: 0x09224c,
    roughness: 0.38,
    metalness: 0.18,
    transparent: true,
    opacity: 0.9
  });

  const body = new THREE.Mesh(new THREE.CylinderGeometry(0.72, 0.72, 0.9, 80, 1, true), bodyMaterial);
  body.position.y = 0.15;
  group.add(body);

  const top = new THREE.Mesh(new THREE.CylinderGeometry(0.72, 0.72, 0.08, 80), topMaterial);
  top.position.y = 0.62;
  group.add(top);

  const innerTop = new THREE.Mesh(
    new THREE.CylinderGeometry(0.43, 0.43, 0.085, 80),
    new THREE.MeshPhysicalMaterial({
      color: 0x7df4ff,
      roughness: 0.1,
      metalness: 0.15,
      transparent: true,
      opacity: 0.62,
      emissive: 0x6feaff,
      emissiveIntensity: 0.9
    })
  );
  innerTop.position.y = 0.67;
  group.add(innerTop);

  const bottom = new THREE.Mesh(new THREE.CylinderGeometry(0.72, 0.72, 0.08, 80), darkMaterial);
  bottom.position.y = -0.31;
  group.add(bottom);

  const ringMaterial = new THREE.MeshBasicMaterial({
    color: 0xdffaff,
    transparent: true,
    opacity: 0.58
  });

  [-0.26, 0.04, 0.34, 0.62].forEach((y) => {
    const ring = new THREE.Mesh(new THREE.TorusGeometry(0.72, 0.012, 12, 96), ringMaterial);
    ring.rotation.x = Math.PI / 2;
    ring.position.y = y;
    group.add(ring);
  });

  const platform = new THREE.Mesh(
    new THREE.CylinderGeometry(1.35, 1.55, 0.14, 96),
    new THREE.MeshPhysicalMaterial({
      color: 0x102b5c,
      roughness: 0.38,
      metalness: 0.24,
      transparent: true,
      opacity: 0.95
    })
  );
  platform.position.y = -0.55;
  group.add(platform);

  const platformRing = new THREE.Mesh(
    new THREE.TorusGeometry(1.36, 0.025, 14, 120),
    new THREE.MeshBasicMaterial({
      color: 0x63f2ca,
      transparent: true,
      opacity: 0.72
    })
  );
  platformRing.rotation.x = Math.PI / 2;
  platformRing.position.y = -0.46;
  group.add(platformRing);

  const glowSprite = createGlowSprite('#72d8ff', 1.9, THREE);
  glowSprite.position.y = 0.34;
  glowSprite.scale.set(2.25, 2.25, 1);
  group.add(glowSprite);

  const indicatorColors = [0x80ffe0, 0x75d8ff, 0xd7ff78, 0xa58cff, 0x73f0ff, 0xffd96d];
  indicatorColors.forEach((color, index) => {
    const dot = new THREE.Mesh(
      new THREE.SphereGeometry(0.035, 18, 18),
      new THREE.MeshBasicMaterial({ color, transparent: true, opacity: 0.95 })
    );
    dot.position.set(0.56, 0.35 - index * 0.12, 0.12 + (index % 2) * 0.12);
    group.add(dot);
  });

  return group;
}

function createMarketplaceNode(item, THREE) {
  const group = new THREE.Group();
  const color = new THREE.Color(item.color);
  const glass = new THREE.Mesh(
    new THREE.SphereGeometry(0.42, 40, 24),
    new THREE.MeshPhysicalMaterial({
      color,
      roughness: 0.08,
      metalness: 0.05,
      transparent: true,
      opacity: 0.16,
      emissive: color,
      emissiveIntensity: 0.08,
      depthWrite: false
    })
  );
  group.add(glass);

  const pedestal = new THREE.Mesh(
    new THREE.CylinderGeometry(0.42, 0.52, 0.08, 48),
    new THREE.MeshPhysicalMaterial({
      color: 0x102b5c,
      roughness: 0.32,
      metalness: 0.18,
      transparent: true,
      opacity: 0.96
    })
  );
  pedestal.position.y = -0.43;
  group.add(pedestal);

  const neonRing = new THREE.Mesh(
    new THREE.TorusGeometry(0.43, 0.017, 12, 72),
    new THREE.MeshBasicMaterial({ color, transparent: true, opacity: 0.88 })
  );
  neonRing.rotation.x = Math.PI / 2;
  neonRing.position.y = -0.37;
  group.add(neonRing);

  const iconTexture = createIconTexture(item.type, item.color, THREE);
  const iconSprite = new THREE.Sprite(
    new THREE.SpriteMaterial({ map: iconTexture, transparent: true, depthWrite: false })
  );
  iconSprite.scale.set(0.58, 0.58, 1);
  iconSprite.position.set(0, 0.02, 0.08);
  group.add(iconSprite);

  const baseGlow = createGlowSprite(item.color, 1.1, THREE);
  baseGlow.position.y = -0.34;
  baseGlow.scale.set(0.9, 0.9, 1);
  group.add(baseGlow);

  return group;
}

function createConnectionCurve(start, end, THREE) {
  const middle = new THREE.Vector3(start.x * 0.55, Math.max(start.y, end.y) + 0.18, start.z + 0.14);
  return new THREE.CatmullRomCurve3([
    start.clone().add(new THREE.Vector3(0, -0.08, 0)),
    middle,
    end.clone().add(new THREE.Vector3(0, 0.1, 0))
  ]);
}

function createCurveLine(curve, index, THREE) {
  const points = curve.getPoints(72);
  const geometry = new THREE.BufferGeometry().setFromPoints(points);
  const colors = [0x55e6ff, 0x9d86ff, 0x76ffd8, 0x6397ff, 0xffd86d];
  return new THREE.Line(
    geometry,
    new THREE.LineBasicMaterial({
      color: colors[index % colors.length],
      transparent: true,
      opacity: 0.22
    })
  );
}

function createPulseSphere(index, THREE) {
  const colors = [0x55e6ff, 0x9d86ff, 0x76ffd8, 0x6397ff, 0xffd86d];
  return new THREE.Mesh(
    new THREE.SphereGeometry(0.035, 18, 18),
    new THREE.MeshBasicMaterial({ color: colors[index % colors.length], transparent: true, opacity: 0.95 })
  );
}

function addOrbits(world, THREE) {
  const orbitGroup = new THREE.Group();
  const orbitData = [
    { rx: 4.2, rz: 1.08, y: -0.05, color: 0x55e6ff, opacity: 0.18 },
    { rx: 3.15, rz: 0.78, y: 0.02, color: 0x9d86ff, opacity: 0.15 },
    { rx: 2.35, rz: 1.18, y: 0.03, color: 0x76ffd8, opacity: 0.13 }
  ];

  orbitData.forEach((item) => {
    const points = [];
    for (let i = 0; i <= 180; i += 1) {
      const t = (i / 180) * Math.PI * 2;
      points.push(new THREE.Vector3(Math.cos(t) * item.rx, item.y, Math.sin(t) * item.rz));
    }

    const line = new THREE.Line(
      new THREE.BufferGeometry().setFromPoints(points),
      new THREE.LineBasicMaterial({
        color: item.color,
        transparent: true,
        opacity: item.opacity
      })
    );
    line.userData.rotateSpeed = 0.0008 + Math.random() * 0.0008;
    orbitGroup.add(line);
  });

  orbitGroup.userData.isOrbitGroup = true;
  world.add(orbitGroup);
}

function addParticleField(world, THREE) {
  const count = 150;
  const positions = new Float32Array(count * 3);
  const speeds = new Float32Array(count);

  for (let i = 0; i < count; i += 1) {
    positions[i * 3] = THREE.MathUtils.randFloatSpread(8.4);
    positions[i * 3 + 1] = THREE.MathUtils.randFloat(-1.6, 1.65);
    positions[i * 3 + 2] = THREE.MathUtils.randFloat(-1.0, 1.0);
    speeds[i] = THREE.MathUtils.randFloat(0.15, 0.42);
  }

  const geometry = new THREE.BufferGeometry();
  geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
  geometry.userData.speeds = speeds;

  const particles = new THREE.Points(
    geometry,
    new THREE.PointsMaterial({
      color: 0x72d8ff,
      size: 0.026,
      transparent: true,
      opacity: 0.56,
      depthWrite: false,
      blending: THREE.AdditiveBlending
    })
  );
  particles.userData.isParticleField = true;
  world.add(particles);
}

function animateParticleField(world, elapsed) {
  world.children.forEach((child) => {
    if (child.userData.isParticleField) {
      const positions = child.geometry.attributes.position.array;
      const speeds = child.geometry.userData.speeds;

      for (let i = 0; i < speeds.length; i += 1) {
        positions[i * 3 + 1] += Math.sin(elapsed * speeds[i] + i) * 0.0008;
        positions[i * 3] += Math.cos(elapsed * speeds[i] + i * 0.21) * 0.0008;
      }

      child.geometry.attributes.position.needsUpdate = true;
      child.rotation.y = elapsed * 0.012;
    }

    if (child.userData.isOrbitGroup) {
      child.children.forEach((orbit, index) => {
        orbit.rotation.y += orbit.userData.rotateSpeed * (index % 2 === 0 ? 1 : -1);
      });
    }
  });
}

function addFloatingDataDots(world, THREE) {
  const dots = [];
  const colors = [0x55e6ff, 0x76ffd8, 0x9d86ff, 0xffd86d];

  for (let i = 0; i < 20; i += 1) {
    const dot = new THREE.Mesh(
      new THREE.SphereGeometry(0.025 + Math.random() * 0.02, 12, 12),
      new THREE.MeshBasicMaterial({
        color: colors[i % colors.length],
        transparent: true,
        opacity: 0.72
      })
    );

    dot.position.set(
      THREE.MathUtils.randFloatSpread(7.6),
      THREE.MathUtils.randFloat(-1.35, 1.35),
      THREE.MathUtils.randFloat(-0.6, 0.75)
    );

    dot.userData.base = dot.position.clone();
    dot.userData.phase = Math.random() * Math.PI * 2;
    dot.userData.speed = THREE.MathUtils.randFloat(0.65, 1.25);
    dots.push(dot);
    world.add(dot);
  }

  return dots;
}

function animateFloatingDots(dots, elapsed) {
  dots.forEach((dot, index) => {
    const base = dot.userData.base;
    dot.position.x = base.x + Math.sin(elapsed * dot.userData.speed + dot.userData.phase) * 0.04;
    dot.position.y = base.y + Math.cos(elapsed * dot.userData.speed + dot.userData.phase) * 0.035;
    dot.material.opacity = 0.42 + Math.sin(elapsed * 1.6 + index) * 0.18;
  });
}

function createGlowSprite(color, opacity, THREE) {
  const canvas = document.createElement('canvas');
  canvas.width = 256;
  canvas.height = 256;

  const ctx = canvas.getContext('2d');
  const gradient = ctx.createRadialGradient(128, 128, 0, 128, 128, 128);
  gradient.addColorStop(0, hexToRgba(color, 0.52 * opacity));
  gradient.addColorStop(0.38, hexToRgba(color, 0.18 * opacity));
  gradient.addColorStop(1, hexToRgba(color, 0));
  ctx.fillStyle = gradient;
  ctx.fillRect(0, 0, 256, 256);

  const texture = new THREE.CanvasTexture(canvas);
  texture.colorSpace = THREE.SRGBColorSpace;

  return new THREE.Sprite(
    new THREE.SpriteMaterial({
      map: texture,
      transparent: true,
      depthWrite: false,
      blending: THREE.AdditiveBlending
    })
  );
}

function createIconTexture(type, color, THREE) {
  const canvas = document.createElement('canvas');
  canvas.width = 256;
  canvas.height = 256;

  const ctx = canvas.getContext('2d');
  ctx.clearRect(0, 0, 256, 256);

  const bg = ctx.createRadialGradient(128, 128, 8, 128, 128, 120);
  bg.addColorStop(0, hexToRgba(color, 0.34));
  bg.addColorStop(1, 'rgba(5, 20, 45, 0)');

  ctx.fillStyle = bg;
  ctx.fillRect(0, 0, 256, 256);

  ctx.save();
  ctx.translate(128, 128);

  switch (type) {
    case 'client':
      drawClientIcon(ctx);
      break;
    case 'freelancer':
      drawClientIcon(ctx, '#a98cff');
      break;
    case 'folder':
      drawFolderIcon(ctx);
      break;
    case 'document':
      drawDocumentIcon(ctx);
      break;
    case 'briefcase':
      drawBriefcaseIcon(ctx);
      break;
    case 'skill':
      drawSkillIcon(ctx);
      break;
    default:
      drawFolderIcon(ctx);
  }

  ctx.restore();

  const texture = new THREE.CanvasTexture(canvas);
  texture.colorSpace = THREE.SRGBColorSpace;
  texture.needsUpdate = true;
  return texture;
}

function drawClientIcon(ctx, shirt = '#4b86ff') {
  ctx.fillStyle = '#f0c5bc';
  ctx.beginPath();
  ctx.arc(0, -34, 27, 0, Math.PI * 2);
  ctx.fill();

  ctx.fillStyle = '#243858';
  ctx.beginPath();
  ctx.moveTo(-29, -45);
  ctx.bezierCurveTo(-20, -80, 34, -74, 29, -34);
  ctx.bezierCurveTo(12, -48, -8, -40, -29, -45);
  ctx.fill();

  ctx.fillStyle = shirt;
  ctx.beginPath();
  ctx.moveTo(-58, 70);
  ctx.bezierCurveTo(-42, 2, 42, 2, 58, 70);
  ctx.closePath();
  ctx.fill();
}

function drawFolderIcon(ctx) {
  const gradient = ctx.createLinearGradient(-70, -50, 70, 72);
  gradient.addColorStop(0, '#78ddff');
  gradient.addColorStop(0.45, '#4d91ff');
  gradient.addColorStop(1, '#2865dc');

  ctx.fillStyle = gradient;
  roundRect(ctx, -76, -34, 152, 100, 12);
  ctx.fill();

  ctx.fillStyle = '#80e9ff';
  roundRect(ctx, -76, -54, 62, 32, 10);
  ctx.fill();

  ctx.fillStyle = 'rgba(255,255,255,0.22)';
  roundRect(ctx, -64, -16, 128, 18, 9);
  ctx.fill();
}

function drawDocumentIcon(ctx) {
  ctx.fillStyle = '#f2f8ff';
  roundRect(ctx, -48, -74, 96, 142, 12);
  ctx.fill();

  ctx.fillStyle = '#c9dfff';
  ctx.beginPath();
  ctx.moveTo(24, -74);
  ctx.lineTo(48, -50);
  ctx.lineTo(24, -50);
  ctx.closePath();
  ctx.fill();

  ctx.strokeStyle = '#607ea8';
  ctx.lineWidth = 9;
  ctx.lineCap = 'round';

  [-30, -5, 20].forEach((y) => {
    ctx.beginPath();
    ctx.moveTo(-22, y);
    ctx.lineTo(25, y);
    ctx.stroke();
  });

  ctx.fillStyle = '#66e7c9';
  ctx.beginPath();
  ctx.arc(44, 48, 25, 0, Math.PI * 2);
  ctx.fill();

  ctx.strokeStyle = '#07314b';
  ctx.lineWidth = 9;
  ctx.beginPath();
  ctx.moveTo(32, 48);
  ctx.lineTo(42, 58);
  ctx.lineTo(58, 36);
  ctx.stroke();
}

function drawBriefcaseIcon(ctx) {
  const gradient = ctx.createLinearGradient(-78, -60, 78, 76);
  gradient.addColorStop(0, '#8c78ff');
  gradient.addColorStop(1, '#4d5ddd');

  ctx.fillStyle = gradient;
  roundRect(ctx, -78, -34, 156, 94, 14);
  ctx.fill();

  ctx.strokeStyle = '#bdd6ff';
  ctx.lineWidth = 14;
  ctx.lineCap = 'round';
  ctx.beginPath();
  ctx.moveTo(-32, -34);
  ctx.lineTo(-32, -58);
  ctx.lineTo(32, -58);
  ctx.lineTo(32, -34);
  ctx.stroke();

  ctx.fillStyle = '#dbe9ff';
  roundRect(ctx, -13, -8, 26, 26, 6);
  ctx.fill();
}

function drawSkillIcon(ctx) {
  const gradient = ctx.createLinearGradient(-70, -70, 70, 80);
  gradient.addColorStop(0, '#9d86ff');
  gradient.addColorStop(1, '#5146cc');

  ctx.fillStyle = gradient;
  ctx.beginPath();

  for (let i = 0; i < 6; i += 1) {
    const angle = Math.PI / 6 + i * Math.PI / 3;
    const x = Math.cos(angle) * 72;
    const y = Math.sin(angle) * 72;
    if (i === 0) ctx.moveTo(x, y);
    else ctx.lineTo(x, y);
  }

  ctx.closePath();
  ctx.fill();
  ctx.fillStyle = '#d4ccff';
  drawStar(ctx, 0, 2, 46, 20, 5);
  ctx.fill();
}

function roundRect(ctx, x, y, width, height, radius) {
  ctx.beginPath();
  ctx.moveTo(x + radius, y);
  ctx.lineTo(x + width - radius, y);
  ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
  ctx.lineTo(x + width, y + height - radius);
  ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
  ctx.lineTo(x + radius, y + height);
  ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
  ctx.lineTo(x, y + radius);
  ctx.quadraticCurveTo(x, y, x + radius, y);
  ctx.closePath();
}

function drawStar(ctx, cx, cy, outer, inner, points) {
  ctx.beginPath();
  for (let i = 0; i < points * 2; i += 1) {
    const radius = i % 2 === 0 ? outer : inner;
    const angle = -Math.PI / 2 + i * Math.PI / points;
    const x = cx + Math.cos(angle) * radius;
    const y = cy + Math.sin(angle) * radius;
    if (i === 0) ctx.moveTo(x, y);
    else ctx.lineTo(x, y);
  }
  ctx.closePath();
}

function hexToRgba(hex, alpha) {
  const value = hex.replace('#', '');
  const r = parseInt(value.substring(0, 2), 16);
  const g = parseInt(value.substring(2, 4), 16);
  const b = parseInt(value.substring(4, 6), 16);
  return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}
