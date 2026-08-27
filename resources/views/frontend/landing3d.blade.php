<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Wiratama Mitra Abadi - Industrial Dashboard</title>
    <meta name="description" content="High Accuracy Industrial Flow Measurement Solutions by PT Wiratama Mitra Abadi. Discover our premium electromagnetic flow meters with a fully interactive 3D view.">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@500;700;900&display=swap');

        :root {
            --primary: #00d2ff;
            --secondary: #0055aa;
            --accent: #ff5500;
            --dark: #020c1b;
            --dark-alt: #0a192f;
            --light: #e6f1ff;
            --text-muted: #8892b0;
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background: radial-gradient(circle at 50% 50%, var(--dark-alt) 0%, var(--dark) 100%);
            font-family: 'Inter', sans-serif;
            color: var(--light);
            -webkit-font-smoothing: antialiased;
        }

        /* Header & Navigation */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-sizing: border-box;
            z-index: 100;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            background: rgba(2, 12, 27, 0.6);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 20px;
            font-weight: 900;
            color: #fff;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
        }

        .logo span {
            background: linear-gradient(90deg, var(--primary), #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 40px;
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            color: var(--light);
            text-decoration: none;
            font-weight: 500;
            font-size: 13px;
            letter-spacing: 1.5px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            position: relative;
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            width: 0%;
            height: 2px;
            bottom: -6px;
            left: 0;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }

        nav ul li a:hover {
            color: var(--primary);
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        /* Main Hero Section */
        main {
            position: relative;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .text-content {
            position: absolute;
            left: 8%;
            top: 50%;
            transform: translateY(-50%);
            max-width: 650px;
            z-index: 10;
            pointer-events: none;
        }

        .badge-new {
            display: inline-block;
            padding: 6px 12px;
            background: rgba(0, 210, 255, 0.1);
            border: 1px solid rgba(0, 210, 255, 0.3);
            border-radius: 50px;
            color: var(--primary);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 25px;
            box-shadow: 0 0 15px rgba(0, 210, 255, 0.1);
        }

        .text-content h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 4.2rem;
            font-weight: 900;
            margin: 0 0 15px 0;
            line-height: 1.1;
            text-shadow: 0 10px 30px rgba(0,0,0,0.8);
            background: linear-gradient(180deg, #ffffff 0%, #a8b2d1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-content p {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 45px;
            line-height: 1.6;
            font-weight: 300;
            max-width: 90%;
        }

        .buttons {
            display: flex;
            gap: 20px;
            pointer-events: auto;
        }

        .btn {
            padding: 16px 32px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            text-decoration: none;
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--secondary) 0%, var(--primary) 100%);
            color: #fff;
            border: none;
            box-shadow: 0 10px 20px rgba(0, 210, 255, 0.2);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.4s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            box-shadow: 0 15px 30px rgba(0, 210, 255, 0.4);
            transform: translateY(-3px);
            color: #fff;
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.02);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #fff;
            transform: translateY(-3px);
            color: #fff;
        }

        #canvas-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            cursor: grab;
        }

        #canvas-container:active {
            cursor: grabbing;
        }

        .viewer-hint {
            position: absolute;
            bottom: 40px;
            right: 60px;
            z-index: 10;
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1.5px;
            display: flex;
            align-items: center;
            gap: 12px;
            pointer-events: none;
            text-transform: uppercase;
            background: rgba(2, 12, 27, 0.5);
            padding: 10px 20px;
            border-radius: 50px;
            border: 1px solid rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
        }

        .viewer-hint svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: var(--primary);
            stroke-width: 2;
            animation: dragAnim 2s infinite ease-in-out;
        }

        @keyframes dragAnim {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(-10px); }
        }

        @media (max-width: 1200px) {
            .text-content h1 { font-size: 3.5rem; }
            .text-content { max-width: 500px; }
        }

        @media (max-width: 900px) {
            header { padding: 20px 30px; }
            nav ul { display: none; }
            .text-content {
                left: 5%;
                top: auto;
                bottom: 10%;
                transform: translateY(0);
                text-align: center;
                width: 90%;
                max-width: none;
            }
            .text-content h1 { font-size: 2.8rem; }
            .text-content p { margin: 15px auto 30px auto; font-size: 1.1rem; }
            .buttons { justify-content: center; }
            .viewer-hint { bottom: 20px; right: 50%; transform: translateX(50%); }
            .badge-new { margin-bottom: 15px; }
        }

        @media (max-width: 480px) {
            .text-content h1 { font-size: 2.2rem; }
            .buttons { flex-direction: column; gap: 15px; }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            PT Wiratama <span>Mitra Abadi</span>
        </div>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('products.index') }}">Products</a></li>
                <li><a href="{{ route('products.index') }}">Services</a></li>
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('contact.index') }}">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="text-content">
            <div class="badge-new">New Release</div>
            <h1 id="product-title">ELECTROMAGNETIC<br>FLOW METER</h1>
            <p>High Accuracy Industrial Flow Measurement Solutions designed for reliability in harsh environments. Experience precision engineering.</p>
            <div class="buttons">
                <a href="{{ route('contact.index') }}" class="btn btn-primary" id="btn-quote">Request Quotation</a>
                <a href="{{ route('products.index') }}" class="btn btn-outline" id="btn-specs">View Specifications</a>
            </div>
        </div>

        <div id="canvas-container"></div>

        <div class="viewer-hint">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8 9l-4 3 4 3M16 9l4 3-4 3M4 12h16"/>
            </svg>
            Interactive 3D View
        </div>
    </main>

    <script async src="https://unpkg.com/es-module-shims@1.8.0/dist/es-module-shims.js"></script>
    <script type="importmap">
    {
        "imports": {
            "three": "https://unpkg.com/three@0.149.0/build/three.module.js",
            "three/addons/": "https://unpkg.com/three@0.149.0/examples/jsm/"
        }
    }
    </script>

    <script type="module">
        import * as THREE from 'three';
        import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
        import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
        import { RoomEnvironment } from 'three/addons/environments/RoomEnvironment.js';

        const container = document.getElementById( 'canvas-container' );
        
        const renderer = new THREE.WebGLRenderer( { antialias: true, alpha: true } );
        renderer.setPixelRatio( window.devicePixelRatio );
        renderer.setSize( window.innerWidth, window.innerHeight );
        renderer.outputEncoding = THREE.sRGBEncoding;
        renderer.toneMapping = THREE.ACESFilmicToneMapping;
        renderer.toneMappingExposure = 1.2;
        container.appendChild( renderer.domElement );

        const scene = new THREE.Scene();

        const pmremGenerator = new THREE.PMREMGenerator( renderer );
        pmremGenerator.compileEquirectangularShader();
        scene.environment = pmremGenerator.fromScene( new RoomEnvironment(), 0.04 ).texture;

        const camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 0.1, 100 );
        camera.position.set( 8, 4, 12 );

        const controls = new OrbitControls( camera, renderer.domElement );
        controls.enableDamping = true;
        controls.dampingFactor = 0.05;
        controls.autoRotate = true;
        controls.autoRotateSpeed = 1.2;
        controls.enableZoom = true;
        controls.minDistance = 6;
        controls.maxDistance = 20;
        controls.target.set( 1.5, 0, 0 );

        const ambientLight = new THREE.AmbientLight(0xffffff, 0.2);
        scene.add(ambientLight);

        const blueSpot = new THREE.SpotLight(0x00d2ff, 3);
        blueSpot.position.set(-5, 8, 5);
        blueSpot.angle = Math.PI / 4;
        blueSpot.penumbra = 0.8;
        scene.add(blueSpot);

        const orangeSpot = new THREE.SpotLight(0xff5500, 2);
        orangeSpot.position.set(5, 5, -5);
        orangeSpot.angle = Math.PI / 4;
        orangeSpot.penumbra = 0.8;
        scene.add(orangeSpot);

        const pedestalGroup = new THREE.Group();
        pedestalGroup.position.set(1.5, -3, 0);
        scene.add(pedestalGroup);

        const pedestalGeo = new THREE.CylinderGeometry(4, 4.5, 0.2, 64);
        const pedestalMat = new THREE.MeshPhysicalMaterial({
            color: 0x0a192f,
            metalness: 0.9,
            roughness: 0.4,
            clearcoat: 1.0,
        });
        const pedestal = new THREE.Mesh(pedestalGeo, pedestalMat);
        pedestalGroup.add(pedestal);

        const ringGeo = new THREE.TorusGeometry(4.1, 0.02, 16, 100);
        const ringMat = new THREE.MeshBasicMaterial({ color: 0x00d2ff });
        const ring = new THREE.Mesh(ringGeo, ringMat);
        ring.position.y = 0.1;
        ring.rotation.x = Math.PI / 2;
        pedestalGroup.add(ring);

        const particleCount = 150;
        const particleGeo = new THREE.BufferGeometry();
        const particlePos = new Float32Array(particleCount * 3);
        for(let i=0; i<particleCount*3; i++) {
            particlePos[i] = (Math.random() - 0.5) * 20;
        }
        particleGeo.setAttribute('position', new THREE.BufferAttribute(particlePos, 3));
        const particleMat = new THREE.PointsMaterial({
            color: 0x00d2ff,
            size: 0.05,
            transparent: true,
            opacity: 0.6,
            blending: THREE.AdditiveBlending
        });
        const particles = new THREE.Points(particleGeo, particleMat);
        scene.add(particles);

        const productGroup = new THREE.Group();
        productGroup.position.set(1.5, 0, 0);
        scene.add(productGroup);

        const loader = new GLTFLoader();
        loader.load(
            '/models/flowmeter.glb',
            function ( gltf ) {
                const model = gltf.scene;
                model.scale.set( 3, 3, 3 );
                productGroup.add( model );
            },
            undefined,
            function ( error ) {
                createProceduralFlowMeter(productGroup);
            }
        );

        function createProceduralFlowMeter(group) {
            const bluePaintMat = new THREE.MeshPhysicalMaterial({
                color: 0x0044aa,
                metalness: 0.3,
                roughness: 0.2,
                clearcoat: 1.0,
                clearcoatRoughness: 0.1
            });

            const steelMat = new THREE.MeshPhysicalMaterial({
                color: 0xd0d5db,
                metalness: 0.95,
                roughness: 0.2,
                clearcoat: 0.3
            });

            const darkPlasticMat = new THREE.MeshPhysicalMaterial({
                color: 0x111111,
                metalness: 0.2,
                roughness: 0.8
            });

            const pipeGeo = new THREE.CylinderGeometry(1.4, 1.4, 4.5, 64);
            const pipe = new THREE.Mesh(pipeGeo, steelMat);
            pipe.rotation.z = Math.PI / 2;
            group.add(pipe);

            const flangeGeo = new THREE.CylinderGeometry(2.2, 2.2, 0.3, 64);
            const flange1 = new THREE.Mesh(flangeGeo, steelMat);
            flange1.position.x = 2.25;
            flange1.rotation.z = Math.PI / 2;
            group.add(flange1);

            const flange2 = new THREE.Mesh(flangeGeo, steelMat);
            flange2.position.x = -2.25;
            flange2.rotation.z = Math.PI / 2;
            group.add(flange2);

            for(let i=0; i<8; i++) {
                const angle = (i / 8) * Math.PI * 2;
                const boltGeo = new THREE.CylinderGeometry(0.12, 0.12, 0.5, 16);
                
                const bolt1 = new THREE.Mesh(boltGeo, steelMat);
                bolt1.position.set(2.25, Math.cos(angle)*1.8, Math.sin(angle)*1.8);
                bolt1.rotation.z = Math.PI / 2;
                group.add(bolt1);

                const bolt2 = new THREE.Mesh(boltGeo, steelMat);
                bolt2.position.set(-2.25, Math.cos(angle)*1.8, Math.sin(angle)*1.8);
                bolt2.rotation.z = Math.PI / 2;
                group.add(bolt2);
            }

            const liningGeo = new THREE.CylinderGeometry(1.1, 1.1, 4.55, 64);
            const lining = new THREE.Mesh(liningGeo, darkPlasticMat);
            lining.rotation.z = Math.PI / 2;
            group.add(lining);

            const stemGeo = new THREE.CylinderGeometry(0.4, 0.5, 1.5, 32);
            const stem = new THREE.Mesh(stemGeo, steelMat);
            stem.position.y = 1.6;
            group.add(stem);

            const baseHousingGeo = new THREE.CylinderGeometry(1.1, 1.1, 0.6, 32);
            const baseHousing = new THREE.Mesh(baseHousingGeo, bluePaintMat);
            baseHousing.position.y = 2.5;
            group.add(baseHousing);

            const mainHousingGeo = new THREE.SphereGeometry(1.2, 32, 32, 0, Math.PI * 2, 0, Math.PI / 2);
            const mainHousing = new THREE.Mesh(mainHousingGeo, bluePaintMat);
            mainHousing.position.y = 2.5;
            mainHousing.scale.y = 1.3;
            group.add(mainHousing);

            const backGeo = new THREE.CylinderGeometry(1.2, 1.2, 0.5, 32);
            const back = new THREE.Mesh(backGeo, bluePaintMat);
            back.position.set(0, 3.2, -0.8);
            back.rotation.x = Math.PI / 2;
            group.add(back);

            const bezelGeo = new THREE.CylinderGeometry(0.9, 0.9, 0.2, 32);
            const bezel = new THREE.Mesh(bezelGeo, darkPlasticMat);
            bezel.position.set(0, 3.3, 1.0);
            bezel.rotation.x = Math.PI / 2;
            group.add(bezel);

            const canvas = document.createElement('canvas');
            canvas.width = 256;
            canvas.height = 256;
            const ctx = canvas.getContext('2d');
            
            ctx.fillStyle = '#010a15';
            ctx.fillRect(0, 0, 256, 256);
            
            ctx.fillStyle = '#0055aa';
            ctx.fillRect(0, 0, 256, 40);
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 20px Inter, sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText('STATUS: ONLINE', 128, 28);
            
            ctx.fillStyle = '#00d2ff';
            ctx.font = 'bold 65px Orbitron, sans-serif';
            ctx.fillText('428.5', 128, 120);
            
            ctx.fillStyle = '#8892b0';
            ctx.font = '22px Inter, sans-serif';
            ctx.fillText('m³/h', 128, 155);
            
            ctx.strokeStyle = '#00d2ff';
            ctx.lineWidth = 4;
            ctx.beginPath();
            ctx.moveTo(20, 230);
            ctx.lineTo(60, 200);
            ctx.lineTo(100, 215);
            ctx.lineTo(140, 180);
            ctx.lineTo(180, 195);
            ctx.lineTo(220, 160);
            ctx.lineTo(240, 175);
            ctx.stroke();

            ctx.lineTo(240, 256);
            ctx.lineTo(20, 256);
            ctx.closePath();
            const grad = ctx.createLinearGradient(0, 160, 0, 256);
            grad.addColorStop(0, 'rgba(0, 210, 255, 0.4)');
            grad.addColorStop(1, 'rgba(0, 210, 255, 0.0)');
            ctx.fillStyle = grad;
            ctx.fill();

            const screenTex = new THREE.CanvasTexture(canvas);
            screenTex.anisotropy = renderer.capabilities.getMaxAnisotropy();
            
            const screenMat = new THREE.MeshBasicMaterial({ map: screenTex });
            const screenGeo = new THREE.CircleGeometry(0.78, 32);
            const screen = new THREE.Mesh(screenGeo, screenMat);
            screen.position.set(0, 3.3, 1.11);
            group.add(screen);

            group.rotation.x = 0.15;
            group.rotation.y = -0.3;
        }

        const clock = new THREE.Clock();

        function animate() {
            requestAnimationFrame( animate );
            const time = clock.getElapsedTime();
            productGroup.position.y = Math.sin(time * 1.5) * 0.15;
            particles.rotation.y = time * 0.05;
            controls.update(); 
            renderer.render( scene, camera );
        }
        animate();

        window.addEventListener( 'resize', onWindowResize, false );
        function onWindowResize() {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize( window.innerWidth, window.innerHeight );
        }
    </script>
</body>
</html>
