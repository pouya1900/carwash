var scene, camera, renderer, clock;
import * as THREE from 'three';
import {OrbitControls} from 'https://cdn.jsdelivr.net/npm/three@0.140.0/examples/jsm/controls/OrbitControls.js';


init();

function init() {
    const assetPath = 'storage/assets/3d/';


    clock = new THREE.Clock();

    let element = $('#td_background_office');

    scene = new THREE.Scene();
    scene.background = new THREE.CubeTextureLoader()
        .setPath(`${assetPath}` + `1/`)
        .load(['px.png', 'nx.png', 'py.png', 'ny.png', 'pz.png', 'nz.png']);

    camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.set(10, 0, 0);
    const light = new THREE.DirectionalLight(0xcccccc, 2);
    light.position.set(1, 10, 6);
    scene.add(light);
    renderer = new THREE.WebGLRenderer();
    renderer.setSize(window.innerWidth, window.innerHeight);

    const controls = new OrbitControls( camera, renderer.domElement );
    controls.update();

    update();

    element.html(renderer.domElement);

    window.addEventListener( 'resize', resize, false);

}


function update() {

    requestAnimationFrame( update );
    renderer.render( scene, camera );
}


function resize(){
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize( window.innerWidth, window.innerHeight );
}
