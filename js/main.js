console.log("loaded");

import * as THREE from "three";
import { GLTFLoader } from "three/addons/loaders/GLTFLoader.js";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls.js";

// Create a scene
const scene = new THREE.Scene();

// Create a camera
const camera = new THREE.PerspectiveCamera(
  75,
  window.innerWidth / window.innerHeight,
  0.1,
  1000
);
camera.position.z = 0.05203076048180343; // Adjust the distance to the model
camera.position.x = 0.10013451551816771; // Adjust the distance to the model
camera.position.y = 0.0825932529215281; // Adjust the distance to the model
// x=0.10013451551816771, y=0.0825932529215281, z=0.05203076048180343

// Create a WebGL renderer with a transparent background
const renderer = new THREE.WebGLRenderer({ alpha: true });
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);

// Set the clear color of the renderer to transparent
renderer.setClearColor(0x000000, 0);

const loader = new GLTFLoader();
let model;

// Define initial position
let modelPosition = new THREE.Vector3();

loader.load("assets/3d/scene.gltf", (gltf) => {
  model = gltf.scene;

  // Center the model
  const box = new THREE.Box3().setFromObject(model);
  const center = box.getCenter(new THREE.Vector3());
  model.position.sub(center);

  // Set the initial position
  modelPosition.copy(model.position);

  scene.add(model);
});

const light = new THREE.DirectionalLight(0xffffff, 1);
light.position.set(10, 10, 10);
scene.add(light);

// Create OrbitControls and configure it
const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.enableRotate = false;
controls.dampingFactor = 0.1;

// Add event listeners for manual movement using arrow keys
window.addEventListener("keydown", (event) => {
  const moveDistance = 0.1;

  switch (event.key) {
    case "ArrowUp":
      model.position.y += moveDistance;
      break;
    case "ArrowDown":
      model.position.y -= moveDistance;
      break;
    case "ArrowLeft":
      model.position.x -= moveDistance;
      break;
    case "ArrowRight":
      model.position.x += moveDistance;
      break;
  }
});

const animate = () => {
  requestAnimationFrame(animate);

  if (model) {
    model.rotation.z = Math.PI / 4;
  }
  console.log(
    `Camera Position: x=${camera.position.x}, y=${camera.position.y}, z=${camera.position.z}`
  );
  controls.update();
  renderer.render(scene, camera);
};

animate();

window.addEventListener("resize", () => {
  const newWidth = window.innerWidth;
  const newHeight = window.innerHeight;

  camera.aspect = newWidth / newHeight;
  camera.updateProjectionMatrix();

  renderer.setSize(newWidth, newHeight);
});
