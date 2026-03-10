<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAWARGI — Desa Nagrakjaya</title>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --font-display: -apple-system, 'SF Pro Display', 'Helvetica Neue', sans-serif;
            --font-body:    -apple-system, 'SF Pro Text',    'Helvetica Neue', sans-serif;
            --font-mono:    'SF Mono', ui-monospace, monospace;
            --safe:   #059669; --safe-bg:   #ecfdf5; --safe-bd:   rgba(5,150,105,.2);
            --warn:   #d97706; --warn-bg:   #fffbeb; --warn-bd:   rgba(217,119,6,.2);
            --danger: #dc2626; --danger-bg: #fef2f2; --danger-bd: rgba(220,38,38,.18);
            --water:  #0284c7; --water-bg:  #e0f2fe; --water-bd:  rgba(2,132,199,.2);
            --blue:   #1a6bff;
            --ink:    #0f1623; --ink-2: #3d4b63; --ink-3: #8a96aa;
            --surface:#ffffff; --surf-2: #f7f8fc; --surf-3: #f0f2f8;
            --rule:   rgba(0,0,0,0.07);
        }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font-body); color: var(--ink); -webkit-font-smoothing: antialiased; }
        a { text-decoration: none; color: inherit; }

        /* ── NAVBAR ── */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 900;
            height: 62px; display: flex; align-items: center; justify-content: space-between;
            padding: 0 40px;
            transition: all .35s;
        }
        .navbar.scrolled {
            background: rgba(6,8,15,.92);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,.07);
        }
        .nb-brand { display: flex; align-items: center; gap: 10px; }
        .nb-logo {
            width: 30px; height: 30px; border-radius: 8px;
            background: linear-gradient(135deg,#1a6bff,#06b6d4);
            display: flex; align-items: center; justify-content: center;
        }
        .nb-title { font-family: var(--font-display); font-size: 14px; font-weight: 800; color: #fff; letter-spacing: -.3px; }
        .nb-sub { font-size: 9px; color: rgba(255,255,255,.45); margin-top: 1px; }
        .nb-links { display: flex; gap: 4px; }
        .nb-link {
            padding: 6px 13px; border-radius: 8px;
            font-size: 12px; font-weight: 500; color: rgba(255,255,255,.7);
            transition: color .15s;
        }
        .nb-link:hover { color: #fff; }
        .nb-right { display: flex; align-items: center; gap: 12px; }
        .nb-live {
            display: flex; align-items: center; gap: 6px;
            background: rgba(5,150,105,.2); border: 1px solid rgba(5,150,105,.35);
            border-radius: 20px; padding: 4px 11px;
            font-size: 11px; font-weight: 600; color: #34d399;
        }
        .nb-live-dot { width: 5px; height: 5px; border-radius: 50%; background: #34d399; }
        .nb-admin {
            padding: 7px 16px; border-radius: 9px;
            background: #1a6bff; color: #fff;
            font-size: 12px; font-weight: 600;
            box-shadow: 0 4px 16px rgba(26,107,255,.4);
        }

        /* ── HERO ── */
        .hero {
            min-height: 100svh; position: relative; overflow: hidden;
            display: flex; flex-direction: column; justify-content: flex-end;
            background: linear-gradient(160deg,#060810 0%,#0a1628 50%,#080d1a 100%);
        }
        .hero-orb-1 {
            position: absolute; top: 15%; left: 20%;
            width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle,rgba(26,107,255,.12),transparent 70%);
            pointer-events: none;
        }
        .hero-orb-2 {
            position: absolute; bottom: 20%; right: 15%;
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle,rgba(6,182,212,.08),transparent 70%);
            pointer-events: none;
        }
        .hero-svg { position: absolute; bottom: 0; left: 0; width: 100%; }
        .hero-content { position: relative; z-index: 1; padding: 0 80px 80px; max-width: 900px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            border-radius: 20px; padding: 6px 14px; margin-bottom: 28px;
            font-size: 12px; font-weight: 600; border: 1px solid;
        }
        .hero-badge.aman    { background: rgba(5,150,105,.15);  border-color: rgba(5,150,105,.3);  color: #34d399; }
        .hero-badge.waspada { background: rgba(217,119,6,.15);  border-color: rgba(217,119,6,.3);  color: #fbbf24; }
        .hero-badge.bahaya  { background: rgba(220,38,38,.15);  border-color: rgba(220,38,38,.3);  color: #f87171; }
        .hero-h1 {
            font-family: var(--font-display);
            font-size: clamp(42px,6vw,72px); font-weight: 900; line-height: 1.05;
            letter-spacing: -2px; margin-bottom: 20px;
        }
        .hero-h1 .line1 {
            background: linear-gradient(90deg,#a8c4ff,#e0eaff);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            display: block;
        }
        .hero-h1 .line2 {
            background: linear-gradient(90deg,#1a6bff,#06b6d4);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            display: block;
        }
        .hero-desc {
            font-size: 16px; color: rgba(255,255,255,.5);
            line-height: 1.7; max-width: 520px; margin-bottom: 36px;
        }
        .hero-btns { display: flex; gap: 12px; margin-bottom: 48px; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: #1a6bff; color: #fff;
            padding: 13px 24px; border-radius: 12px;
            font-size: 14px; font-weight: 700;
            box-shadow: 0 8px 32px rgba(26,107,255,.45);
            transition: all .15s;
        }
        .btn-primary:hover { background: #1558e0; }
        .btn-secondary {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.07); color: rgba(255,255,255,.8);
            border: 1px solid rgba(255,255,255,.12);
            padding: 13px 24px; border-radius: 12px;
            font-size: 14px; font-weight: 600; transition: all .15s;
        }
        .btn-secondary:hover { background: rgba(255,255,255,.12); }
        .hero-stats {
            display: flex; gap: 32px;
            padding-top: 28px; border-top: 1px solid rgba(255,255,255,.08);
        }
        .hs-val {
            font-family: var(--font-display); font-size: 20px; font-weight: 800;
            color: #fff; letter-spacing: -.5px;
        }
        .hs-label { font-size: 11px; color: rgba(255,255,255,.4); margin-top: 2px; }

        /* ── SECTIONS ── */
        .section { padding: 80px 0; }
        .section-inner { max-width: 1100px; margin: 0 auto; padding: 0 40px; }
        .sec-eyebrow {
            font-size: 10px; font-weight: 700; letter-spacing: 2.5px;
            text-transform: uppercase; color: var(--blue); margin-bottom: 10px;
        }
        .sec-h2 {
            font-family: var(--font-display);
            font-size: 36px; font-weight: 800; color: var(--ink);
            letter-spacing: -.8px; margin-bottom: 40px;
        }
        .sec-h2 em { font-style: normal; color: var(--blue); }

        /* ── STATUS SECTION ── */
        .status-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 24px; }
        .status-main {
            border-radius: 20px; padding: 28px;
            border: 1px solid; border-left: 4px solid;
        }
        .status-main.aman    { background: var(--safe-bg);   border-color: var(--safe-bd);   border-left-color: var(--safe); }
        .status-main.waspada { background: var(--warn-bg);   border-color: var(--warn-bd);   border-left-color: var(--warn); }
        .status-main.bahaya  { background: var(--danger-bg); border-color: var(--danger-bd); border-left-color: var(--danger); }
        .sm-label { font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 4px; }
        .sm-val { font-family: var(--font-display); font-size: 32px; font-weight: 900; letter-spacing: -1px; }
        .aman    .sm-label, .aman    .sm-val { color: var(--safe); }
        .waspada .sm-label, .waspada .sm-val { color: var(--warn); }
        .bahaya  .sm-label, .bahaya  .sm-val { color: var(--danger); }
        .sm-desc { font-size: 14px; color: var(--ink-2); line-height: 1.6; margin: 12px 0 20px; }

        /* Node mini cards */
        .node-mini-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 10px; }
        .node-mini {
            background: #fff; border-radius: 10px; padding: 10px 14px;
            border: 1px solid;
        }
        .nm-top { display: flex; justify-content: space-between; margin-bottom: 6px; }
        .nm-id { font-family: var(--font-mono); font-size: 10px; color: var(--ink-3); }
        .nm-status { font-size: 10px; font-weight: 700; }
        .nm-name { font-size: 11px; color: var(--ink-2); margin-bottom: 4px; }
        .nm-vals { font-family: var(--font-mono); font-size: 10px; color: var(--ink-3); }

        /* Irigasi side */
        .ir-side { display: flex; flex-direction: column; gap: 16px; }
        .ir-side-title { font-size: 14px; font-weight: 700; color: var(--ink); margin-bottom: 4px; }
        .ir-zone {
            background: var(--surf-2); border: 1px solid var(--rule);
            border-radius: 14px; padding: 16px 18px;
        }
        .irz-header { display: flex; justify-content: space-between; margin-bottom: 12px; }
        .irz-name { font-size: 13px; font-weight: 600; color: var(--ink); }
        .irz-sub  { font-size: 11px; color: var(--ink-3); }
        .irz-flow { display: flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; }
        .ir-bar-wrap { height: 6px; background: var(--water-bg); border-radius: 10px; overflow: hidden; }
        .ir-bar { height: 100%; border-radius: 10px; background: linear-gradient(90deg,#7dd3fc,#0284c7); }
        .ir-pct { font-size: 10px; color: var(--ink-3); text-align: right; margin-top: 5px; }

        /* Badge inline */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            border-radius: 20px; padding: 3px 10px;
            font-size: 10px; font-weight: 700; border: 1px solid;
        }
        .badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
        .badge-aman    { color: var(--safe);   background: var(--safe-bg);   border-color: var(--safe-bd); }
        .badge-waspada { color: var(--warn);   background: var(--warn-bg);   border-color: var(--warn-bd); }
        .badge-bahaya  { color: var(--danger); background: var(--danger-bg); border-color: var(--danger-bd); }
        .badge-buka    { color: var(--water);  background: var(--water-bg);  border-color: var(--water-bd); }
        .badge-tutup   { color: var(--ink-3);  background: var(--surf-3);    border-color: var(--rule); }

        /* ── PANDUAN ── */
        .pan-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
        .pan-card {
            border-radius: 16px; padding: 24px 22px;
            border-top: 3px solid; border: 1px solid;
        }
        .pan-card.aman    { background: var(--safe-bg);   border-color: var(--safe-bd);   border-top-color: var(--safe); }
        .pan-card.waspada { background: var(--warn-bg);   border-color: var(--warn-bd);   border-top-color: var(--warn); }
        .pan-card.bahaya  { background: var(--danger-bg); border-color: var(--danger-bd); border-top-color: var(--danger); }
        .pan-header { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
        .pan-title { font-family: var(--font-display); font-size: 18px; font-weight: 800; }
        .aman    .pan-title { color: var(--safe); }
        .waspada .pan-title { color: var(--warn); }
        .bahaya  .pan-title { color: var(--danger); }
        .pan-section-title {
            font-size: 11px; font-weight: 700; letter-spacing: 1px;
            text-transform: uppercase; color: var(--ink-3); margin-bottom: 8px;
        }
        .pan-criteria { font-size: 12px; color: var(--ink-2); padding-left: 12px; border-left: 2px solid; margin-bottom: 4px; }
        .pan-action { font-size: 12px; margin-bottom: 4px; }
        .aman    .pan-criteria { border-color: rgba(5,150,105,.3); }
        .waspada .pan-criteria { border-color: rgba(217,119,6,.3); }
        .bahaya  .pan-criteria { border-color: rgba(220,38,38,.3); }
        .bahaya  .pan-action { color: var(--danger); font-weight: 700; }

        /* ── FOOTER ── */
        .footer {
            background: var(--surf-3); border-top: 1px solid var(--rule);
            padding: 32px 40px;
        }
        .footer-inner {
            max-width: 1100px; margin: 0 auto;
            display: flex; justify-content: space-between; align-items: center;
        }
        .footer-brand { font-family: var(--font-display); font-size: 15px; font-weight: 800; color: var(--ink); margin-bottom: 4px; }
        .footer-sub { font-size: 12px; color: var(--ink-3); }
        .darurat-card {
            background: var(--danger); color: #fff;
            border-radius: 12px; padding: 12px 20px; text-align: center;
        }
        .darurat-label { font-size: 10px; font-weight: 700; letter-spacing: 1px; margin-bottom: 2px; }
        .darurat-num { font-size: 20px; font-weight: 900; letter-spacing: -.5px; color: #fff; }

        @media(max-width:900px) {
            .navbar { padding: 0 20px; }
            .nb-links { display: none; }
            .hero-content { padding: 0 20px 60px; }
            .hero-stats { flex-wrap: wrap; gap: 20px; }
            .section-inner { padding: 0 20px; }
            .status-grid, .pan-grid { grid-template-columns: 1fr; }
            .node-mini-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar" id="navbar">
    <div class="nb-brand">
        <div class="nb-logo">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.4"><path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
        </div>
        <div>
            <div class="nb-title">SAWARGI</div>
            <div class="nb-sub">Desa Nagrakjaya</div>
        </div>
    </div>
    <div class="nb-links">
        <a href="#profil"  class="nb-link">Profil Desa</a>
        <a href="#status"  class="nb-link">Status Live</a>
        <a href="#irigasi" class="nb-link">Irigasi</a>
        <a href="#panduan" class="nb-link">Panduan</a>
    </div>
    <div class="nb-right">
        <span id="nb-clock" style="font-family:var(--font-mono);font-size:11px;color:rgba(255,255,255,.4)"></span>
        <div class="nb-live"><span class="nb-live-dot"></span> Live</div>
        <a href="/login" class="nb-admin">Admin</a>
    </div>
</nav>

{{-- HERO --}}
@php
    $overall = 'AMAN';
    foreach($sajagaNodes as $node) {
        if($node->status === 'BAHAYA')  { $overall = 'BAHAYA';  break; }
        if($node->status === 'WASPADA') { $overall = 'WASPADA'; }
    }
    $alertNode = collect($sajagaNodes)->first(fn($n) => $n->status !== 'AMAN');
    $heroStatusDesc = $alertNode
        ? "Status SAJAGA: {$overall} — {$alertNode->node_id} · Kemiringan {$alertNode->tilt_angle}°"
        : "Status SAJAGA: {$overall} — Semua Parameter Normal";
    $statusDesc = [
        'AMAN'    => 'Semua parameter normal. Tidak ada ancaman terdeteksi.',
        'WASPADA' => 'Satu atau lebih parameter mendekati batas kritis. Tetap waspada.',
        'BAHAYA'  => 'Parameter kritis terlampaui. Segera lakukan evakuasi!',
    ];
@endphp
<section class="hero">
    <div class="hero-orb-1"></div>
    <div class="hero-orb-2"></div>
    <svg class="hero-svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
        <path d="M0,200 C200,120 400,260 600,180 C800,100 1000,240 1200,160 L1440,140 L1440,320 L0,320 Z" fill="rgba(26,107,255,.06)"/>
        <path d="M0,240 C300,160 500,280 720,220 C940,160 1100,260 1440,200 L1440,320 L0,320 Z" fill="rgba(6,182,212,.05)"/>
        <path d="M0,280 C200,260 400,300 600,272 C800,244 1100,290 1440,260 L1440,320 L0,320 Z" fill="rgba(255,255,255,.02)"/>
    </svg>
    <div class="hero-content">
        <div class="hero-badge {{ strtolower($overall) }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            {{ $heroStatusDesc }}
        </div>
        <h1 class="hero-h1">
            <span class="line1">Monitoring Bencana</span>
            <span class="line2">Nagrakjaya</span>
        </h1>
        <p class="hero-desc">
            Sistem pemantauan longsor dan irigasi otomatis berbasis IoT untuk Desa Nagrakjaya — real-time, 24/7, otonom.
        </p>
        <div class="hero-btns">
            <a href="#status" class="btn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Pantau Status Live
            </a>
            <a href="#profil" class="btn-secondary">
                Pelajari Program
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>
        <div class="hero-stats">
            <div><div class="hs-val">±3.200</div><div class="hs-label">Jiwa Terlindungi</div></div>
            <div><div class="hs-val">1.847 ha</div><div class="hs-label">Area Pertanian</div></div>
            <div><div class="hs-val">3 Node</div><div class="hs-label">Tiang Sensor TX</div></div>
            <div><div class="hs-val" style="color:{{ $overall === 'AMAN' ? '#34d399' : ($overall === 'WASPADA' ? '#fbbf24' : '#f87171') }}">{{ $overall }}</div><div class="hs-label">Status Saat Ini</div></div>
        </div>
    </div>
</section>

{{-- STATUS --}}
<section class="section" id="status" style="background:#fff">
    <div class="section-inner">
        <div class="sec-eyebrow">Status Realtime</div>
        <h2 class="sec-h2">Kondisi <em>Saat Ini</em></h2>
        <div class="status-grid">
            <div class="status-main {{ strtolower($overall) }}">
                <div class="sm-label">Status Keseluruhan</div>
                <div class="sm-val">{{ $overall }}</div>
                <p class="sm-desc">{{ $statusDesc[$overall] }}</p>
                <div class="node-mini-grid">
                    @forelse($sajagaNodes as $node)
                    @php
                        $nc = $node->status === 'BAHAYA' ? 'var(--danger)' : ($node->status === 'WASPADA' ? 'var(--warn)' : 'var(--safe)');
                    @endphp
                    <div class="node-mini" style="border-color:{{ $nc }}33">
                        <div class="nm-top">
                            <span class="nm-id">{{ $node->node_id }}</span>
                            <span class="nm-status" style="color:{{ $nc }}">{{ $node->status }}</span>
                        </div>
                        <div class="nm-name">{{ $node->node_name }}</div>
                        <div class="nm-vals">{{ number_format($node->tilt_angle,2) }}° · {{ $node->rainfall }}mm · {{ $node->soil_moist }}%</div>
                    </div>
                    @empty
                    <div style="grid-column:1/-1;text-align:center;padding:24px;color:var(--ink-3);font-size:13px">
                        Menunggu data dari tiang sensor...
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Irigasi side --}}
            <div class="ir-side" id="irigasi">
                <div class="ir-side-title">Status Irigasi</div>
                @forelse($sinatraZones as $zone)
                <div class="ir-zone">
                    <div class="irz-header">
                        <div>
                            <div class="irz-name">{{ $zone->zone_name }}</div>
                            <div class="irz-sub">{{ $zone->zone_id }}</div>
                        </div>
                        <span class="badge badge-{{ $zone->valve_open ? 'buka' : 'tutup' }}">
                            <span class="badge-dot" style="background:currentColor"></span>
                            {{ $zone->valve_open ? 'MENGALIR' : 'TERTUTUP' }}
                        </span>
                    </div>
                    <div class="ir-bar-wrap">
                        <div class="ir-bar" style="width:{{ $zone->level_pct }}%"></div>
                    </div>
                    <div class="ir-pct">Level: {{ $zone->level_pct }}%</div>
                </div>
                @empty
                <div style="padding:24px;text-align:center;color:var(--ink-3);font-size:13px;background:var(--surf-2);border-radius:14px">
                    Menunggu data irigasi...
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- PANDUAN --}}
<section class="section" id="panduan" style="background:var(--surf-2)">
    <div class="section-inner">
        <div class="sec-eyebrow">Panduan</div>
        <h2 class="sec-h2">Apa yang Harus <em>Dilakukan?</em></h2>
        <div class="pan-grid">
            @foreach([
                [
                    'status'   => 'aman',
                    'label'    => 'AMAN',
                    'criteria' => ['Kemiringan < 0.5°', 'Hujan < 20 mm/hari', 'Kelembaban < 50%'],
                    'actions'  => ['Aktivitas pertanian normal', 'Pantau informasi berkala', 'Tidak ada evakuasi'],
                ],
                [
                    'status'   => 'waspada',
                    'label'    => 'WASPADA',
                    'criteria' => ['Kemiringan 0.5°–2.0°', 'Hujan 20–70 mm/hari', 'Kelembaban 50%–80%'],
                    'actions'  => ['Kurangi aktivitas di lereng', 'Siapkan tas siaga bencana', 'Pantau info tiap 30 menit'],
                ],
                [
                    'status'   => 'bahaya',
                    'label'    => 'BAHAYA',
                    'criteria' => ['Kemiringan > 2.0°', 'Hujan > 70 mm/hari', 'Kelembaban > 80%'],
                    'actions'  => ['SEGERA EVAKUASI ke titik kumpul', 'Hubungi BPBD: 119', 'Jangan kembali tanpa izin'],
                ],
            ] as $g)
            <div class="pan-card {{ $g['status'] }}">
                <div class="pan-header">
                    @if($g['status'] === 'aman')
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--safe)" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    @elseif($g['status'] === 'waspada')
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--warn)" stroke-width="2.2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    @else
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--danger)" stroke-width="2.2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
                    @endif
                    <span class="pan-title">{{ $g['label'] }}</span>
                </div>
                <div class="pan-section-title">Kondisi</div>
                @foreach($g['criteria'] as $c)
                <div class="pan-criteria">{{ $c }}</div>
                @endforeach
                <div class="pan-section-title" style="margin-top:14px">Tindakan</div>
                @foreach($g['actions'] as $a)
                <div class="pan-action">• {{ $a }}</div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="footer">
    <div class="footer-inner">
        <div>
            <div class="footer-brand">SAWARGI</div>
            <div class="footer-sub">HMIF UMMI · PPK Ormawa 2025 · Desa Nagrakjaya</div>
        </div>
        <div class="darurat-card">
            <div class="darurat-label">DARURAT BENCANA</div>
            <a href="tel:112" class="darurat-num">112</a>
        </div>
    </div>
</footer>

<script>
    // Clock
    function tick() {
        const n = new Date(), p = v => String(v).padStart(2,'0');
        const el = document.getElementById('nb-clock');
        if(el) el.textContent = `${p(n.getHours())}:${p(n.getMinutes())}:${p(n.getSeconds())}`;
    }
    tick(); setInterval(tick, 1000);

    // Navbar scroll
    window.addEventListener('scroll', () => {
        document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 10);
    });

    // Auto refresh tiap 30 detik
    setTimeout(() => location.reload(), 30000);
</script>
</body>
</html>