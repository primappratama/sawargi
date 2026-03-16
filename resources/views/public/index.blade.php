<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAWARGI — Desa Nagrakjaya</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --font: -apple-system, 'SF Pro Display', 'SF Pro Text', 'Helvetica Neue', sans-serif;
            --mono: 'SF Mono', ui-monospace, monospace;
            --blue:  #1a6bff; --blue2: #1354d4; --cyan: #06b6d4;
            --ink:   #1d1d1f; --ink2: #3d3d3f; --ink3: #6e6e73; --ink4: #a1a1a6;
            --bg:    #f5f5f7; --white: #ffffff; --surf: #fbfbfd; --rule: rgba(0,0,0,.06);
            --safe:   #059669; --safe-bg:  #ecfdf5; --safe-bd:  rgba(5,150,105,.2);
            --warn:   #d97706; --warn-bg:  #fffbeb; --warn-bd:  rgba(217,119,6,.2);
            --danger: #dc2626; --danger-bg:#fef2f2; --danger-bd:rgba(220,38,38,.2);
            --water:  #0284c7; --water-bg: #f0f9ff; --water-bd: rgba(2,132,199,.2);
        }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font); background: var(--bg); color: var(--ink); -webkit-font-smoothing: antialiased; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }

        /* NAV */
        .nav {
            position: fixed; inset: 0 0 auto; z-index: 200; height: 52px;
            display: flex; align-items: center; justify-content: space-between; padding: 0 24px;
            transition: background .4s, backdrop-filter .4s;
        }
        .nav.solid { background: rgba(255,255,255,.85); backdrop-filter: saturate(180%) blur(20px); border-bottom: .5px solid rgba(0,0,0,.12); }
        .nav-brand { display: flex; align-items: center; gap: 9px; }
        .nav-logo  { width: 28px; height: 28px; border-radius: 8px; display: grid; place-items: center; overflow: hidden; }
        .nav-name  { font-size: 14px; font-weight: 700; letter-spacing: -.2px; transition: color .3s; }
        .nav:not(.solid) .nav-name { color: #fff; }
        .nav.solid        .nav-name { color: var(--ink); }
        .nav-links { display: flex; gap: 0; }
        .nav-link  { padding: 6px 14px; border-radius: 7px; font-size: 12px; font-weight: 500; transition: all .2s; }
        .nav:not(.solid) .nav-link { color: rgba(255,255,255,.8); }
        .nav:not(.solid) .nav-link:hover { color: #fff; background: rgba(255,255,255,.1); }
        .nav.solid .nav-link { color: var(--ink3); }
        .nav.solid .nav-link:hover { background: var(--bg); color: var(--ink); }

        /* HERO */
        .hero {
            height: 100svh; position: relative;
            display: flex; flex-direction: column; justify-content: flex-end;
            background-image:
                linear-gradient(to bottom, rgba(0,0,0,.15) 0%, rgba(0,0,0,.05) 35%, rgba(0,0,0,.5) 70%, rgba(0,0,0,.82) 100%),
                url('{{ asset('nagrakjaya.png') }}');
            background-size: cover; background-position: center 40%; background-attachment: fixed;
        }
        .hero::after { content:''; position:absolute; inset:0; z-index:0; background:radial-gradient(ellipse 120% 100% at 50% 100%,rgba(0,0,0,.25),transparent 60%); pointer-events:none; }
        .hero-body { position:relative; z-index:1; max-width:1000px; margin:0; padding:0 60px 80px; }

        .loc-chip { display:inline-flex; align-items:center; gap:7px; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.2); backdrop-filter:blur(12px); border-radius:20px; padding:5px 13px; margin-bottom:22px; opacity:0; animation:rise .6s .1s ease forwards; }
        .loc-dot  { width:5px; height:5px; border-radius:50%; background:#34d399; animation:blink 2s ease-in-out infinite; }
        .loc-txt  { font-size:11px; font-weight:600; letter-spacing:1px; text-transform:uppercase; color:rgba(255,255,255,.85); }
        @keyframes blink { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.7)} }

        .hero-h { font-size:clamp(52px,7vw,96px); font-weight:900; line-height:1.02; letter-spacing:-3px; margin-bottom:20px; opacity:0; animation:rise .8s .2s ease forwards; }
        .hero-h .l1 { display:block; color:#fff; }
        .hero-h .l2 { display:block; color:rgba(255,255,255,.5); font-weight:500; font-size:.22em; letter-spacing:.5px; margin-top:8px; }
        .hero-sub  { font-size:16px; font-weight:400; line-height:1.6; color:rgba(255,255,255,.55); max-width:420px; margin-bottom:36px; opacity:0; animation:rise .8s .34s ease forwards; }

        .hero-actions { display:flex; align-items:center; gap:12px; margin-bottom:56px; opacity:0; animation:rise .8s .46s ease forwards; }
        .btn-p { display:flex; align-items:center; gap:8px; padding:13px 26px; border-radius:980px; background:#fff; color:var(--ink); font-size:14px; font-weight:700; box-shadow:0 4px 20px rgba(0,0,0,.25); transition:all .2s; }
        .btn-p:hover { transform:scale(1.03); }
        .btn-s { display:flex; align-items:center; gap:7px; padding:13px 22px; border-radius:980px; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.25); backdrop-filter:blur(10px); color:rgba(255,255,255,.9); font-size:14px; font-weight:500; transition:all .2s; }
        .btn-s:hover { background:rgba(255,255,255,.22); }

        .hero-kpi { display:inline-flex; gap:0; padding:20px 24px; background:rgba(255,255,255,.1); backdrop-filter:blur(20px) saturate(180%); border:1px solid rgba(255,255,255,.18); border-radius:20px; opacity:0; animation:rise .8s .58s ease forwards; }
        .kpi { flex:1; padding:0 24px; border-right:1px solid rgba(255,255,255,.12); }
        .kpi:first-child { padding-left:0; } .kpi:last-child { border:none; padding-right:0; }
        .kpi-n { font-size:26px; font-weight:800; letter-spacing:-.8px; color:#fff; line-height:1; margin-bottom:4px; }
        .kpi-l { font-size:10px; color:rgba(255,255,255,.4); letter-spacing:1px; text-transform:uppercase; }

        .scroll-arrow { position:absolute; bottom:24px; left:50%; transform:translateX(-50%); z-index:1; display:flex; flex-direction:column; align-items:center; gap:6px; opacity:0; animation:rise .6s 1.2s ease forwards; }
        .sa-txt  { font-size:9px; letter-spacing:2px; text-transform:uppercase; color:rgba(255,255,255,.3); }
        .sa-icon { animation:bob 2s ease-in-out infinite; }
        @keyframes bob  { 0%,100%{transform:translateY(0)} 50%{transform:translateY(5px)} }
        @keyframes rise { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:none} }

        /* ALERT BAR */
        .alert-bar { position:sticky; top:52px; z-index:150; padding:12px 24px; display:flex; align-items:center; justify-content:center; gap:12px; }
        .alert-bar.aman    { background:var(--safe); }
        .alert-bar.waspada { background:var(--warn); }
        .alert-bar.bahaya  { background:var(--danger); animation:dflash 1.5s ease-in-out infinite; }
        @keyframes dflash { 0%,100%{opacity:1} 50%{opacity:.85} }
        .ab-dot  { width:8px; height:8px; border-radius:50%; background:rgba(255,255,255,.7); animation:blink 2s ease-in-out infinite; }
        .ab-txt  { font-size:13px; font-weight:700; color:#fff; }
        .ab-link { margin-left:8px; font-size:12px; font-weight:600; color:rgba(255,255,255,.8); text-decoration:underline; text-underline-offset:2px; }
        .ab-link:hover { color:#fff; }

        /* REVEAL */
        .rv { opacity:0; transform:translateY(22px); transition:opacity .65s cubic-bezier(.4,0,.2,1),transform .65s cubic-bezier(.4,0,.2,1); }
        .rv.on { opacity:1; transform:none; }
        .d1{transition-delay:.08s} .d2{transition-delay:.17s} .d3{transition-delay:.26s} .d4{transition-delay:.35s}

        /* SECTIONS */
        .sec { padding:96px 0; }
        .sec.grey  { background:var(--bg); }
        .sec.white { background:var(--white); }
        .sec-in    { max-width:980px; margin:0 auto; padding:0 40px; }
        .sec-hd    { text-align:center; margin-bottom:56px; }
        .sec-eyebrow { font-size:11px; font-weight:600; letter-spacing:2px; text-transform:uppercase; color:var(--blue); margin-bottom:10px; }
        .sec-title   { font-size:clamp(28px,3.5vw,44px); font-weight:800; letter-spacing:-1px; color:var(--ink); line-height:1.1; }
        .sec-title em { font-style:normal; color:var(--blue); }
        .sec-sub     { font-size:16px; color:var(--ink3); margin-top:10px; }

        /* STATUS BANNER */
        .status-banner { border-radius:24px; padding:32px 36px; margin-bottom:20px; position:relative; overflow:hidden; box-shadow:0 4px 32px rgba(0,0,0,.06); }
        .status-banner.aman    { background:linear-gradient(135deg,#f0fdf4,#dcfce7); border:1px solid var(--safe-bd); }
        .status-banner.waspada { background:linear-gradient(135deg,#fffbeb,#fef3c7); border:1px solid var(--warn-bd); }
        .status-banner.bahaya  { background:linear-gradient(135deg,#fff1f2,#ffe4e6); border:1px solid var(--danger-bd); }
        .sb-ghost { position:absolute; right:28px; top:50%; transform:translateY(-50%); font-size:108px; font-weight:900; letter-spacing:-3px; opacity:.055; pointer-events:none; line-height:1; }
        .aman    .sb-ghost { color:var(--safe); } .waspada .sb-ghost { color:var(--warn); } .bahaya .sb-ghost { color:var(--danger); }
        .sb-inner { display:flex; align-items:center; gap:22px; }
        .sb-ring  { width:60px; height:60px; border-radius:50%; display:grid; place-items:center; position:relative; flex-shrink:0; }
        .aman    .sb-ring { background:rgba(5,150,105,.12); } .waspada .sb-ring { background:rgba(217,119,6,.12); } .bahaya .sb-ring { background:rgba(220,38,38,.12); }
        .sb-ring::before,.sb-ring::after { content:''; position:absolute; inset:0; border-radius:50%; border:1.5px solid; animation:rp 2.5s ease-out infinite; }
        .sb-ring::after { animation-delay:.9s; }
        .aman    .sb-ring::before,.aman    .sb-ring::after { border-color:var(--safe); }
        .waspada .sb-ring::before,.waspada .sb-ring::after { border-color:var(--warn); }
        .bahaya  .sb-ring::before,.bahaya  .sb-ring::after { border-color:var(--danger); }
        @keyframes rp { to{transform:scale(2.3);opacity:0} }
        .sb-core { width:22px; height:22px; border-radius:50%; z-index:1; }
        .aman    .sb-core { background:var(--safe);   box-shadow:0 0 14px rgba(5,150,105,.5); }
        .waspada .sb-core { background:var(--warn);   box-shadow:0 0 14px rgba(217,119,6,.5); }
        .bahaya  .sb-core { background:var(--danger); box-shadow:0 0 14px rgba(220,38,38,.5); }
        .sb-info  { flex:1; }
        .sb-label { font-size:10px; font-weight:700; letter-spacing:2px; text-transform:uppercase; margin-bottom:5px; }
        .sb-val   { font-size:38px; font-weight:900; letter-spacing:-1.5px; line-height:1; margin-bottom:6px; }
        .sb-desc  { font-size:14px; line-height:1.55; }
        .aman    .sb-label,.aman    .sb-val { color:var(--safe); }
        .waspada .sb-label,.waspada .sb-val { color:var(--warn); }
        .bahaya  .sb-label,.bahaya  .sb-val { color:var(--danger); }
        .aman    .sb-desc { color:#166534; } .waspada .sb-desc { color:#92400e; } .bahaya .sb-desc { color:#991b1b; }
        .sb-badge { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:20px; font-size:11px; font-weight:700; border:1.5px solid; flex-shrink:0; }
        .sb-badge-dot { width:6px; height:6px; border-radius:50%; animation:blink 2s ease-in-out infinite; }
        .aman    .sb-badge { color:var(--safe);   background:rgba(5,150,105,.1);  border-color:var(--safe-bd); }
        .waspada .sb-badge { color:var(--warn);   background:rgba(217,119,6,.1);  border-color:var(--warn-bd); }
        .bahaya  .sb-badge { color:var(--danger); background:rgba(220,38,38,.1);  border-color:var(--danger-bd); }

        /* NODE CARDS */
        .node-row { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; }
        .nc { background:var(--white); border:1px solid var(--rule); border-radius:18px; padding:18px 20px; box-shadow:0 2px 12px rgba(0,0,0,.04); position:relative; overflow:hidden; transition:transform .22s,box-shadow .22s; }
        .nc:hover { transform:translateY(-4px); box-shadow:0 12px 32px rgba(0,0,0,.09); }
        .nc::before { content:''; position:absolute; top:0; left:0; right:0; height:2.5px; }
        .nc.aman::before    { background:var(--safe); }
        .nc.waspada::before { background:var(--warn); }
        .nc.bahaya::before  { background:var(--danger); }
        .nc-head { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:14px; }
        .nc-id   { font-family:var(--mono); font-size:9px; color:var(--ink4); letter-spacing:1.5px; margin-bottom:3px; }
        .nc-name { font-size:13px; font-weight:700; color:var(--ink); }
        .nc-vals { display:flex; flex-direction:column; }
        .nc-row  { display:flex; justify-content:space-between; align-items:center; padding:7px 0; border-bottom:.5px solid var(--rule); }
        .nc-row:last-child { border:none; padding-bottom:0; }
        .nc-lbl  { font-size:11px; color:var(--ink4); }
        .nc-num  { font-family:var(--mono); font-size:12px; font-weight:600; color:var(--ink2); }

        /* BADGE */
        .badge { display:inline-flex; align-items:center; gap:5px; padding:3px 9px; border-radius:20px; font-size:9px; font-weight:700; border:1px solid; }
        .bd    { width:4px; height:4px; border-radius:50%; }
        .b-aman    { color:var(--safe);   background:var(--safe-bg);   border-color:var(--safe-bd); }
        .b-waspada { color:var(--warn);   background:var(--warn-bg);   border-color:var(--warn-bd); }
        .b-bahaya  { color:var(--danger); background:var(--danger-bg); border-color:var(--danger-bd); }
        .b-buka    { color:var(--water);  background:var(--water-bg);  border-color:var(--water-bd); }
        .b-tutup   { color:var(--ink3);   background:var(--bg);        border-color:var(--rule); }

        /* ESP32 METRIC CARDS */
        .metric-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:16px; }
        .metric-card { background:var(--white); border:1px solid var(--rule); border-radius:18px; padding:20px 16px; text-align:center; box-shadow:0 2px 12px rgba(0,0,0,.04); transition:transform .22s,box-shadow .22s; }
        .metric-card:hover { transform:translateY(-4px); box-shadow:0 12px 32px rgba(0,0,0,.09); }
        .metric-val { font-size:30px; font-weight:800; letter-spacing:-1px; line-height:1; margin-bottom:6px; }
        .metric-lbl { font-size:9px; color:var(--ink4); letter-spacing:1.5px; text-transform:uppercase; }

        /* IRIGASI */
        .ir-wrap { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
        .ir-card { background:var(--white); border:1px solid var(--rule); border-radius:20px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.04); transition:transform .22s,box-shadow .22s; }
        .ir-card:hover { transform:translateY(-4px); box-shadow:0 12px 32px rgba(0,0,0,.09); }
        .ir-top-bar { height:3px; background:linear-gradient(90deg,var(--blue),var(--cyan)); }
        .ir-body { padding:22px 24px; }
        .ir-head { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; }
        .ir-id  { font-family:var(--mono); font-size:9px; color:var(--ink4); letter-spacing:1.5px; margin-bottom:4px; }
        .ir-nm  { font-size:15px; font-weight:700; color:var(--ink); }
        .ir-row { display:flex; align-items:center; gap:20px; }
        .g-wrap { position:relative; flex-shrink:0; }
        .g-svg  { transform:rotate(-90deg); }
        .g-bg   { fill:none; stroke:var(--bg); stroke-width:7; }
        .g-fill { fill:none; stroke-width:7; stroke-linecap:round; transition:stroke-dashoffset 1s ease; }
        .g-mid  { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
        .g-pct  { font-size:17px; font-weight:800; letter-spacing:-1px; }
        .g-lbl  { font-size:7px; color:var(--ink4); font-family:var(--mono); }
        .ir-stats { flex:1; display:flex; flex-direction:column; gap:8px; }
        .is-row { display:flex; justify-content:space-between; padding:7px 10px; background:var(--bg); border-radius:9px; }
        .is-l   { font-size:11px; color:var(--ink3); }
        .is-v   { font-family:var(--mono); font-size:11px; font-weight:600; color:var(--ink2); }

        /* PANDUAN */
        .pan-row { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; }
        .pan { background:var(--white); border:1px solid var(--rule); border-radius:20px; padding:26px 22px; box-shadow:0 2px 12px rgba(0,0,0,.04); position:relative; overflow:hidden; transition:transform .22s,box-shadow .22s; }
        .pan:hover { transform:translateY(-5px); box-shadow:0 16px 40px rgba(0,0,0,.1); }
        .pan-stripe { height:3px; position:absolute; top:0; left:0; right:0; }
        .pan.aman    .pan-stripe { background:var(--safe); }
        .pan.waspada .pan-stripe { background:var(--warn); }
        .pan.bahaya  .pan-stripe { background:var(--danger); }
        .pan-ghost { position:absolute; bottom:-12px; right:8px; font-size:88px; font-weight:900; opacity:.04; line-height:1; pointer-events:none; }
        .pan.aman    .pan-ghost { color:var(--safe); } .pan.waspada .pan-ghost { color:var(--warn); } .pan.bahaya .pan-ghost { color:var(--danger); }
        .pan-icon  { width:42px; height:42px; border-radius:12px; margin-bottom:14px; display:grid; place-items:center; }
        .pan.aman    .pan-icon { background:var(--safe-bg); } .pan.waspada .pan-icon { background:var(--warn-bg); } .pan.bahaya .pan-icon { background:var(--danger-bg); }
        .pan-title { font-size:20px; font-weight:800; letter-spacing:-.4px; margin-bottom:14px; }
        .pan.aman    .pan-title { color:var(--safe); } .pan.waspada .pan-title { color:var(--warn); } .pan.bahaya .pan-title { color:var(--danger); }
        .pan-div { height:.5px; background:var(--rule); margin:12px 0; }
        .pan-sl  { font-size:9px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--ink4); margin-bottom:7px; }
        .pan-cr  { font-family:var(--mono); font-size:11px; color:var(--ink3); margin-bottom:3px; }
        .pan-act { font-size:12px; color:var(--ink2); margin-bottom:5px; display:flex; gap:8px; align-items:flex-start; }
        .pan-dot { width:4px; height:4px; border-radius:50%; margin-top:5px; flex-shrink:0; }
        .pan.aman    .pan-dot { background:var(--safe); } .pan.waspada .pan-dot { background:var(--warn); } .pan.bahaya .pan-dot { background:var(--danger); }
        .pan.bahaya  .pan-act { font-weight:700; color:var(--danger); }

        /* FOOTER */
        .footer { background:var(--white); border-top:.5px solid var(--rule); padding:40px; }
        .footer-in { max-width:980px; margin:0 auto; display:flex; justify-content:space-between; align-items:center; gap:24px; }
        .f-brand { display:flex; align-items:center; gap:9px; margin-bottom:6px; }
        .f-logo  { width:26px; height:26px; border-radius:7px; display:grid; place-items:center; overflow:hidden; }
        .f-nm    { font-size:14px; font-weight:800; color:var(--ink); }
        .f-sub   { font-size:11px; color:var(--ink4); line-height:1.65; }
        .f-sos   { text-align:center; background:var(--danger-bg); border:1px solid var(--danger-bd); border-radius:16px; padding:14px 26px; flex-shrink:0; }
        .fs-l    { font-size:8px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--danger); margin-bottom:3px; }
        .fs-n    { font-size:26px; font-weight:900; color:var(--danger); }

        /* ─── ULTRAWIDE 34"+ (≥2560px) ─── */
        @media(min-width: 2560px) {
            .hero-body    { max-width: 900px; padding: 0 80px 100px; }
            .hero-h       { font-size: 112px; letter-spacing: -5px; }
            .hero-sub     { font-size: 20px; max-width: 560px; }
            .hero-actions { margin-bottom: 72px; }
            .btn-p,.btn-s { font-size: 16px; padding: 16px 32px; }
            .hero-kpi     { padding: 26px 36px; }
            .kpi-n        { font-size: 34px; }
            .kpi-l        { font-size: 12px; }
            .kpi          { padding: 0 32px; }
            .loc-chip     { padding: 7px 18px; margin-bottom: 28px; }
            .loc-txt      { font-size: 13px; }
            .nav          { height: 64px; padding: 0 48px; }
            .nav-name     { font-size: 17px; }
            .nav-link     { font-size: 15px; padding: 8px 18px; }
            .sec          { padding: 120px 0; }
            .sec-in       { max-width: 1400px; padding: 0 80px; }
            .sec-title    { font-size: 56px; }
            .sec-sub      { font-size: 20px; }
            .sec-eyebrow  { font-size: 13px; }
            .node-row     { grid-template-columns: repeat(3,1fr); gap: 20px; }
            .nc           { padding: 24px 26px; }
            .nc-name      { font-size: 16px; }
            .nc-lbl,.nc-num { font-size: 14px; }
            .status-banner { padding: 40px 48px; }
            .sb-val       { font-size: 52px; }
            .sb-ghost     { font-size: 140px; }
            .sb-ring      { width: 76px; height: 76px; }
            .sb-core      { width: 28px; height: 28px; }
            .ir-wrap      { gap: 24px; }
            .ir-nm        { font-size: 18px; }
            .pan-row      { gap: 20px; }
            .pan          { padding: 32px 28px; }
            .pan-title    { font-size: 26px; }
            .metric-grid  { gap: 18px; }
            .metric-val   { font-size: 38px; }
            .footer       { padding: 56px 80px; }
            .footer-in    { max-width: 1400px; }
            .f-nm         { font-size: 18px; }
            .fs-n         { font-size: 32px; }
            .alert-bar    { padding: 16px 48px; }
            .ab-txt       { font-size: 16px; }
        }

        /* ─── LARGE DESKTOP 24" (1920px–2559px) ─── */
        @media(min-width: 1920px) and (max-width: 2559px) {
            .hero-body    { max-width: 720px; padding: 0 64px 88px; }
            .hero-h       { font-size: 65px; letter-spacing: -4px; }
            .hero-sub     { font-size: 17px; max-width: 480px; }
            .btn-p,.btn-s { font-size: 15px; padding: 14px 28px; }
            .hero-kpi     { padding: 22px 30px; }
            .kpi-n        { font-size: 30px; }
            .kpi          { padding: 0 28px; }
            .nav          { height: 58px; padding: 0 40px; }
            .nav-name     { font-size: 15px; }
            .nav-link     { font-size: 13px; }
            .sec          { padding: 108px 0; }
            .sec-in       { max-width: 1200px; padding: 0 60px; }
            .sec-title    { font-size: 48px; }
            .sb-val       { font-size: 44px; }
            .metric-val   { font-size: 34px; }
        }

        /* ─── STANDARD DESKTOP (1280px–1919px) ─── */
        /* default styles — tidak perlu override */

        /* ─── SMALL LAPTOP (1024px–1279px) ─── */
        @media(max-width: 1279px) {
            .hero-body    { max-width: 520px; padding: 0 48px 72px; }
            .sec-in       { max-width: 900px; }
            .kpi          { padding: 0 16px; }
            .kpi-n        { font-size: 22px; }
        }

        /* ─── TABLET LANDSCAPE (768px–1023px) ─── */
        @media(max-width: 1023px) {
            .nav          { padding: 0 20px; }
            .nav-links    { display: none; }
            .hero-body    { max-width: 100%; padding: 0 32px 64px; }
            .hero-h       { font-size: clamp(44px,6vw,72px); letter-spacing: -2px; }
            .hero-kpi     { flex-wrap: wrap; gap: 0; }
            .kpi          { flex: none; width: 50%; padding: 12px 20px; border-right: none; border-bottom: 1px solid rgba(255,255,255,.12); }
            .kpi:nth-child(odd)  { border-right: 1px solid rgba(255,255,255,.12); }
            .kpi:nth-child(3),.kpi:nth-child(4) { border-bottom: none; }
            .sec          { padding: 72px 0; }
            .sec-in       { padding: 0 28px; }
            .node-row     { grid-template-columns: repeat(2,1fr); }
            .pan-row      { grid-template-columns: repeat(2,1fr); }
            .metric-grid  { grid-template-columns: repeat(2,1fr); }
            .ir-wrap      { grid-template-columns: 1fr; }
            .footer-in    { flex-direction: column; align-items: flex-start; }
        }

        /* ─── TABLET PORTRAIT (600px–767px) ─── */
        @media(max-width: 767px) {
            .hero-body    { padding: 0 24px 56px; }
            .hero-h       { font-size: clamp(38px,7vw,56px); letter-spacing: -1.5px; }
            .hero-sub     { font-size: 14px; }
            .btn-p,.btn-s { font-size: 13px; padding: 11px 20px; }
            .hero-actions { gap: 8px; margin-bottom: 40px; }
            .hero-kpi     { padding: 16px 18px; }
            .kpi-n        { font-size: 20px; }
            .kpi-l        { font-size: 9px; }
            .sec-title    { font-size: 32px; }
            .sec-sub      { font-size: 14px; }
            .status-banner { padding: 22px 24px; }
            .sb-val       { font-size: 28px; }
            .sb-ghost     { font-size: 80px; }
            .node-row     { grid-template-columns: 1fr 1fr; gap: 10px; }
            .pan-row      { grid-template-columns: 1fr 1fr; }
            .metric-grid  { grid-template-columns: repeat(2,1fr); gap: 10px; }
            .sec-in       { padding: 0 20px; }
            .footer       { padding: 32px 20px; }
        }

        /* ─── MOBILE (≤599px) ─── */
        @media(max-width: 599px) {
            .nav          { height: 48px; padding: 0 16px; }
            .nav-links    { display: none; }
            .hero         { background-attachment: scroll; } /* fix parallax di iOS */
            .hero-body    { padding: 0 20px 48px; }
            .hero-h       { font-size: clamp(34px,9vw,48px); letter-spacing: -1px; }
            .hero-h .l2   { font-size: .28em; }
            .hero-sub     { font-size: 13px; max-width: 100%; }
            .btn-p,.btn-s { font-size: 13px; padding: 11px 18px; border-radius: 980px; }
            .hero-actions { flex-wrap: wrap; gap: 8px; margin-bottom: 32px; }
            .hero-kpi     { padding: 14px 16px; border-radius: 14px; }
            .kpi          { width: 50%; padding: 8px 12px; }
            .kpi-n        { font-size: 18px; }
            .kpi-l        { font-size: 8px; }
            .alert-bar    { padding: 10px 16px; gap: 8px; }
            .ab-txt       { font-size: 11px; }
            .ab-link      { display: none; }
            .sec          { padding: 56px 0; }
            .sec-in       { padding: 0 16px; }
            .sec-title    { font-size: 26px; letter-spacing: -.5px; }
            .sec-sub      { font-size: 13px; }
            .sec-hd       { margin-bottom: 32px; }
            .status-banner { padding: 18px 20px; border-radius: 16px; }
            .sb-ring      { width: 44px; height: 44px; }
            .sb-core      { width: 16px; height: 16px; }
            .sb-val       { font-size: 24px; }
            .sb-ghost     { font-size: 64px; right: 16px; }
            .sb-desc      { font-size: 12px; }
            .sb-badge     { display: none; }
            .node-row     { grid-template-columns: 1fr; gap: 10px; }
            .nc           { padding: 14px 16px; border-radius: 14px; }
            .nc-name      { font-size: 12px; }
            .nc-lbl,.nc-num { font-size: 10px; }
            .ir-wrap      { grid-template-columns: 1fr; }
            .ir-body      { padding: 16px 18px; }
            .ir-nm        { font-size: 14px; }
            .pan-row      { grid-template-columns: 1fr; gap: 12px; }
            .pan          { padding: 20px 18px; }
            .pan-title    { font-size: 18px; }
            .metric-grid  { grid-template-columns: repeat(2,1fr); gap: 10px; }
            .metric-card  { padding: 16px 12px; border-radius: 14px; }
            .metric-val   { font-size: 24px; }
            .metric-lbl   { font-size: 8px; }
            .footer       { padding: 28px 16px; }
            .footer-in    { flex-direction: column; gap: 16px; }
            .f-sos        { width: 100%; }
            .fs-n         { font-size: 22px; }
            .scroll-arrow { display: none; }
        }

        /* ─── MOBILE KECIL (≤380px) ─── */
        @media(max-width: 380px) {
            .hero-h    { font-size: 30px; }
            .btn-s     { display: none; } /* sembunyiin ghost button biar ga crowded */
            .kpi       { width: 50%; }
            .sec-title { font-size: 22px; }
        }
    </style>
</head>
<body>

{{-- NAV --}}
<nav class="nav" id="nav">
    <div class="nav-brand">
        <div class="nav-logo">
            <img src="{{ asset('logo.png') }}" alt="SAWARGI" style="width:28px;height:28px;object-fit:cover;">
        </div>
        <div class="nav-name">SAWARGI</div>
    </div>
    <div class="nav-links">
        <a href="#status"  class="nav-link">Status</a>
        <a href="#sensor"  class="nav-link">Sensor</a>
        <a href="#irigasi" class="nav-link">Irigasi</a>
        <a href="#panduan" class="nav-link">Panduan</a>
    </div>
</nav>

{{-- HERO --}}
@php
    $overall = 'AMAN';
    foreach($sajagaNodes as $n) {
        if($n->status==='BAHAYA'){$overall='BAHAYA';break;}
        if($n->status==='WASPADA') $overall='WASPADA';
    }
    $sColor = $overall==='BAHAYA'?'#f87171':($overall==='WASPADA'?'#fbbf24':'#34d399');
@endphp

<section class="hero">
    <div class="hero-body">
        <div class="loc-chip">
            <div class="loc-dot"></div>
            <span class="loc-txt">Nagrakjaya · Warungkiara · Sukabumi</span>
        </div>
        <h1 class="hero-h">
            <span class="l1">Melindungi Desa,<br>Setiap Saat.</span>
            <span class="l2">Sistem Pemantauan Longsor &amp; Irigasi Otomatis — Real-time 24/7</span>
        </h1>
        <p class="hero-sub">Teknologi IoT yang menjaga ±3.200 jiwa dan 1.847 ha lahan pertanian Desa Nagrakjaya dari ancaman bencana alam.</p>
        <div class="hero-actions">
            <a href="#status" class="btn-p">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Lihat Status Live
            </a>
            <a href="#panduan" class="btn-s">
                Panduan Darurat
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>
        <div class="hero-kpi">
            <div class="kpi">
                <div class="kpi-n"><span class="counter" data-to="3200">0</span></div>
                <div class="kpi-l">Jiwa Terlindungi</div>
            </div>
            <div class="kpi">
                <div class="kpi-n"><span class="counter" data-to="1847">0</span> ha</div>
                <div class="kpi-l">Lahan Pertanian</div>
            </div>
            <div class="kpi">
                <div class="kpi-n">3</div>
                <div class="kpi-l">Tiang Sensor TX</div>
            </div>
            <div class="kpi">
                <div class="kpi-n" style="color:{{ $sColor }}">{{ $overall }}</div>
                <div class="kpi-l">Status Kini</div>
            </div>
        </div>
    </div>
    <div class="scroll-arrow">
        <span class="sa-txt">Scroll</span>
        <svg class="sa-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.4)" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
    </div>
</section>

{{-- ALERT BAR --}}
@php
    $alertMsg = [
        'AMAN'    => '✓ Semua sistem normal — tidak ada ancaman terdeteksi',
        'WASPADA' => '⚠ Waspada — satu atau lebih parameter mendekati batas kritis',
        'BAHAYA'  => '🚨 BAHAYA — Parameter kritis! Segera hubungi BPBD',
    ];
@endphp
<div class="alert-bar {{ strtolower($overall) }}">
    <div class="ab-dot"></div>
    <span class="ab-txt">{{ $alertMsg[$overall] }}</span>
    <a href="#status" class="ab-link">Lihat detail →</a>
</div>

{{-- STATUS --}}
<section class="sec white" id="status">
    <div class="sec-in">
        <div class="sec-hd rv">
            <div class="sec-eyebrow">Monitoring Realtime</div>
            <div class="sec-title">Status <em>Saat Ini</em></div>
            <div class="sec-sub">Data diperbarui otomatis dari tiang sensor setiap beberapa menit</div>
        </div>
        @php
            $desc = [
                'AMAN'    => 'Semua parameter dalam batas normal. Tidak ada ancaman yang terdeteksi.',
                'WASPADA' => 'Satu atau lebih sensor mendekati batas kritis. Harap tingkatkan kewaspadaan.',
                'BAHAYA'  => 'Parameter kritis terlampaui! Segera lakukan evakuasi ke titik kumpul.',
            ];
        @endphp
        <div class="status-banner {{ strtolower($overall) }} rv d1">
            <div class="sb-ghost">{{ $overall }}</div>
            <div class="sb-inner">
                <div class="sb-ring"><div class="sb-core"></div></div>
                <div class="sb-info">
                    <div class="sb-label">Status Keseluruhan Sistem</div>
                    <div class="sb-val">{{ $overall }}</div>
                    <div class="sb-desc">{{ $desc[$overall] }}</div>
                </div>
                <div class="sb-badge">
                    <div class="sb-badge-dot" style="background:currentColor"></div>
                    {{ $overall }}
                </div>
            </div>
        </div>
        <div class="node-row">
            @forelse($sajagaNodes as $node)
            <div class="nc {{ strtolower($node->status) }} rv d{{ $loop->index+1 }}">
                <div class="nc-head">
                    <div>
                        <div class="nc-id">{{ $node->node_id }}</div>
                        <div class="nc-name">{{ $node->node_name }}</div>
                    </div>
                    <span class="badge b-{{ strtolower($node->status) }}">
                        <span class="bd" style="background:currentColor"></span>{{ $node->status }}
                    </span>
                </div>
                <div class="nc-vals">
                    <div class="nc-row"><span class="nc-lbl">Kemiringan</span><span class="nc-num">{{ number_format($node->tilt_angle,2) }}°</span></div>
                    <div class="nc-row"><span class="nc-lbl">Curah Hujan</span><span class="nc-num">{{ $node->rainfall }} mm</span></div>
                    <div class="nc-row"><span class="nc-lbl">Kelembaban</span><span class="nc-num">{{ $node->soil_moist }}%</span></div>
                </div>
            </div>
            @empty
            <div class="nc rv" style="grid-column:1/-1;text-align:center;padding:32px;color:var(--ink4)">Menunggu data sensor...</div>
            @endforelse
        </div>
    </div>
</section>

{{-- SENSOR ESP32 --}}
<section class="sec grey" id="sensor">
    <div class="sec-in">
        <div class="sec-hd rv">
            <div class="sec-eyebrow">SAJAGA — ESP32</div>
            <div class="sec-title">Data <em>Sensor Lapangan</em></div>
            <div class="sec-sub">Pergeseran tanah, kelembaban, suhu &amp; curah hujan real-time</div>
        </div>

        @if($latestSensor)
        @php
            $espClass = match($esp32Status) {
                'WASPADA'       => 'waspada',
                'BAHAYA','SANGAT BAHAYA' => 'bahaya',
                default         => 'aman'
            };
            $rain     = $latestSensor->rainfall;
            $rainInfo = match(true) {
                $rain == 0  => ['CERAH',       '#0ea5e9', '#e0f2fe'],
                $rain <= 5  => ['HUJAN RINGAN', '#3b82f6', '#dbeafe'],
                $rain <= 20 => ['HUJAN SEDANG', '#2563eb', '#bfdbfe'],
                default     => ['HUJAN LEBAT',  '#1d4ed8', '#93c5fd'],
            };
        @endphp

        {{-- Status Banner ESP32 --}}
        <div class="status-banner {{ $espClass }} rv d1">
            <div class="sb-ghost">ESP32</div>
            <div class="sb-inner">
                <div class="sb-ring"><div class="sb-core"></div></div>
                <div class="sb-info">
                    <div class="sb-label">Status Sensor ESP32</div>
                    <div class="sb-val">{{ $esp32Status }}</div>
                    <div class="sb-desc">Update terakhir: {{ $latestSensor->created_at->diffForHumans() }}</div>
                </div>
                <div class="sb-badge">
                    <div class="sb-badge-dot" style="background:currentColor"></div>
                    LIVE
                </div>
            </div>
        </div>

        {{-- 4 Metric Cards --}}
        <div class="metric-grid">
            <div class="metric-card rv d1" style="border-top:3px solid #e74c3c">
                <div class="metric-val" style="color:#e74c3c">{{ number_format($latestSensor->gyro_x,1) }}<span style="font-size:14px">°</span></div>
                <div class="metric-lbl">Roll (X)</div>
            </div>
            <div class="metric-card rv d2" style="border-top:3px solid #2ecc71">
                <div class="metric-val" style="color:#2ecc71">{{ number_format($latestSensor->gyro_y,1) }}<span style="font-size:14px">°</span></div>
                <div class="metric-lbl">Pitch (Y)</div>
            </div>
            <div class="metric-card rv d3" style="border-top:3px solid var(--water)">
                <div class="metric-val" style="color:var(--water)">{{ $latestSensor->soil_moisture }}<span style="font-size:14px">%</span></div>
                <div class="metric-lbl">Kelembaban Tanah</div>
            </div>
            <div class="metric-card rv d4" style="border-top:3px solid #e67e22">
                <div class="metric-val" style="color:#e67e22">{{ number_format($latestSensor->suhu,1) }}<span style="font-size:14px">°C</span></div>
                <div class="metric-lbl">Suhu Lingkungan</div>
            </div>
        </div>

        {{-- Curah Hujan --}}
        <div class="nc rv d2" style="display:flex;align-items:center;justify-content:space-between;padding:20px 24px;margin-bottom:16px">
            <div>
                <div style="font-size:10px;color:var(--ink4);letter-spacing:1.5px;text-transform:uppercase;margin-bottom:4px">Curah Hujan (BMKG Sukabumi)</div>
                <div style="font-size:32px;font-weight:800;letter-spacing:-1px;color:var(--ink)">
                    {{ $rain }} <span style="font-size:14px;font-weight:400;color:var(--ink4)">mm</span>
                </div>
            </div>
            <span style="padding:8px 18px;border-radius:20px;font-size:12px;font-weight:700;color:{{ $rainInfo[1] }};background:{{ $rainInfo[2] }}">
                {{ $rainInfo[0] }}
            </span>
        </div>

        {{-- Chart --}}
        <div class="nc rv d3" style="padding:22px 24px">
            <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--ink4);margin-bottom:16px">
                Grafik Pergeseran — 15 Data Terakhir
            </div>
            <div style="height:180px">
                <canvas id="pubGyroChart"></canvas>
            </div>
        </div>

        @else
        <div class="nc rv" style="text-align:center;padding:48px;color:var(--ink4)">
            <div style="font-size:32px;margin-bottom:8px">📡</div>
            <div style="font-weight:600">Menunggu data dari sensor ESP32...</div>
            <div style="font-size:12px;margin-top:4px">Pastikan perangkat sudah terhubung ke jaringan</div>
        </div>
        @endif
    </div>
</section>

{{-- IRIGASI --}}
<section class="sec white" id="irigasi">
    <div class="sec-in">
        <div class="sec-hd rv">
            <div class="sec-eyebrow">SINATRA</div>
            <div class="sec-title">Irigasi <em>Otomatis</em></div>
            <div class="sec-sub">Kontrol katup berbasis level air real-time</div>
        </div>
        <div class="ir-wrap">
            @forelse($sinatraZones as $zone)
            @php $r=40; $circ=2*M_PI*$r; $off=$circ-($zone->level_pct/100)*$circ; $gc=$zone->valve_open?'var(--water)':'var(--ink4)'; @endphp
            <div class="ir-card rv d{{ $loop->index+1 }}">
                <div class="ir-top-bar"></div>
                <div class="ir-body">
                    <div class="ir-head">
                        <div>
                            <div class="ir-id">{{ $zone->zone_id }}</div>
                            <div class="ir-nm">{{ $zone->zone_name }}</div>
                        </div>
                        <span class="badge b-{{ $zone->valve_open?'buka':'tutup' }}">
                            <span class="bd" style="background:currentColor;{{ $zone->valve_open?'animation:blink 2s ease-in-out infinite':'' }}"></span>
                            {{ $zone->valve_open?'MENGALIR':'TERTUTUP' }}
                        </span>
                    </div>
                    <div class="ir-row">
                        <div class="g-wrap">
                            <svg class="g-svg" width="90" height="90" viewBox="0 0 90 90">
                                <circle class="g-bg" cx="45" cy="45" r="{{ $r }}"/>
                                <circle class="g-fill" cx="45" cy="45" r="{{ $r }}" stroke="{{ $gc }}" stroke-dasharray="{{ $circ }}" stroke-dashoffset="{{ $off }}"/>
                            </svg>
                            <div class="g-mid">
                                <div class="g-pct" style="color:{{ $gc }}">{{ $zone->level_pct }}%</div>
                                <div class="g-lbl">LEVEL</div>
                            </div>
                        </div>
                        <div class="ir-stats">
                            <div class="is-row"><span class="is-l">ADC Raw</span><span class="is-v">{{ $zone->adc_raw }}</span></div>
                            <div class="is-row"><span class="is-l">Katup</span><span class="is-v">{{ $zone->valve_open?'Terbuka':'Tertutup' }}</span></div>
                            <div class="is-row"><span class="is-l">Update</span><span class="is-v" style="font-size:10px">{{ $zone->created_at->diffForHumans() }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="ir-card rv" style="grid-column:1/-1;text-align:center;padding:36px;color:var(--ink4)">Menunggu data...</div>
            @endforelse
        </div>
    </div>
</section>

{{-- PANDUAN --}}
<section class="sec grey" id="panduan">
    <div class="sec-in">
        <div class="sec-hd rv">
            <div class="sec-eyebrow">Panduan Darurat</div>
            <div class="sec-title">Apa yang Harus <em>Dilakukan?</em></div>
            <div class="sec-sub">Tindakan berdasarkan status sistem SAWARGI</div>
        </div>
        <div class="pan-row">
            @foreach([
                ['aman',   'AMAN',   '01','<path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>','var(--safe)',
                    ['Kemiringan < 0.5°','Hujan < 20 mm','Kelembaban < 50%'],
                    ['Aktivitas pertanian normal','Pantau informasi berkala','Tidak perlu evakuasi']],
                ['waspada','WASPADA','02','<path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>','var(--warn)',
                    ['Kemiringan 0.5°–2.0°','Hujan 20–70 mm','Kelembaban 50%–80%'],
                    ['Kurangi aktivitas di lereng','Siapkan tas siaga bencana','Pantau info tiap 30 menit']],
                ['bahaya', 'BAHAYA', '03','<path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>','var(--danger)',
                    ['Kemiringan > 2.0°','Hujan > 70 mm','Kelembaban > 80%'],
                    ['SEGERA evakuasi ke titik kumpul','Hubungi BPBD: 119 / 112','Jangan kembali tanpa izin']],
            ] as $i=>[$st,$lbl,$num,$ico,$clr,$crits,$acts])
            <div class="pan {{ $st }} rv d{{ $i+1 }}">
                <div class="pan-stripe"></div>
                <div class="pan-ghost">{{ $num }}</div>
                <div class="pan-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $clr }}" stroke-width="2.2">{!! $ico !!}</svg>
                </div>
                <div class="pan-title">{{ $lbl }}</div>
                <div class="pan-div"></div>
                <div class="pan-sl">Kondisi</div>
                @foreach($crits as $c)<div class="pan-cr">{{ $c }}</div>@endforeach
                <div class="pan-sl" style="margin-top:10px">Tindakan</div>
                @foreach($acts as $a)
                <div class="pan-act"><div class="pan-dot"></div>{{ $a }}</div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="footer">
    <div class="footer-in">
        <div>
            <div class="f-brand">
                <div class="f-logo">
                    <img src="{{ asset('logo.png') }}" alt="SAWARGI" style="width:26px;height:26px;object-fit:cover;border-radius:7px">
                </div>
                <div class="f-nm">SAWARGI</div>
            </div>
            <div class="f-sub">
                HMIF Universitas Muhammadiyah Sukabumi · PPK Ormawa 2025<br>
                Desa Nagrakjaya, Warungkiara, Sukabumi, Jawa Barat
            </div>
        </div>
        <div class="f-sos">
            <div class="fs-l">Nomor Darurat Bencana</div>
            <a href="tel:112" class="fs-n">112</a>
        </div>
    </div>
</footer>

<script>
// Nav scroll
const nav = document.getElementById('nav');
const chkNav = () => nav.classList.toggle('solid', scrollY > 10);
chkNav(); addEventListener('scroll', chkNav);

// Counter
function countUp(el) {
    const to = +el.dataset.to, dur = 1800, s = performance.now();
    (function f(now) {
        const p = Math.min((now-s)/dur,1), e = 1-Math.pow(1-p,3);
        el.textContent = Math.floor(e*to).toLocaleString('id-ID');
        if(p<1) requestAnimationFrame(f);
    })(s);
}

// Reveal observer
const io = new IntersectionObserver(es => {
    es.forEach(e => { if(e.isIntersecting){ e.target.classList.add('on'); io.unobserve(e.target); } });
}, {threshold:.12});
document.querySelectorAll('.rv').forEach(el => io.observe(el));

// Counter observer
const co = new IntersectionObserver(es => {
    es.forEach(e => { if(e.isIntersecting){ countUp(e.target); co.unobserve(e.target); } });
}, {threshold:.5});
document.querySelectorAll('.counter').forEach(el => co.observe(el));

// Chart ESP32
@if(isset($sensorHistory) && $sensorHistory->count() > 0)
const pubCtx = document.getElementById('pubGyroChart');
if(pubCtx) {
    new Chart(pubCtx.getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! $sensorHistory->map(fn($d) => $d->created_at->format('H:i:s'))->toJson() !!},
            datasets: [
                { label:'Roll (X)', borderColor:'#e74c3c', backgroundColor:'rgba(231,76,60,.05)', data:{!! $sensorHistory->pluck('gyro_x')->toJson() !!}, tension:0.4, fill:true, pointRadius:0, borderWidth:2 },
                { label:'Pitch (Y)', borderColor:'#2ecc71', backgroundColor:'rgba(46,204,113,.05)', data:{!! $sensorHistory->pluck('gyro_y')->toJson() !!}, tension:0.4, fill:true, pointRadius:0, borderWidth:2 }
            ]
        },
        options: {
            responsive:true, maintainAspectRatio:false,
            plugins:{ legend:{ position:'top', labels:{ font:{ size:11 } } } },
            scales:{
                y:{ grid:{ color:'rgba(0,0,0,.04)' }, ticks:{ callback: v => v+'°', font:{ size:10 } } },
                x:{ grid:{ display:false }, ticks:{ maxTicksLimit:6, font:{ size:10 } } }
            }
        }
    });
}
@endif

// Auto reload 30 detik
setTimeout(() => location.reload(), 30000);
</script>
</body>
</html>