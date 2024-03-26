var scene = [], camera = [], renderer = [], clock, target = 0;
import * as THREE from 'three';


init();

function init() {
    const assetPath = 'storage/assets/3d/';


    clock = new THREE.Clock();

    for (let i = 1; i <= 4; i++) {

        let select = '#section' + i;
        let element = $(select);
        let element2 = $('.can_container');

        scene[i] = new THREE.Scene();
        scene[i].background = new THREE.CubeTextureLoader()
            .setPath(`${assetPath}` + i + `/`)
            .load(['px.png', 'nx.png', 'py.png', 'ny.png', 'pz.png', 'nz.png']);

        camera[i] = new THREE.PerspectiveCamera(60, element2.width() / element2.height(), 0.1, 10000);
        camera[i].position.set(0, 0, 0);
        const light = new THREE.DirectionalLight(0xcccccc, 2);
        light.position.set(0, 0, 0);
        scene[i].add(light);
        renderer[i] = new THREE.WebGLRenderer();
        renderer[i].setSize(element2.width(), element2.height());
        element.html(renderer[i].domElement);

    }

    $('.section_container2').on('mouseover', function () {
        target = $(this).data('target');
    });
    $('.section_container2').on('mouseleave', function () {
        target = 0;
    });

    update();


    // window.addEventListener('resize', resize, false);

}


function update() {
    requestAnimationFrame(update);
    for (let i = 1; i <= 4; i++) {
        renderer[i].render(scene[i], camera[i]);
    }
    const dt = clock.getDelta();

    if (target) {
        camera[target].rotation.y += 0.01;
    }

    const time = clock.getElapsedTime();
}


// function resize() {
//     camera.aspect = window.innerWidth / window.innerHeight;
//     camera.updateProjectionMatrix();
//     renderer.setSize(window.innerWidth, window.innerHeight);
// }
