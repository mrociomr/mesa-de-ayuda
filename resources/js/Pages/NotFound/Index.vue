<template>
  <div>
    <div ref="canvasContainer"></div>
    <h1 class="title">Error 404: La página no existe</h1>
  </div>
</template>
  
  <script>
import * as THREE from "three";
import blackDogTexture from "./Escudo_de_Puno.png";
export default {
  mounted() {
    // Initialize the Three.js scene
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(
      75,
      window.innerWidth / window.innerHeight,
      0.1,
      1000
    );
    const renderer = new THREE.WebGLRenderer();

    renderer.setSize(window.innerWidth, window.innerHeight);
    this.$refs.canvasContainer.appendChild(renderer.domElement);

    // Create a rotating cube
    const geometry = new THREE.BoxGeometry();

    // Load the texture
    const texture = new THREE.TextureLoader().load(blackDogTexture);

    // Create material with the texture
    const material = new THREE.MeshBasicMaterial({ map: texture });
    const cube = new THREE.Mesh(geometry, material);
    scene.add(cube);

    camera.position.z = 5;

    // Create an animation loop
    const animate = () => {
      requestAnimationFrame(animate);

      cube.rotation.x += 0.01;
      cube.rotation.y += 0.01;

      renderer.render(scene, camera);
    };

    animate();
  },
};
</script>
  
 
  <style scoped>
.title {
  color: white;
  position: absolute;
  top: 180px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 1;
  font-size: 60px;
  font-weight: bold;
  animation: moveAndBlink 6s infinite linear alternate;
}

@keyframes moveAndBlink {
  0% {
    text-shadow: 0 0 10px rgba(255, 255, 255, 1);
    transform: translateX(-50%) translateZ(0);
  }
  50% {
    text-shadow: 0 0 20px rgba(255, 255, 255, 1);
    transform: translateX(-50%) translateZ(50px); /* Acerca el texto */
  }
  100% {
    text-shadow: 0 0 10px rgba(255, 255, 255, 1);
    transform: translateX(-50%) translateZ(0); /* Aleja el texto nuevamente */
  }
}

.text {
  color: white;
  position: absolute;
  top: 250px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 1;
  font-size: 18px;
  animation: moveAndBlink 6s infinite linear alternate;
}
</style>

