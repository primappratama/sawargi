<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SAWARGI</title>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --font-display: -apple-system, 'SF Pro Display', 'Helvetica Neue', sans-serif;
            --font-body:    -apple-system, 'SF Pro Text',    'Helvetica Neue', sans-serif;
            --blue:   #1a6bff;
            --ink:    #0f1623;
            --ink-2:  #3d4b63;
            --ink-3:  #8a96aa;
            --bg:     #f4f6fb;
            --surface:#ffffff;
            --surf-2: #f7f8fc;
            --rule:   rgba(0,0,0,0.07);
            --danger: #dc2626; --danger-bg: #fef2f2; --danger-bd: rgba(220,38,38,.18);
        }
        body {
            font-family: var(--font-body);
            background: var(--bg);
            min-height: 100svh;
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
            -webkit-font-smoothing: antialiased;
        }
        .bg-orb-1 {
            position: fixed; top: -20%; right: -10%;
            width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(26,107,255,.06), transparent 70%);
            pointer-events: none;
        }
        .bg-orb-2 {
            position: fixed; bottom: -15%; left: -10%;
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(6,182,212,.05), transparent 70%);
            pointer-events: none;
        }
        .wrap { width: 100%; max-width: 400px; position: relative; z-index: 1; }
        .logo-wrap { text-align: center; margin-bottom: 36px; }
        .logo-icon {
            width: 56px; height: 56px; border-radius: 16px;
            background: linear-gradient(135deg, #1a6bff, #06b6d4);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 8px 32px rgba(26,107,255,.3);
        }
        .logo-title {
            font-family: var(--font-display);
            font-size: 26px; font-weight: 800; color: var(--ink);
            letter-spacing: -.5px; margin-bottom: 6px;
        }
        .logo-sub { font-size: 13px; color: var(--ink-3); }
        .card {
            background: var(--surface);
            border: 1px solid var(--rule);
            border-radius: 20px; padding: 32px;
            box-shadow: 0 8px 40px rgba(0,0,0,.08);
        }
        .card-title {
            font-family: var(--font-display);
            font-size: 18px; font-weight: 700; color: var(--ink);
            margin-bottom: 6px; letter-spacing: -.3px;
        }
        .card-sub { font-size: 13px; color: var(--ink-3); margin-bottom: 24px; }
        .form-group { margin-bottom: 16px; }
        .form-label {
            display: block; font-size: 12px; font-weight: 600;
            color: var(--ink-2); margin-bottom: 7px;
        }
        .form-input {
            width: 100%; padding: 11px 14px;
            border: 1.5px solid var(--rule);
            border-radius: 10px; font-size: 14px; color: var(--ink);
            background: var(--surf-2); outline: none;
            font-family: var(--font-body);
            transition: border-color .15s;
        }
        .form-input:focus { border-color: var(--blue); }
        .error-box {
            background: var(--danger-bg); border: 1px solid var(--danger-bd);
            border-left: 3px solid var(--danger);
            border-radius: 9px; padding: 10px 14px;
            font-size: 13px; color: var(--danger);
            margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
        }
        .btn-submit {
            width: 100%; padding: 12px;
            background: var(--blue); color: #fff;
            border: none; border-radius: 10px;
            font-size: 14px; font-weight: 700;
            font-family: var(--font-body);
            cursor: pointer; transition: all .15s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            box-shadow: 0 4px 20px rgba(26,107,255,.35);
        }
        .btn-submit:hover { background: #1558e0; }
        .footer { text-align: center; font-size: 11px; color: var(--ink-3); margin-top: 20px; }
    </style>
</head>
<body>
<div class="bg-orb-1"></div>
<div class="bg-orb-2"></div>

<div class="wrap">
    <div class="logo-wrap">
        <div class="logo-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2"><path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
        </div>
        <div class="logo-title">SAWARGI</div>
        <div class="logo-sub">Admin Dashboard · Desa Nagrakjaya</div>
    </div>

    <div class="card">
        <div class="card-title">Masuk ke Dashboard</div>
        <div class="card-sub">Masukkan kredensial admin untuk melanjutkan</div>

        @if($errors->any())
        <div class="error-box">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-input"
                    placeholder="Masukkan username"
                    value="{{ old('username') }}" required>
            </div>
            <div class="form-group" style="margin-bottom:24px">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input"
                    placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn-submit">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Masuk
            </button>
        </form>
    </div>

    <div class="footer">SAWARGI · HMIF UMMI · PPK Ormawa 2025</div>
</div>
</body>
</html>