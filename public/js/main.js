import { initScene, addLights, addGround, addBuilding, addCar, animate } from './scene3D.js';

// Initialisation
initScene();
addLights();
addGround();

// Ajout des bâtiments
const building1 = addBuilding(-3, 1, -3, 2, 4, 2);
const building2 = addBuilding(3, 1, -2, 2, 3, 2);
const building3 = addBuilding(-2, 1, 3, 1.5, 3, 1.5);

// Ajout de la voiture
const car = addCar(0, 0.25, 0);

// Animation
animate([car]); // seuls les objets animés (ici la voiture) tournent légèrement
