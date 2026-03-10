<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAWARGI — @yield('title', 'Dashboard')</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap');

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --font: 'Plus Jakarta Sans', sans-serif;
            --mono: 'JetBrains Mono', monospace;

            --bg:       #f5f6fa;
            --surface:  #ffffff;
            --surf-2:   #f8f9fc;
            --surf-3:   #f0f2f7;
            --rule:     rgba(0,0,0,0.06);
            --rule-2:   rgba(0,0,0,0.04);

            --ink:      #111827;
            --ink-2:    #374151;
            --ink-3:    #6b7280;
            --ink-4:    #9ca3af;

            --blue:     #2563eb;
            --blue-l:   #eff6ff;
            --blue-d:   #1d4ed8;

            --safe:     #059669; --safe-bg: #ecfdf5; --safe-bd: rgba(5,150,105,.15);
            --warn:     #d97706; --warn-bg: #fffbeb; --warn-bd: rgba(217,119,6,.15);
            --danger:   #dc2626; --danger-bg: #fef2f2; --danger-bd: rgba(220,38,38,.15);
            --water:    #0284c7; --water-bg: #f0f9ff; --water-bd: rgba(2,132,199,.15);

            --sidebar-w: 240px;
            --header-h:  64px;

            --r:    12px;
            --r-sm: 8px;
            --r-lg: 16px;
            --r-xl: 20px;

            --shadow-sm: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
            --shadow:    0 4px 16px rgba(0,0,0,.06), 0 1px 4px rgba(0,0,0,.04);
            --shadow-lg: 0 12px 40px rgba(0,0,0,.08), 0 4px 12px rgba(0,0,0,.04);
        }

        html { scroll-behavior: smooth; }
        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
            display: flex;
        }
        a { text-decoration: none; color: inherit; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            height: 100svh;
            position: fixed; top: 0; left: 0; z-index: 100;
            background: var(--surface);
            border-right: 1px solid var(--rule);
            display: flex; flex-direction: column;
            box-shadow: var(--shadow-sm);
        }

        .sb-brand {
            padding: 20px 20px 0;
            display: flex; align-items: center; gap: 10px;
            border-bottom: 1px solid var(--rule);
            padding-bottom: 20px;
            margin-bottom: 8px;
        }
        .sb-logo {
            width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(37,99,235,.3);
        }
        .sb-brand-text { flex: 1; }
        .sb-name { font-size: 15px; font-weight: 800; color: var(--ink); letter-spacing: -.3px; }
        .sb-sub  { font-size: 10px; color: var(--ink-4); margin-top: 1px; }

        .sb-section {
            padding: 0 12px;
            flex: 1;
            overflow-y: auto;
        }
        .sb-section-label {
            font-size: 9px; font-weight: 700; letter-spacing: 2px;
            text-transform: uppercase; color: var(--ink-4);
            padding: 14px 8px 6px;
        }

        .sb-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 10px; border-radius: var(--r-sm);
            font-size: 13px; font-weight: 600; color: var(--ink-3);
            transition: all .15s; margin-bottom: 2px;
            position: relative;
        }
        .sb-link:hover { background: var(--surf-2); color: var(--ink); }
        .sb-link.active {
            background: var(--blue-l); color: var(--blue);
        }
        .sb-link.active .sb-icon { color: var(--blue); }
        .sb-icon {
            width: 32px; height: 32px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            background: var(--surf-2); flex-shrink: 0;
            transition: all .15s;
        }
        .sb-link.active .sb-icon { background: rgba(37,99,235,.1); }
        .sb-link-badge {
            margin-left: auto;
            font-size: 10px; font-weight: 700;
            background: var(--danger); color: #fff;
            border-radius: 20px; padding: 2px 7px;
        }

        .sb-divider { height: 1px; background: var(--rule); margin: 8px 8px; }

        .sb-bottom {
            padding: 16px 12px;
            border-top: 1px solid var(--rule);
        }
        .sb-status-row {
            display: flex; align-items: center; gap: 8px;
            background: var(--surf-2); border: 1px solid var(--rule);
            border-radius: var(--r-sm); padding: 10px 12px;
            margin-bottom: 10px;
        }
        .sb-status-dot {
            width: 8px; height: 8px; border-radius: 50%;
            flex-shrink: 0;
        }
        .sb-status-dot.pulse {
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .5; transform: scale(.85); }
        }
        .sb-status-text { flex: 1; }
        .sb-status-label { font-size: 11px; font-weight: 700; }
        .sb-status-sub   { font-size: 10px; color: var(--ink-4); }
        .sb-logout {
            width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 9px; border-radius: var(--r-sm);
            font-size: 12px; font-weight: 600; color: var(--ink-3);
            background: var(--surf-2); border: 1px solid var(--rule);
            cursor: pointer; font-family: var(--font); transition: all .15s;
        }
        .sb-logout:hover { color: var(--danger); border-color: var(--danger-bd); background: var(--danger-bg); }

        /* ── MAIN ── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1; min-height: 100svh;
            display: flex; flex-direction: column;
        }

        /* ── TOPBAR ── */
        .topbar {
            height: var(--header-h);
            background: var(--surface);
            border-bottom: 1px solid var(--rule);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px;
            position: sticky; top: 0; z-index: 50;
        }
        .tb-left { }
        .tb-page-label { font-size: 10px; font-weight: 600; color: var(--ink-4); letter-spacing: 1px; text-transform: uppercase; }
        .tb-page-title { font-size: 18px; font-weight: 800; color: var(--ink); letter-spacing: -.4px; }
        .tb-right { display: flex; align-items: center; gap: 12px; }
        .tb-live {
            display: flex; align-items: center; gap: 7px;
            background: var(--safe-bg); border: 1px solid var(--safe-bd);
            border-radius: 20px; padding: 5px 13px;
            font-size: 11px; font-weight: 700; color: var(--safe);
        }
        .tb-live-dot {
            width: 6px; height: 6px; border-radius: 50%; background: var(--safe);
            animation: pulse-dot 2s ease-in-out infinite;
        }
        .tb-clock {
            font-family: var(--mono); font-size: 12px; font-weight: 500;
            color: var(--ink-3); background: var(--surf-2);
            border: 1px solid var(--rule); border-radius: var(--r-sm);
            padding: 6px 12px;
        }
        .tb-admin {
            display: flex; align-items: center; gap: 8px;
            background: var(--surf-2); border: 1px solid var(--rule);
            border-radius: var(--r-sm); padding: 6px 12px;
        }
        .tb-avatar {
            width: 26px; height: 26px; border-radius: 50%;
            background: linear-gradient(135deg,#2563eb,#06b6d4);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 700; color: #fff;
        }
        .tb-name { font-size: 12px; font-weight: 600; color: var(--ink-2); }

        /* ── PAGE CONTENT ── */
        .page { padding: 28px; flex: 1; }

        /* ── SHARED COMPONENTS ── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            border-radius: 20px; padding: 3px 10px;
            font-size: 10px; font-weight: 700; border: 1px solid; white-space: nowrap;
        }
        .badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
        .badge-aman    { color: var(--safe);   background: var(--safe-bg);   border-color: var(--safe-bd); }
        .badge-waspada { color: var(--warn);   background: var(--warn-bg);   border-color: var(--warn-bd); }
        .badge-bahaya  { color: var(--danger); background: var(--danger-bg); border-color: var(--danger-bd); }
        .badge-buka    { color: var(--water);  background: var(--water-bg);  border-color: var(--water-bd); }
        .badge-tutup   { color: var(--ink-3);  background: var(--surf-2);    border-color: var(--rule); }
        .badge-online  { color: var(--safe);   background: var(--safe-bg);   border-color: var(--safe-bd); }
        .badge-offline { color: var(--ink-3);  background: var(--surf-2);    border-color: var(--rule); }

        .card {
            background: var(--surface); border: 1px solid var(--rule);
            border-radius: var(--r-lg); box-shadow: var(--shadow-sm);
            overflow: hidden;
        }
        .card-head {
            padding: 16px 20px;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid var(--rule);
        }
        .card-eyebrow { font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--ink-4); margin-bottom: 2px; }
        .card-title   { font-size: 14px; font-weight: 700; color: var(--ink); }
        .card-action  { font-size: 12px; font-weight: 600; color: var(--blue); display: flex; align-items: center; gap: 4px; }
        .card-body    { padding: 20px; }

        @yield('styles')
    </style>
</head>
<body>

{{-- ── SIDEBAR ── --}}
<aside class="sidebar">
    <div class="sb-brand">
        <div class="sb-logo">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2"><path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
        </div>
        <div class="sb-brand-text">
            <div class="sb-name">SAWARGI</div>
            <div class="sb-sub">Nagrakjaya · Admin</div>
        </div>
    </div>

    <div class="sb-section">
        <div class="sb-section-label">Menu Utama</div>

        <a href="{{ route('admin.overview') }}" class="sb-link {{ request()->routeIs('admin.overview') ? 'active' : '' }}">
            <div class="sb-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            </div>
            Overview
        </a>

        <div class="sb-section-label">Sistem</div>

        <a href="{{ route('admin.sajaga') }}" class="sb-link {{ request()->routeIs('admin.sajaga') ? 'active' : '' }}">
            <div class="sb-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            SAJAGA
            @php $alerts = collect(\App\Models\SajagaReading::getLatestPerNode())->where('status','!=','AMAN')->count(); @endphp
            @if($alerts > 0)
            <span class="sb-link-badge">{{ $alerts }}</span>
            @endif
        </a>

        <a href="{{ route('admin.sinatra') }}" class="sb-link {{ request()->routeIs('admin.sinatra') ? 'active' : '' }}">
            <div class="sb-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
            </div>
            SINATRA
        </a>

        <div class="sb-divider"></div>

        <a href="/" target="_blank" class="sb-link">
            <div class="sb-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
            </div>
            Halaman Publik
        </a>
    </div>

    <div class="sb-bottom">
        @php
            $sysStatus = 'AMAN';
            foreach(\App\Models\SajagaReading::getLatestPerNode() as $n) {
                if($n->status === 'BAHAYA')  { $sysStatus = 'BAHAYA';  break; }
                if($n->status === 'WASPADA') { $sysStatus = 'WASPADA'; }
            }
            $dotColor = $sysStatus === 'BAHAYA' ? 'var(--danger)' : ($sysStatus === 'WASPADA' ? 'var(--warn)' : 'var(--safe)');
        @endphp
        <div class="sb-status-row">
            <div class="sb-status-dot pulse" style="background:{{ $dotColor }}"></div>
            <div class="sb-status-text">
                <div class="sb-status-label" style="color:{{ $dotColor }}">{{ $sysStatus }}</div>
                <div class="sb-status-sub">Status Sistem</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="sb-logout">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

{{-- ── MAIN ── --}}
<div class="main">
    <header class="topbar">
        <div class="tb-left">
            <div class="tb-page-label">@yield('eyebrow', 'Dashboard')</div>
            <div class="tb-page-title">@yield('title', 'Overview')</div>
        </div>
        <div class="tb-right">
            <div class="tb-live"><div class="tb-live-dot"></div> Live</div>
            <div class="tb-clock" id="tb-clock">--:--:--</div>
            <div class="tb-admin">
                <div class="tb-avatar">{{ strtoupper(substr(session('admin_name','A'),0,1)) }}</div>
                <span class="tb-name">{{ session('admin_name','Admin') }}</span>
            </div>
        </div>
    </header>

    <div class="page-wrap">
        @yield('content')
    </div>
</div>

<script>
    function tick() {
        const n = new Date(), p = v => String(v).padStart(2,'0');
        document.getElementById('tb-clock').textContent = `${p(n.getHours())}:${p(n.getMinutes())}:${p(n.getSeconds())}`;
    }
    tick(); setInterval(tick, 1000);
</script>
@yield('scripts')
</body>
</html>