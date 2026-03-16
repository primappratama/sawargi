<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SAWARGI</title>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --font: -apple-system, 'SF Pro Display', 'SF Pro Text', 'Helvetica Neue', sans-serif;
            --mono: 'SF Mono', ui-monospace, monospace;
            --blue:   #1a6bff;
            --blue2:  #1354d4;
            --cyan:   #06b6d4;
            --ink:    #1d1d1f;
            --ink2:   #3d3d3f;
            --ink3:   #6e6e73;
            --ink4:   #a1a1a6;
            --bg:     #f5f5f7;
            --white:  #ffffff;
            --rule:   rgba(0,0,0,.07);
            --danger: #dc2626; --danger-bg: #fef2f2; --danger-bd: rgba(220,38,38,.18);
            --safe:   #059669;
        }
        html, body { height: 100%; }
        body {
            font-family: var(--font);
            min-height: 100svh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            -webkit-font-smoothing: antialiased;
            overflow: hidden;
        }

        /* ─── LEFT PANEL — foto desa ─── */
        .left {
            position: relative;
            background-image:
                linear-gradient(to bottom right,
                    rgba(0,0,0,.55) 0%,
                    rgba(0,0,0,.3) 50%,
                    rgba(0,0,0,.7) 100%
                ),
                url('/nagrakjaya.png');
            background-size: cover;
            background-position: center;
            display: flex; flex-direction: column; justify-content: space-between;
            padding: 40px;
        }
        .left::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(26,107,255,.15), rgba(6,182,212,.08));
            pointer-events: none;
        }

        /* Top accent line */
        .left::after {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--blue), var(--cyan));
        }

        .left-top { position: relative; z-index: 1; }
        .left-logo {
            display: inline-flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.18);
            backdrop-filter: blur(12px);
            border-radius: 12px; padding: 8px 14px;
        }
        .left-logo-icon {
            width: 28px; height: 28px; border-radius: 8px;
            display: grid; place-items: center;
            box-shadow: 0 2px 8px rgba(26,107,255,.4);
        }
        .left-logo-name { font-size: 14px; font-weight: 800; color: #fff; letter-spacing: -.2px; }

        .left-bottom { position: relative; z-index: 1; }
        .left-tag {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.15);
            backdrop-filter: blur(10px); border-radius: 20px;
            padding: 5px 12px; margin-bottom: 18px;
        }
        .left-dot { width: 5px; height: 5px; border-radius: 50%; background: #34d399; animation: blink 2s ease-in-out infinite; }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }
        .left-tag-txt { font-size: 10px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,.8); }
        .left-h {
            font-size: clamp(28px, 3.5vw, 44px);
            font-weight: 900; letter-spacing: -1.5px; line-height: 1.05;
            color: #fff; margin-bottom: 12px;
        }
        .left-h span { color: rgba(255,255,255,.4); font-weight: 700; font-size: .55em; display: block; letter-spacing: 0; margin-top: 6px; }
        .left-sub { font-size: 13px; color: rgba(255,255,255,.5); line-height: 1.6; max-width: 320px; margin-bottom: 28px; }

        /* Stats strip */
        .left-stats { display: flex; gap: 0; }
        .lst {
            flex: 1; padding: 0 20px;
            border-right: 1px solid rgba(255,255,255,.1);
        }
        .lst:first-child { padding-left: 0; }
        .lst:last-child  { border: none; }
        .lst-n { font-size: 22px; font-weight: 800; color: #fff; letter-spacing: -.5px; line-height: 1; margin-bottom: 3px; }
        .lst-l { font-size: 9px; color: rgba(255,255,255,.35); letter-spacing: 1.5px; text-transform: uppercase; }

        /* ─── RIGHT PANEL — form ─── */
        .right {
            background: var(--white);
            display: flex; align-items: center; justify-content: center;
            padding: 48px 40px;
            position: relative;
        }
        .right::before {
            content: '';
            position: absolute; top: 0; left: 0; bottom: 0; width: .5px;
            background: var(--rule);
        }

        /* subtle bg pattern */
        .right-bg {
            position: absolute; inset: 0; pointer-events: none; z-index: 0;
            background-image: radial-gradient(circle at 80% 20%, rgba(26,107,255,.04) 0%, transparent 50%),
                              radial-gradient(circle at 20% 80%, rgba(6,182,212,.03) 0%, transparent 50%);
        }

        .form-wrap { width: 100%; max-width: 360px; position: relative; z-index: 1; }

        /* Header */
        .form-header { margin-bottom: 36px; }
        .form-eyebrow {
            font-size: 10px; font-weight: 700; letter-spacing: 2.5px;
            text-transform: uppercase; color: var(--blue); margin-bottom: 8px;
        }
        .form-title {
            font-size: 28px; font-weight: 800; letter-spacing: -.7px;
            color: var(--ink); line-height: 1.1; margin-bottom: 6px;
        }
        .form-sub { font-size: 13px; color: var(--ink4); line-height: 1.5; }

        /* Error */
        .error-box {
            display: flex; align-items: center; gap: 9px;
            background: var(--danger-bg); border: 1px solid var(--danger-bd);
            border-left: 3px solid var(--danger);
            border-radius: 10px; padding: 11px 14px;
            font-size: 12px; color: var(--danger); font-weight: 500;
            margin-bottom: 20px;
            animation: shake .4s ease;
        }
        @keyframes shake {
            0%,100%{transform:translateX(0)} 20%{transform:translateX(-6px)} 60%{transform:translateX(6px)}
        }

        /* Input groups */
        .fg { margin-bottom: 16px; }
        .fg-label {
            display: block; font-size: 11px; font-weight: 700;
            letter-spacing: .5px; color: var(--ink2); margin-bottom: 7px;
        }
        .fg-input-wrap { position: relative; }
        .fg-icon {
            position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
            color: var(--ink4); pointer-events: none;
            display: flex; align-items: center;
        }
        .fg-input {
            width: 100%; padding: 12px 14px 12px 40px;
            border: 1.5px solid var(--rule);
            border-radius: 11px; font-size: 14px; color: var(--ink);
            background: var(--bg); outline: none;
            font-family: var(--font);
            transition: border-color .2s, background .2s, box-shadow .2s;
        }
        .fg-input:focus {
            border-color: var(--blue);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(26,107,255,.1);
        }
        .fg-input::placeholder { color: var(--ink4); }

        /* Show/hide password */
        .pw-toggle {
            position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: var(--ink4); display: flex; align-items: center;
            transition: color .2s;
        }
        .pw-toggle:hover { color: var(--ink2); }

        /* Submit */
        .btn-submit {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, var(--blue), #2979ff);
            color: #fff; border: none; border-radius: 11px;
            font-size: 14px; font-weight: 700; font-family: var(--font);
            cursor: pointer; margin-top: 8px;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            box-shadow: 0 4px 20px rgba(26,107,255,.35);
            transition: all .2s;
            position: relative; overflow: hidden;
        }
        .btn-submit::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, transparent 40%, rgba(255,255,255,.08));
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 28px rgba(26,107,255,.45); }
        .btn-submit:active { transform: translateY(0); }

        /* Divider */
        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 24px 0; color: var(--ink4); font-size: 11px;
        }
        .divider::before, .divider::after { content: ''; flex: 1; height: .5px; background: var(--rule); }

        /* Info chips */
        .info-chips { display: flex; flex-wrap: wrap; gap: 8px; }
        .chip {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 12px; border-radius: 20px;
            background: var(--bg); border: 1px solid var(--rule);
            font-size: 11px; color: var(--ink3);
        }
        .chip-dot { width: 5px; height: 5px; border-radius: 50%; }

        /* Footer */
        .form-footer {
            margin-top: 32px; padding-top: 20px;
            border-top: .5px solid var(--rule);
            font-size: 11px; color: var(--ink4); text-align: center;
            line-height: 1.7;
        }

        /* ─── ULTRAWIDE 34"+ ─── */
        @media(min-width: 2560px) {
            .left  { padding: 56px 64px; }
            .left-h { font-size: 56px; }
            .left-sub { font-size: 16px; max-width: 420px; }
            .lst-n { font-size: 28px; }
            .lst-l { font-size: 11px; }
            .right { padding: 64px; }
            .form-wrap { max-width: 480px; }
            .form-title { font-size: 38px; }
            .form-sub { font-size: 16px; }
            .fg-input { padding: 15px 16px 15px 46px; font-size: 16px; }
            .fg-label { font-size: 13px; }
            .btn-submit { padding: 16px; font-size: 16px; }
            .chip { font-size: 13px; padding: 8px 16px; }
        }

        /* ─── LARGE DESKTOP 24" ─── */
        @media(min-width: 1920px) and (max-width: 2559px) {
            .left  { padding: 48px 56px; }
            .left-h { font-size: 46px; }
            .right { padding: 56px; }
            .form-wrap { max-width: 420px; }
            .form-title { font-size: 32px; }
            .fg-input { font-size: 15px; }
            .btn-submit { padding: 14px; font-size: 15px; }
        }

        /* ─── TABLET (768px–1023px) ─── */
        @media(max-width: 1023px) {
            body { grid-template-columns: 1fr 1fr; }
            .left  { padding: 28px; }
            .left-h { font-size: 28px; }
            .left-sub { font-size: 12px; }
            .lst-n { font-size: 18px; }
            .right { padding: 28px 24px; }
            .form-wrap { max-width: 320px; }
            .form-title { font-size: 22px; }
        }

        /* ─── MOBILE (≤767px) ─── */
        @media(max-width: 767px) {
            body { grid-template-columns: 1fr; overflow: auto; }
            .left  { display: none; }
            .right { min-height: 100svh; padding: 32px 24px; align-items: flex-start; padding-top: 64px; }
            .form-wrap { max-width: 100%; }
        }
    </style>
</head>
<body>

{{-- LEFT PANEL --}}
<div class="left">
    <div class="left-top">
        <div class="left-logo">
            <div class="left-logo-icon">
                <img src="/logo.png" alt="SAWARGI" style="width:28px;height:28px;border-radius:8px;object-fit:cover;">
            </div>
            <span class="left-logo-name">SAWARGI</span>
        </div>
    </div>

    <div class="left-bottom">
        <div class="left-tag">
            <div class="left-dot"></div>
            <span class="left-tag-txt">Sistem Aktif · PPK Ormawa 2025</span>
        </div>
        <h1 class="left-h">
            Pantau Desa,<br>Lindungi Warga.
            <span>Sistem IoT Early Warning & Irigasi Otomatis</span>
        </h1>
        <p class="left-sub">Dashboard admin untuk memantau kondisi lereng, curah hujan, dan sistem irigasi Desa Nagrakjaya secara real-time.</p>
        <div class="left-stats">
            <div class="lst">
                <div class="lst-n">3.200</div>
                <div class="lst-l">Jiwa Terlindungi</div>
            </div>
            <div class="lst">
                <div class="lst-n">3</div>
                <div class="lst-l">Tiang Sensor TX</div>
            </div>
            <div class="lst">
                <div class="lst-n">24/7</div>
                <div class="lst-l">Monitoring</div>
            </div>
        </div>
    </div>
</div>

{{-- RIGHT PANEL --}}
<div class="right">
    <div class="right-bg"></div>
    <div class="form-wrap">

        <div class="form-header">
            <div class="form-eyebrow">Admin Access</div>
            <div class="form-title">Masuk ke<br>Dashboard</div>
            <div class="form-sub">Khusus petugas dan admin yang berwenang</div>
        </div>

        @if($errors->any())
        <div class="error-box">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            {{-- Username --}}
            <div class="fg">
                <label class="fg-label">Username</label>
                <div class="fg-input-wrap">
                    <span class="fg-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </span>
                    <input type="text" name="username" class="fg-input"
                        placeholder="Masukkan username"
                        value="{{ old('username') }}" autocomplete="username" required>
                </div>
            </div>

            {{-- Password --}}
            <div class="fg" style="margin-bottom:24px">
                <label class="fg-label">Password</label>
                <div class="fg-input-wrap">
                    <span class="fg-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    </span>
                    <input type="password" name="password" class="fg-input" id="pwInput"
                        placeholder="Masukkan password" autocomplete="current-password" required>
                    <button type="button" class="pw-toggle" id="pwToggle" tabindex="-1">
                        <svg id="eyeIcon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Masuk ke Dashboard
            </button>
        </form>

        <div class="divider">Akses Sistem</div>

        <div class="info-chips">
            <div class="chip">
                <div class="chip-dot" style="background:var(--safe)"></div>
                SAJAGA — Early Warning
            </div>
            <div class="chip">
                <div class="chip-dot" style="background:var(--blue)"></div>
                SINATRA — Irigasi
            </div>
            <div class="chip">
                <div class="chip-dot" style="background:#e67e22"></div>
                ESP32 Sensor
            </div>
        </div>

        <div class="form-footer">
            SAWARGI · HMIF Universitas Muhammadiyah Sukabumi<br>
            PPK Ormawa 2025 · Desa Nagrakjaya, Warungkiara
        </div>
    </div>
</div>

<script>
    // Show / hide password
    const pwInput  = document.getElementById('pwInput');
    const pwToggle = document.getElementById('pwToggle');
    const eyeIcon  = document.getElementById('eyeIcon');

    pwToggle.addEventListener('click', () => {
        const show = pwInput.type === 'password';
        pwInput.type = show ? 'text' : 'password';
        eyeIcon.innerHTML = show
            ? '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
            : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    });
</script>
</body>
</html>