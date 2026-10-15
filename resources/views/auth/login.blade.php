<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Administrator - Sertifikasi Peserta</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        /* ===== Karakter animasi panel login ===== */
        .scene .char {
            position: absolute;
            bottom: 0;
            animation: bob 5s ease-in-out infinite;
            transition: translate .3s ease-out;
        }
        .scene .turn {
            position: absolute;
            inset: 0;
            transition: transform .5s cubic-bezier(.4, 0, .2, 1), opacity .35s ease;
        }
        .scene .face {
            position: absolute;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            transition: transform .15s ease-out;
        }
        .scene .eye {
            position: relative;
            width: var(--s, 20px);
            height: var(--s, 20px);
            border-radius: 9999px;
            background: #ffffff;
            transition: transform .12s ease;
        }
        .scene .eye.blink {
            transform: scaleY(.1);
        }
        .scene .pupil {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 45%;
            height: 45%;
            margin: -22.5% 0 0 -22.5%;
            border-radius: 9999px;
            background: #0f172a;
            transition: transform .12s ease-out;
        }
        /* Saat mengetik password: karakter membelakangi (wajah menyempit lalu hilang) */
        .scene[data-mood="away"] .turn {
            opacity: 0;
            transform: translateX(-35%) scaleX(.15);
        }
        /* ===== Aksesoris karakter ===== */
        /* A: topi tinggi */
        .scene .hat-top {
            position: absolute;
            left: 50%;
            bottom: 100%;
            width: 96px;
            height: 72px;
            margin-left: -48px;
        }
        .scene .hat-top::before {
            content: '';
            position: absolute;
            left: 14px;
            right: 14px;
            bottom: 8px;
            height: 64px;
            border-radius: 6px 6px 0 0;
            background: linear-gradient(to bottom, #f8fafc 0 68%, #f43f5e 68% 86%, #f8fafc 86% 100%);
        }
        .scene .hat-top::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 10px;
            border-radius: 5px;
            background: #f8fafc;
        }
        /* B: kacamata bulat */
        .scene .glasses .eye { box-shadow: 0 0 0 5px #0f172a; }
        .scene .glasses::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 34px;
            height: 5px;
            margin: -2px 0 0 -17px;
            background: #0f172a;
        }
        /* C: dasi kupu-kupu */
        .scene .bowtie {
            position: absolute;
            left: 50%;
            bottom: 20px;
            width: 60px;
            height: 28px;
            margin-left: -30px;
        }
        .scene .bowtie::before,
        .scene .bowtie::after {
            content: '';
            position: absolute;
            top: 0;
            width: 28px;
            height: 28px;
            background: #f43f5e;
        }
        .scene .bowtie::before { left: 0; clip-path: polygon(0 0, 100% 50%, 0 100%); }
        .scene .bowtie::after { right: 0; clip-path: polygon(100% 0, 0 50%, 100% 100%); }
        .scene .bowtie i {
            position: absolute;
            left: 50%;
            top: 7px;
            width: 12px;
            height: 14px;
            margin-left: -6px;
            border-radius: 4px;
            background: #be123c;
            z-index: 1;
        }
        /* E: pipi merona */
        .scene .blush {
            position: absolute;
            top: 86px;
            width: 14px;
            height: 8px;
            border-radius: 9999px;
            background: #f472b6;
            opacity: .85;
        }
        /* D: topi baseball */
        .scene .cap {
            position: absolute;
            left: 50%;
            bottom: 100%;
            width: 92px;
            height: 40px;
            margin-left: -46px;
        }
        .scene .cap::before {
            content: '';
            position: absolute;
            left: 8px;
            bottom: -2px;
            width: 76px;
            height: 38px;
            border-radius: 38px 38px 0 0;
            background: #f43f5e;
        }
        .scene .cap::after {
            content: '';
            position: absolute;
            left: 48px;
            bottom: -2px;
            width: 58px;
            height: 10px;
            border-radius: 0 10px 10px 0;
            background: #be123c;
        }
        /* F: headphone */
        .scene .hp-band {
            position: absolute;
            left: -9px;
            top: -9px;
            width: 150px;
            height: 110px;
            border: 7px solid #f8fafc;
            border-bottom: 0;
            border-radius: 75px 75px 0 0;
        }
        .scene .hp-cup {
            position: absolute;
            top: 62px;
            width: 24px;
            height: 54px;
            border-radius: 10px;
            background: #f8fafc;
            box-shadow: inset 0 0 0 4px #059669;
        }
        @keyframes bob {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        #scene { transform-origin: center center; }
        @media (max-width: 1535px) {
            #scene { transform: scale(.9); }
        }
        @media (max-width: 1279px) {
            #scene { transform: scale(.7); }
        }
        @media (prefers-reduced-motion: reduce) {
            .scene .char { animation: none; }
            .scene *, .scene *::before, .scene *::after { transition: none !important; }
        }
    </style>
</head>
<body class="h-full bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-100 font-sans antialiased">
<div class="min-h-screen grid lg:grid-cols-2">

    <!-- Panel kiri: karakter animasi (hanya tampil di layar besar) -->
    <aside class="hidden lg:flex flex-col justify-between bg-slate-950 text-slate-300 p-10 border-r border-slate-800">
        <div class="flex items-center">
            <i data-lucide="shield-check" class="w-6 h-6 text-indigo-400 mr-3"></i>
            <span class="font-bold text-white text-lg tracking-wide">Sertifikasi</span>
        </div>

        <div class="flex-1 flex items-center justify-center">
            <div id="scene" class="scene relative" data-mood="watch" style="width:600px;height:460px" aria-hidden="true">

                <!-- A: persegi panjang tinggi -->
                <div class="char" style="left:68px;width:190px;height:380px;background:#4f46e5;border-radius:14px 14px 0 0;z-index:1;">
                    <span class="hat-top"></span>
                    <div class="turn">
                        <div class="face" style="top:66px;gap:32px;--s:30px">
                            <span class="eye"><span class="pupil"></span></span>
                            <span class="eye"><span class="pupil"></span></span>
                        </div>
                    </div>
                </div>

                <!-- B: persegi panjang lebar -->
                <div class="char" style="left:225px;width:204px;height:258px;background:#475569;border-radius:14px 14px 0 0;z-index:2;animation-delay:-1.2s;">
                    <div class="turn">
                        <div class="face glasses" style="top:54px;gap:40px;--s:30px">
                            <span class="eye"><span class="pupil"></span></span>
                            <span class="eye"><span class="pupil"></span></span>
                        </div>
                    </div>
                </div>

                <!-- E: segitiga kecil di atas B (bergerak bersama B) -->
                <div class="char" style="left:266px;bottom:258px;width:122px;height:108px;background:#818cf8;clip-path:polygon(50% 0, 100% 100%, 0 100%);z-index:3;animation-delay:-1.2s;">
                    <div class="turn">
                        <span class="blush" style="left:calc(50% - 40px)"></span>
                        <span class="blush" style="right:calc(50% - 40px)"></span>
                        <div class="face" style="top:62px;gap:11px;--s:20px">
                            <span class="eye"><span class="pupil"></span></span>
                            <span class="eye"><span class="pupil"></span></span>
                        </div>
                    </div>
                </div>

                <!-- C: segitiga besar -->
                <div class="char" style="left:20px;width:204px;height:177px;background:#fbbf24;clip-path:polygon(50% 0, 100% 100%, 0 100%);z-index:4;animation-delay:-2.4s;">
                    <div class="turn">
                        <div class="bowtie"><i></i></div>
                        <div class="face" style="top:98px;gap:19px;--s:25px">
                            <span class="eye"><span class="pupil"></span></span>
                            <span class="eye"><span class="pupil"></span></span>
                        </div>
                    </div>
                </div>

                <!-- D: persegi -->
                <div class="char" style="left:408px;width:156px;height:156px;background:#c7d2fe;border-radius:11px 11px 0 0;z-index:5;animation-delay:-3.2s;">
                    <span class="cap"></span>
                    <div class="turn">
                        <div class="face" style="top:44px;gap:30px;--s:27px">
                            <span class="eye"><span class="pupil"></span></span>
                            <span class="eye"><span class="pupil"></span></span>
                        </div>
                    </div>
                </div>

                <!-- F: pil tinggi (varian baru, di belakang D) -->
                <div class="char" style="left:452px;width:132px;height:440px;background:#34d399;border-radius:66px 66px 0 0;z-index:0;animation-delay:-4.1s;">
                    <div class="hp-band"></div>
                    <span class="hp-cup" style="left:-14px"></span>
                    <span class="hp-cup" style="right:-14px"></span>
                    <div class="turn">
                        <div class="face" style="top:72px;gap:26px;--s:36px">
                            <span class="eye"><span class="pupil"></span></span>
                            <span class="eye"><span class="pupil"></span></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div>
            <h2 class="text-xl font-semibold text-white">Pengelolaan Data Peserta Sertifikasi</h2>
            <p class="text-sm text-slate-400 mt-1">Kelola data peserta dan skema sertifikasi dalam satu tempat.</p>
            <p class="text-xs text-slate-500 mt-6">Uji Kompetensi JWD &copy; 2026</p>
        </div>
    </aside>

    <!-- Panel kanan: form login -->
    <main class="relative flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <!-- Toggle mode terang/gelap -->
        <button id="theme-toggle" type="button" class="absolute top-4 right-4 p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 transition" aria-label="Ganti mode tampilan">
            <i data-lucide="sun" class="w-5 h-5 hidden dark:block"></i>
            <i data-lucide="moon" class="w-5 h-5 block dark:hidden"></i>
        </button>

        <div class="max-w-md w-full bg-white dark:bg-slate-800 p-8 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-50 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 mb-4">
                    <i data-lucide="lock" class="w-6 h-6"></i>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Masuk Administrator</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Pengelolaan Data Peserta Sertifikasi</p>
            </div>

            @if($errors->any())
                <div role="alert" class="mt-6 bg-rose-50 dark:bg-rose-950/60 border-l-4 border-rose-500 dark:border-rose-400 p-4 rounded-r-xl shadow-sm text-sm text-rose-700 dark:text-rose-300 flex items-start space-x-3 transition-all">
                    <div class="p-1 bg-rose-100 dark:bg-rose-900/50 rounded-lg text-rose-600 dark:text-rose-300">
                        <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                    </div>
                    <div class="flex-1">
                        <span class="font-semibold block text-rose-800 dark:text-rose-200">Gagal Masuk</span>
                        <span class="mt-0.5 block">{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                               class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-900 border {{ $errors->has('email') ? 'border-rose-500' : 'border-slate-300 dark:border-slate-700' }} rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                        <div class="relative mt-1">
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                   class="block w-full pl-3 pr-10 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <button id="toggle-password" type="button"
                                    class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition"
                                    aria-label="Tampilkan password" aria-pressed="false" aria-controls="password">
                                <span id="icon-show"><i data-lucide="eye" class="w-5 h-5"></i></span>
                                <span id="icon-hide" class="hidden"><i data-lucide="eye-off" class="w-5 h-5"></i></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label for="remember" class="group inline-flex items-center gap-2.5 cursor-pointer select-none py-1 pr-2 text-slate-700 dark:text-slate-300">
                        <input id="remember" name="remember" type="checkbox" value="1" {{ old('remember') ? 'checked' : '' }}
                               class="h-5 w-5 cursor-pointer rounded accent-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                        <span class="group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">Ingat Saya</span>
                    </label>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-800 transition">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    lucide.createIcons();

    // ===== Toggle tema =====
    document.getElementById('theme-toggle').addEventListener('click', function () {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.theme = 'light';
        } else {
            document.documentElement.classList.add('dark');
            localStorage.theme = 'dark';
        }
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    // ===== Karakter animasi =====
    (function () {
        var scene = document.getElementById('scene');
        var pw = document.getElementById('password');
        var toggle = document.getElementById('toggle-password');
        if (!scene || !pw || !toggle) return;

        var faces = Array.prototype.slice.call(scene.querySelectorAll('.face'));
        var eyes = Array.prototype.slice.call(scene.querySelectorAll('.eye'));
        var chars = Array.prototype.slice.call(scene.querySelectorAll('.char'));
        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        var IDLE_MS = 4000;
        var pointer = null;
        var focused = false;
        var typingRecently = false;
        var visible = false;
        var idleTimer = null;
        var raf = 0;

        function currentMood() {
            if (focused && typingRecently) return visible ? 'peek' : 'away';
            return 'watch';
        }

        function lookTarget(mood) {
            if (mood === 'peek') {
                var r = pw.getBoundingClientRect();
                return { x: r.left + r.width / 2, y: r.top + r.height / 2 };
            }
            return pointer;
        }

        function render() {
            raf = 0;
            var mood = scene.getAttribute('data-mood');
            var target = lookTarget(mood);
            var active = target && mood !== 'away';

            // Badan karakter ikut bergeser sedikit ke arah kursor (naik saat kursor di atas)
            var sRect = scene.getBoundingClientRect();
            var sx = 0, sy = 0;
            if (active) {
                sx = Math.max(-1, Math.min(1, (target.x - (sRect.left + sRect.width / 2)) / 400));
                sy = Math.max(-1, Math.min(1, (target.y - (sRect.top + sRect.height / 2)) / 300));
            }
            chars.forEach(function (ch, i) {
                var depth = 0.6 + (i % 3) * 0.2;
                ch.style.translate = (sx * 6 * depth) + 'px ' + (sy * 10 * depth) + 'px';
            });

            faces.forEach(function (face) {
                var box = face.parentElement.getBoundingClientRect();
                var x = 0, y = 0;
                if (active) {
                    var cx = box.left + box.width / 2;
                    var cy = box.top + face.offsetTop + face.offsetHeight / 2;
                    var dx = target.x - cx, dy = target.y - cy;
                    var d = Math.hypot(dx, dy) || 1;
                    var k = Math.min(d / 240, 1) * 6;
                    x = dx / d * k;
                    y = dy / d * k;
                }
                face.style.transform = 'translate(' + x + 'px,' + y + 'px)';
            });

            eyes.forEach(function (eye) {
                var pupil = eye.firstElementChild;
                var x = 0, y = 0;
                if (active) {
                    var r = eye.getBoundingClientRect();
                    var dx = target.x - (r.left + r.width / 2);
                    var dy = target.y - (r.top + r.height / 2);
                    var d = Math.hypot(dx, dy) || 1;
                    var k = Math.min(d / 80, 1) * r.width * 0.27;
                    x = dx / d * k;
                    y = dy / d * k;
                }
                pupil.style.transform = 'translate(' + x + 'px,' + y + 'px)';
            });
        }

        function schedule() {
            if (!raf) raf = requestAnimationFrame(render);
        }

        function apply() {
            scene.setAttribute('data-mood', currentMood());
            schedule();
        }

        function bumpTyping() {
            typingRecently = true;
            clearTimeout(idleTimer);
            idleTimer = setTimeout(function () {
                typingRecently = false;
                apply();
            }, IDLE_MS);
            apply();
        }

        window.addEventListener('pointermove', function (e) {
            pointer = { x: e.clientX, y: e.clientY };
            schedule();
        }, { passive: true });
        document.documentElement.addEventListener('mouseleave', function () {
            pointer = null;
            schedule();
        });
        window.addEventListener('resize', schedule);
        window.addEventListener('scroll', schedule, { passive: true });

        pw.addEventListener('focus', function () { focused = true; bumpTyping(); });
        pw.addEventListener('input', bumpTyping);
        pw.addEventListener('blur', function () {
            focused = false;
            typingRecently = false;
            clearTimeout(idleTimer);
            apply();
        });

        toggle.addEventListener('mousedown', function (e) { e.preventDefault(); });
        toggle.addEventListener('click', function () {
            visible = pw.type === 'password';
            pw.type = visible ? 'text' : 'password';
            document.getElementById('icon-show').classList.toggle('hidden', visible);
            document.getElementById('icon-hide').classList.toggle('hidden', !visible);
            toggle.setAttribute('aria-pressed', visible ? 'true' : 'false');
            toggle.setAttribute('aria-label', visible ? 'Sembunyikan password' : 'Tampilkan password');
            if (focused) { bumpTyping(); } else { apply(); }
        });

        if (!reduceMotion) {
            (function blinkLoop() {
                setTimeout(function () {
                    if (scene.getAttribute('data-mood') !== 'away') {
                        eyes.forEach(function (eye) { eye.classList.add('blink'); });
                        setTimeout(function () {
                            eyes.forEach(function (eye) { eye.classList.remove('blink'); });
                        }, 140);
                    }
                    blinkLoop();
                }, 2500 + Math.random() * 3000);
            })();
        }

        apply();
    })();
</script>
</body>
</html>