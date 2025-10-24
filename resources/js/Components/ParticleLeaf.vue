<template>
  <canvas v-show="visible" ref="canvas" :width="canvasWidth" :height="canvasHeight" :style="{
    position: 'fixed',
    top: 0,
    left: 0,
    pointerEvents: 'none',
    zIndex: 10,
    width: '100vw',
    height: '100vh'
  }" />
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  canvasWidth: { type: Number, default: 1920 },
  canvasHeight: { type: Number, default: 1080 }
});

const visible = ref(false);
const canvas = ref(null);
let particles = [];
let leafImage = null;
let animationFrame = null;

function rand(min, max) {
  return Math.random() * (max - min) + min;
}

/**
 * @param plantRect {DOMRect} - bounding rect of the plant
 * @param leafUrl {string} - image src for the leaf
 * @param count {number} - number of leaves
 */
function burstPlant(plantRect, leafUrl, count = 20) {
  visible.value = true;
  particles = [];

  leafImage = new window.Image();
  leafImage.src = leafUrl;

  leafImage.onload = () => {
    for (let i = 0; i < count; i++) {
      const px = rand(plantRect.left, plantRect.right);
      const py = rand(plantRect.top, plantRect.bottom);

      const angle = rand(-Math.PI / 6, Math.PI + Math.PI / 6);
      const speed = rand(1, 2);

      particles.push({
        x: px,
        y: py,
        vx: Math.cos(angle) * speed + rand(-1.5, 1.5),
        vy: Math.sin(angle) * speed + rand(-0.5, 0.5),
        gravity: 0.1,
        drag: 1,
        life: 0,
        maxLife: rand(1, 90),
        size: rand(32, 56),
        angle: rand(0, Math.PI * 2),
        spin: rand(-0.04, 0.04)
      });
    }
    animate();
  };
}

function animate() {
  const ctx = canvas.value.getContext('2d');
  ctx.clearRect(0, 0, props.canvasWidth, props.canvasHeight);

  let alive = false;
  for (const p of particles) {
    // Update position
    p.x += p.vx;
    p.y += p.vy;
    p.vy += p.gravity;
    p.vx *= p.drag;
    p.angle += p.spin;
    p.life++;

    if (p.y > props.canvasHeight + p.size) {
      p.life = p.maxLife;
    }

    if (p.life < p.maxLife) {
      ctx.save();
      ctx.globalAlpha = 1 - Math.pow(p.life / p.maxLife, 2);
      ctx.translate(p.x, p.y);
      ctx.rotate(p.angle);
      ctx.drawImage(leafImage, -p.size / 2, -p.size / 2, p.size, p.size);
      ctx.restore();
      alive = true;
    }
  }
  if (alive) {
    animationFrame = requestAnimationFrame(animate);
  } else {
    visible.value = false;
    particles = [];
    cancelAnimationFrame(animationFrame);
  }
}

defineExpose({ burstPlant });
</script>