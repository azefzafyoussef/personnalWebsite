import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';

const scene = new THREE.Scene();
const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);

const loader = new GLTFLoader();
loader.load('/models/motion_cubes.glb', (gltf) => {
  // Add the loaded scene
  scene.add(gltf.scene);

  // ---------- Get the exported camera ----------
  let camera;
  if (gltf.cameras && gltf.cameras.length > 0) {
    camera = gltf.cameras[0]; // Use the first camera
    // Set position & rotation from Blender scene
    camera.position.copy(camera.position);
    camera.rotation.copy(camera.rotation);
  } else {
    // Fallback camera
    camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 5;
  }

  // ---------- Optional: subtle mouse movement ----------
  const mouse = { x: 0, y: 0 };
  document.addEventListener('mousemove', (event) => {
    const mouseX = (event.clientX / window.innerWidth - 0.5) * 2; // scale
    const mouseY = (0.5 - event.clientY / window.innerHeight) * 2;
    camera.position.x += (mouseX - camera.position.x) * 0.05;
    camera.position.y += (mouseY - camera.position.y) * 0.05;
    camera.lookAt(scene.position);
  });

  // ---------- Animate ----------
  function animate() {
    requestAnimationFrame(animate);
    renderer.render(scene, camera);
  }
  animate();
});
