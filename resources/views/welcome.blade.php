<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Control C-Technology</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root {
            --bg-dark: #0b0f1a;
            --bg-light: #f4f6fb;
            --card-dark: rgba(255, 255, 255, 0.08);
            --card-light: #ffffff;
            --text-dark: #ffffff;
            --text-light: #0b0f1a;
            --accent: #00e5ff;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, sans-serif;
            min-height: 100vh;
            overflow: hidden;
            transition: background 0.4s, color 0.4s;
        }

        body.dark {
            background: var(--bg-dark);
            color: var(--text-dark);
        }

        body.light {
            background: var(--bg-light);
            color: var(--text-light);
        }

        canvas {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 2;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 90%;
            max-width: 500px;
            padding: 50px 40px;
            border-radius: 20px;
            text-align: center;
            backdrop-filter: blur(15px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            transition: background 0.4s;
        }

        body.dark .card {
            background: var(--card-dark);
        }

        body.light .card {
            background: var(--card-light);
        }

        .logo {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .logo span {
            color: var(--accent);
        }

        .tagline {
            font-size: 15px;
            opacity: 0.85;
            margin-bottom: 25px;
        }

        .description {
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 35px;
        }

        .login-btn {
            padding: 14px 40px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 30px;
            border: none;
            background: var(--accent);
            color: #002b36;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,229,255,0.4);
        }

        .toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 3;
            cursor: pointer;
            padding: 10px 14px;
            border-radius: 20px;
            background: rgba(0,0,0,0.3);
            color: #fff;
            font-size: 14px;
            user-select: none;
        }

        body.light .toggle {
            background: rgba(255,255,255,0.7);
            color: #000;
        }

        footer {
            margin-top: 30px;
            font-size: 13px;
            opacity: 0.7;
        }
    </style>
</head>
<body class="dark">

<canvas id="particles"></canvas>

<div class="toggle" id="modeToggle">🌙 Dark</div>

<div class="container">
    <div class="card">
        <div class="logo">
            Control<span> C-Technology</span>
        </div>

        <div class="tagline">
            Laptops • Accessories • Consoles • Games
        </div>

        <div class="description">
            A smart digital system for managing inventory, tracking sales,
            and controlling stock with speed, accuracy, and confidence.
        </div>

        <a href="{{ route('login') }}" class="login-btn">
            Login to System
        </a>

        <footer>
            © {{ date('Y') }} Control C-Technology
        </footer>
    </div>
</div>

<script>
    /* ---------------------------
       Dark / Light Mode Toggle
    ---------------------------- */
    const body = document.body;
    const toggle = document.getElementById('modeToggle');

    const savedMode = localStorage.getItem('mode') || 'dark';
    body.className = savedMode;
    toggle.textContent = savedMode === 'dark' ? '🌙 Dark' : '☀️ Light';

    toggle.onclick = () => {
        const newMode = body.classList.contains('dark') ? 'light' : 'dark';
        body.className = newMode;
        localStorage.setItem('mode', newMode);
        toggle.textContent = newMode === 'dark' ? '🌙 Dark' : '☀️ Light';
    };

    /* ---------------------------
       Subtle Tech Particle Effect
    ---------------------------- */
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');

    function resize() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    window.addEventListener('resize', resize);
    resize();

    const particles = Array.from({ length: 70 }, () => ({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        r: Math.random() * 2 + 1,
        dx: (Math.random() - 0.5) * 0.5,
        dy: (Math.random() - 0.5) * 0.5
    }));

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        particles.forEach(p => {
            p.x += p.dx;
            p.y += p.dy;

            if (p.x < 0 || p.x > canvas.width) p.dx *= -1;
            if (p.y < 0 || p.y > canvas.height) p.dy *= -1;

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(0,229,255,0.5)';
            ctx.fill();
        });

        requestAnimationFrame(animate);
    }

    animate();
</script>

</body>
</html>
