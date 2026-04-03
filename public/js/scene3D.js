import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';

let scene, camera, renderer, controls, container;

// --- Initialisation de la scène ---
export function initScene() {
    container = document.getElementById('scene-container');
    if (!container) {
        console.error("Container 'scene-container' introuvable !");
        return;
    }

    scene = new THREE.Scene();


    camera = new THREE.PerspectiveCamera(60, container.clientWidth / container.clientHeight, 0.1, 100);
    camera.position.set(0, 5, 10);

  renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.setClearColor(0x000000, 0); // fond transparent
  document.getElementById("scene-container").appendChild(renderer.domElement);


    controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;

    window.addEventListener('resize', () => {
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);
    });
}

// --- Lumières ---
export function addLights() {
    const ambient = new THREE.AmbientLight(0xffffff, 0.5);
    scene.add(ambient);

    const dirLight = new THREE.DirectionalLight(0xffffff, 1);
    dirLight.position.set(10, 10, 10);
    scene.add(dirLight);
}

// --- Sol ---
export function addGround() {
    const geometry = new THREE.PlaneGeometry(50, 50);
    const material = new THREE.MeshStandardMaterial({ color: 0x808080 });
    const ground = new THREE.Mesh(geometry, material);
    ground.rotation.x = -Math.PI / 2;
    ground.position.y = 0;
    scene.add(ground);
}

// --- Bâtiments ---
export function addBuilding(x, y = 1, z, width = 1, height = 2, depth = 1) {
    const geometry = new THREE.BoxGeometry(width, height, depth);
    const material = new THREE.MeshStandardMaterial({ color: 0x4040ff });
    const building = new THREE.Mesh(geometry, material);
    building.position.set(x, y, z);
    scene.add(building);
    return building;
}

// --- Voiture (simple cube pour test) ---
export function addCar(x = 0, y = 0.25, z = 0) {
    const geometry = new THREE.BoxGeometry(1, 0.5, 2);
    const material = new THREE.MeshStandardMaterial({ color: 0xff0000 });
    const car = new THREE.Mesh(geometry, material);
    car.position.set(x, y, z);
    scene.add(car);
    return car;
}

// --- Animation ---
export function animate(objects = []) {
    requestAnimationFrame(() => animate(objects));

    objects.forEach(obj => {
        obj.rotation.y += 0.01;
    });

    controls.update();
    renderer.render(scene, camera);
}
