<!-- File: resources/views/admin/overview.blade.php -->

@extends('layouts.admin')

@section('eyebrow', 'Dashboard')
@section('title', 'Overview')

@section('styles')
<style>
    .page { padding: 28px; }

    /* ── STATUS BANNER ── */
    .status-banner {
        border-radius: var(--r-xl); padding: 20px 24px;
        display: flex; align-items: center; gap: 20px;
        margin-bottom: 24px; border: 1px solid; position: relative; overflow: hidden;
    }
    .status-banner::before {
        content: ''; position: absolute; top: -40px; right: -40px;
        width: 160px; height: 160px; border-radius: 50%; opacity: .06;
    }
    .status-banner.aman    { background: var(--safe-bg);   border-color: var(--safe-bd); }
    .status-banner.waspada { background: var(--warn-bg);   border-color: var(--warn-bd); }
    .status-banner.bahaya  { background: var(--danger-bg); border-color: var(--danger-bd); }
    .status-banner.aman::before    { background: var(--safe); }
    .status-banner.waspada::before { background: var(--warn); }
    .status-banner.bahaya::before  { background: var(--danger); }
    .sb-icon-wrap {
        width: 48px; height: 48px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .aman    .sb-icon-wrap { background: rgba(5,150,105,.12); }
    .waspada .sb-icon-wrap { background: rgba(217,119,6,.12); }
    .bahaya  .sb-icon-wrap { background: rgba(220,38,38,.12); }
    .sb-info  { flex: 1; }
    .sb-label { font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 3px; }
    .sb-val   { font-size: 22px; font-weight: 800; letter-spacing: -.5px; }
    .sb-desc  { font-size: 13px; color: var(--ink-2); margin-top: 2px; }
    .aman    .sb-label, .aman    .sb-val { color: var(--safe); }
    .waspada .sb-label, .waspada .sb-val { color: var(--warn); }
    .bahaya  .sb-label, .bahaya  .sb-val { color: var(--danger); }
    .sb-time { font-family: var(--mono); font-size: 11px; color: var(--ink-4); }

    /* ── KPI CARDS ── */
    .kpi-grid {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 16px; margin-bottom: 24px;
    }
    .kpi-card {
        background: var(--surface); border: 1px solid var(--rule);
        border-radius: var(--r-lg); padding: 18px 20px;
        box-shadow: var(--shadow-sm); position: relative; overflow: hidden;
    }
    .kpi-card::after {
        content: ''; position: absolute;
        top: 0; left: 0; right: 0; height: 2px; border-radius: 2px 2px 0 0;
    }
    .kpi-card.c-blue::after  { background: var(--blue); }
    .kpi-card.c-safe::after  { background: var(--safe); }
    .kpi-card.c-water::after { background: var(--water); }
    .kpi-card.c-warn::after  { background: var(--warn); }
    .kpi-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px; }
    .kpi-ico {
        width: 36px; height: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }
    .c-blue  .kpi-ico { background: var(--blue-l);  color: var(--blue); }
    .c-safe  .kpi-ico { background: var(--safe-bg); color: var(--safe); }
    .c-water .kpi-ico { background: var(--water-bg);color: var(--water); }
    .c-warn  .kpi-ico { background: var(--warn-bg); color: var(--warn); }
    .kpi-trend {
        font-size: 10px; font-weight: 700; padding: 3px 8px;
        border-radius: 20px; background: var(--surf-2); color: var(--ink-4);
    }
    .kpi-val   { font-size: 30px; font-weight: 800; line-height: 1; letter-spacing: -1px; color: var(--ink); margin-bottom: 4px; }
    .kpi-label { font-size: 12px; color: var(--ink-3); font-weight: 500; }

    /* ── GRID BAWAH ── */
    .bottom-grid { display: grid; grid-template-columns: 1.6fr 1fr; gap: 20px; }
    .left-col  { display: flex; flex-direction: column; gap: 20px; }
    .right-col { display: flex; flex-direction: column; gap: 20px; }

    /* ── NODE TABLE ── */
    .node-table { width: 100%; border-collapse: collapse; }
    .node-table th {
        text-align: left; font-size: 10px; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase; color: var(--ink-4);
        padding: 0 14px 12px; border-bottom: 1px solid var(--rule);
    }
    .node-table td {
        padding: 13px 14px; border-bottom: 1px solid var(--rule-2);
        font-size: 13px; vertical-align: middle;
    }
    .node-table tr:last-child td { border-bottom: none; }
    .node-table tr:hover td { background: var(--surf-2); }
    .nt-node { display: flex; align-items: center; gap: 10px; }
    .nt-dot  { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .nt-name { font-weight: 600; color: var(--ink); font-size: 13px; }
    .nt-id   { font-family: var(--mono); font-size: 10px; color: var(--ink-4); }
    .nt-val  { font-family: var(--mono); font-size: 12px; font-weight: 500; }
    .nt-val.danger { color: var(--danger); }
    .nt-val.warn   { color: var(--warn); }
    .nt-val.safe   { color: var(--safe); }

    /* ── CHART ── */
    .chart-wrap { position: relative; height: 180px; }

    /* ── ZONA IRIGASI ── */
    .zone-item { padding: 14px 20px; border-bottom: 1px solid var(--rule-2); }
    .zone-item:last-child { border-bottom: none; }
    .zi-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
    .zi-name { font-size: 13px; font-weight: 700; color: var(--ink); }
    .zi-id   { font-size: 10px; color: var(--ink-4); font-family: var(--mono); margin-top: 1px; }
    .zi-bar-wrap { height: 6px; background: var(--surf-3); border-radius: 10px; overflow: hidden; }
    .zi-bar  { height: 100%; border-radius: 10px; background: linear-gradient(90deg, #38bdf8, #0284c7); }
    .zi-pct  { text-align: right; font-size: 10px; color: var(--ink-4); font-family: var(--mono); margin-top: 4px; }

    /* ── EVENT LOG ── */
    .event-item { display: flex; gap: 12px; padding: 12px 20px; border-bottom: 1px solid var(--rule-2); }
    .event-item:last-child { border-bottom: none; }
    .ev-dot-wrap { padding-top: 3px; }
    .ev-dot  { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
    .ev-title { font-size: 12px; font-weight: 600; color: var(--ink); margin-bottom: 2px; }
    .ev-desc  { font-size: 11px; color: var(--ink-3); margin-bottom: 3px; }
    .ev-time  { font-size: 10px; color: var(--ink-4); font-family: var(--mono); }
    .empty-state { padding: 32px 20px; text-align: center; color: var(--ink-4); font-size: 13px; }

    /* ── ESP32 METRIC ── */
    .esp-metric-grid { display: grid; grid-template-columns: repeat(5,1fr); gap: 12px; }
    .esp-metric {
        padding: 14px 16px; text-align: center;
        background: var(--surface); border: 1px solid var(--rule);
        border-radius: var(--r-lg);
    }
    .esp-val { font-size: 20px; font-weight: 800; letter-spacing: -1px; line-height: 1; margin-bottom: 6px; }
    .esp-lbl { font-size: 9px; color: var(--ink-4); letter-spacing: 1.5px; text-transform: uppercase; }
    .esp-detail-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 9px 20px; border-bottom: .5px solid var(--rule-2);
    }
    .esp-detail-row:last-child { border-bottom: none; }
    .esp-dl { font-size: 11px; color: var(--ink-3); }
    .esp-dv { font-family: var(--mono); font-size: 11px; font-weight: 600; color: var(--ink-2); }
</style>
@endsection

@section('content')
<div class="page">

    {{-- STATUS BANNER --}}
    @php
        $statusDesc = [
            'AMAN'    => 'Semua parameter dalam batas normal. Tidak ada ancaman terdeteksi.',
            'WASPADA' => 'Parameter mendekati batas kritis. Tingkatkan pemantauan.',
            'BAHAYA'  => 'Parameter melebihi batas kritis! Segera ambil tindakan darurat.',
        ];
    @endphp
    <div class="status-banner {{ strtolower($overallStatus) }}">
        <div class="sb-icon-wrap">
            @if($overallStatus === 'AMAN')
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--safe)" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            @elseif($overallStatus === 'WASPADA')
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--warn)" stroke-width="2.2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            @else
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--danger)" stroke-width="2.2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
            @endif
        </div>
        <div class="sb-info">
            <div class="sb-label">Status Sistem Keseluruhan</div>
            <div class="sb-val">{{ $overallStatus }}</div>
            <div class="sb-desc">{{ $statusDesc[$overallStatus] }}</div>
        </div>
        <div>
            <span class="badge badge-{{ strtolower($overallStatus) }}">
                <span class="badge-dot" style="background:currentColor;animation:pulse-dot 2s ease-in-out infinite"></span>
                {{ $overallStatus }}
            </span>
            <div class="sb-time" style="margin-top:8px;text-align:right" id="sb-time"></div>
        </div>
    </div>

    {{-- KPI CARDS --}}
    <div class="kpi-grid">
        <div class="kpi-card c-safe">
            <div class="kpi-top">
                <div class="kpi-ico">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.22 1.22 2 2 0 012.22 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.09"/></svg>
                </div>
                <span class="kpi-trend">TX Nodes</span>
            </div>
            <div class="kpi-val">{{ count($sajagaNodes) }}<span style="font-size:16px;color:var(--ink-4)">/3</span></div>
            <div class="kpi-label">Node TX Online</div>
        </div>

        <div class="kpi-card c-warn">
            <div class="kpi-top">
                <div class="kpi-ico">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                </div>
                <span class="kpi-trend">SAJAGA</span>
            </div>
            <div class="kpi-val" style="{{ $activeAlerts > 0 ? 'color:var(--warn)' : '' }}">{{ $activeAlerts }}</div>
            <div class="kpi-label">Alert Aktif</div>
        </div>

        <div class="kpi-card c-water">
            <div class="kpi-top">
                <div class="kpi-ico">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
                </div>
                <span class="kpi-trend">SINATRA</span>
            </div>
            <div class="kpi-val">{{ collect($sinatraZones)->filter(fn($z) => $z->valve_open)->count() }}<span style="font-size:16px;color:var(--ink-4)">/2</span></div>
            <div class="kpi-label">Zona Irigasi Aktif</div>
        </div>

        <div class="kpi-card c-blue">
            <div class="kpi-top">
                <div class="kpi-ico">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <span class="kpi-trend">System</span>
            </div>
            <div class="kpi-val">{{ $recentEvents->count() }}</div>
            <div class="kpi-label">Event Log Terbaru</div>
        </div>
    </div>

    {{-- BOTTOM GRID --}}
    <div class="bottom-grid">
        <div class="left-col">

            {{-- Node Status Table --}}
            <div class="card">
                <div class="card-head">
                    <div>
                        <div class="card-eyebrow">SAJAGA</div>
                        <div class="card-title">Status Tiang Sensor TX</div>
                    </div>
                    <a href="{{ route('admin.sajaga') }}" class="card-action">
                        Lihat Detail
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                </div>
                <div class="card-body" style="padding:0">
                    @if(count($sajagaNodes) > 0)
                    <table class="node-table">
                        <thead>
                            <tr>
                                <th>Node</th>
                                <th>Kemiringan</th>
                                <th>Hujan</th>
                                <th>Kelembaban</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sajagaNodes as $node)
                            @php
                                $dotColor  = $node->status === 'BAHAYA' ? 'var(--danger)' : ($node->status === 'WASPADA' ? 'var(--warn)' : 'var(--safe)');
                                $tiltClass = $node->tilt_angle > 2.0   ? 'danger' : ($node->tilt_angle >= 0.5 ? 'warn' : 'safe');
                                $rainClass = $node->rainfall > 70      ? 'danger' : ($node->rainfall >= 20   ? 'warn' : 'safe');
                                $soilClass = $node->soil_moist > 80    ? 'danger' : ($node->soil_moist >= 50 ? 'warn' : 'safe');
                            @endphp
                            <tr>
                                <td>
                                    <div class="nt-node">
                                        <div class="nt-dot" style="background:{{ $dotColor }}"></div>
                                        <div>
                                            <div class="nt-name">{{ $node->node_name }}</div>
                                            <div class="nt-id">{{ $node->node_id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="nt-val {{ $tiltClass }}">{{ number_format($node->tilt_angle,2) }}°</span></td>
                                <td><span class="nt-val {{ $rainClass }}">{{ $node->rainfall }} mm</span></td>
                                <td><span class="nt-val {{ $soilClass }}">{{ $node->soil_moist }}%</span></td>
                                <td>
                                    <span class="badge badge-{{ strtolower($node->status) }}">
                                        <span class="badge-dot" style="background:currentColor"></span>
                                        {{ $node->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state">Belum ada data — menunggu tiang TX...</div>
                    @endif
                </div>
            </div>

            {{-- Chart Tilt --}}
            <div class="card">
                <div class="card-head">
                    <div>
                        <div class="card-eyebrow">Historis</div>
                        <div class="card-title">Kemiringan Tanah (10 Data Terakhir)</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-wrap">
                        <canvas id="tiltChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <div class="right-col">

            {{-- SINATRA --}}
            <div class="card">
                <div class="card-head">
                    <div>
                        <div class="card-eyebrow">SINATRA</div>
                        <div class="card-title">Zona Irigasi</div>
                    </div>
                    <a href="{{ route('admin.sinatra') }}" class="card-action">
                        Detail
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                </div>
                @forelse($sinatraZones as $zone)
                <div class="zone-item">
                    <div class="zi-header">
                        <div>
                            <div class="zi-name">{{ $zone->zone_name }}</div>
                            <div class="zi-id">{{ $zone->zone_id }}</div>
                        </div>
                        <span class="badge badge-{{ $zone->valve_open ? 'buka' : 'tutup' }}">
                            <span class="badge-dot" style="background:currentColor"></span>
                            {{ $zone->valve_open ? 'BUKA' : 'TUTUP' }}
                        </span>
                    </div>
                    <div class="zi-bar-wrap">
                        <div class="zi-bar" style="width:{{ $zone->level_pct }}%"></div>
                    </div>
                    <div class="zi-pct">{{ $zone->level_pct }}%</div>
                </div>
                @empty
                <div class="empty-state">Menunggu data irigasi...</div>
                @endforelse
            </div>

            {{-- Event Log --}}
            <div class="card">
                <div class="card-head">
                    <div>
                        <div class="card-eyebrow">Log</div>
                        <div class="card-title">Event Terbaru</div>
                    </div>
                </div>
                @forelse($recentEvents as $event)
                @php $evColor = $event->severity === 'DANGER' ? 'var(--danger)' : ($event->severity === 'WARNING' ? 'var(--warn)' : 'var(--water)'); @endphp
                <div class="event-item">
                    <div class="ev-dot-wrap"><div class="ev-dot" style="background:{{ $evColor }}"></div></div>
                    <div style="flex:1">
                        <div class="ev-title">{{ $event->title }}</div>
                        <div class="ev-desc">{{ $event->description }}</div>
                        <div class="ev-time">{{ $event->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                @empty
                <div class="empty-state">Tidak ada event tercatat</div>
                @endforelse
            </div>

        </div>
    </div>

    {{-- ESP32 SENSOR SECTION --}}
    @if($latestSensor)
    @php
        $espClass = match($esp32Status) {
            'WASPADA'                         => 'waspada',
            'BAHAYA', 'SANGAT BAHAYA'        => 'bahaya',
            default                           => 'aman'
        };
        $rain     = $latestSensor->rainfall;
        $rainInfo = match(true) {
            $rain == 0  => ['CERAH',        '#0ea5e9', 'rgba(14,165,233,.08)'],
            $rain <= 5  => ['HUJAN RINGAN',  '#3b82f6', 'rgba(59,130,246,.08)'],
            $rain <= 20 => ['HUJAN SEDANG',  '#2563eb', 'rgba(37,99,235,.08)'],
            default     => ['HUJAN LEBAT',   '#1d4ed8', 'rgba(29,78,216,.08)'],
        };
    @endphp

    <div style="margin-top:24px">
        {{-- Section Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
            <div>
                <div style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--blue);margin-bottom:3px">SAJAGA — ESP32</div>
                <div style="font-size:16px;font-weight:700;color:var(--ink)">Data Sensor Lapangan Real-time</div>
            </div>
            <div style="display:flex;align-items:center;gap:8px">
                <div style="width:7px;height:7px;border-radius:50%;background:var(--safe);animation:pulse-dot 2s ease-in-out infinite"></div>
                <span style="font-family:var(--mono);font-size:11px;color:var(--ink-4)">Update: {{ $latestSensor->created_at->diffForHumans() }}</span>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1.6fr 1fr;gap:20px">

            {{-- Kiri: Metrics + Chart --}}
            <div style="display:flex;flex-direction:column;gap:16px">

                {{-- 5 Metric Cards --}}
                <div class="esp-metric-grid">
                    <div class="esp-metric" style="border-top:2px solid #e74c3c">
                        <div class="esp-val" style="color:#e74c3c">{{ number_format($latestSensor->gyro_x,2) }}<span style="font-size:12px">°</span></div>
                        <div class="esp-lbl">Roll (X)</div>
                    </div>
                    <div class="esp-metric" style="border-top:2px solid #2ecc71">
                        <div class="esp-val" style="color:#2ecc71">{{ number_format($latestSensor->gyro_y,2) }}<span style="font-size:12px">°</span></div>
                        <div class="esp-lbl">Pitch (Y)</div>
                    </div>
                    <div class="esp-metric" style="border-top:2px solid var(--water)">
                        <div class="esp-val" style="color:var(--water)">{{ $latestSensor->soil_moisture }}<span style="font-size:12px">%</span></div>
                        <div class="esp-lbl">Kelembaban</div>
                    </div>
                    <div class="esp-metric" style="border-top:2px solid #e67e22">
                        <div class="esp-val" style="color:#e67e22">{{ number_format($latestSensor->suhu,1) }}<span style="font-size:12px">°C</span></div>
                        <div class="esp-lbl">Suhu</div>
                    </div>
                    <div class="esp-metric" style="border-top:2px solid {{ $rainInfo[1] }};background:{{ $rainInfo[2] }}">
                        <div class="esp-val" style="color:{{ $rainInfo[1] }}">{{ $rain }}<span style="font-size:12px">mm</span></div>
                        <div class="esp-lbl">{{ $rainInfo[0] }}</div>
                    </div>
                </div>

                {{-- Chart Roll & Pitch --}}
                <div class="card">
                    <div class="card-head">
                        <div>
                            <div class="card-eyebrow">Historis ESP32</div>
                            <div class="card-title">Pergeseran Tanah — Roll &amp; Pitch (15 Data)</div>
                        </div>
                        <span style="font-size:10px;font-weight:600;padding:3px 9px;border-radius:20px;background:var(--blue-l);color:var(--blue)">LIVE</span>
                    </div>
                    <div class="card-body">
                        <div style="position:relative;height:160px">
                            <canvas id="esp32Chart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Kanan: Status + Detail --}}
            <div style="display:flex;flex-direction:column;gap:16px">

                {{-- Status Banner ESP32 --}}
                <div class="status-banner {{ $espClass }}" style="margin-bottom:0">
                    <div class="sb-icon-wrap">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="{{ $espClass==='aman'?'var(--safe)':($espClass==='waspada'?'var(--warn)':'var(--danger)') }}"
                            stroke-width="2.2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <div class="sb-info">
                        <div class="sb-label">Status ESP32</div>
                        <div class="sb-val">{{ $esp32Status }}</div>
                        <div class="sb-desc" style="font-size:11px">Record #{{ $latestSensor->id }}</div>
                    </div>
                    <span class="badge badge-{{ $espClass }}">
                        <span class="badge-dot" style="background:currentColor;animation:pulse-dot 2s ease-in-out infinite"></span>
                        LIVE
                    </span>
                </div>

                {{-- Detail Sensor --}}
                <div class="card" style="padding:0">
                    <div style="padding:12px 20px;border-bottom:1px solid var(--rule)">
                        <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--ink-4)">Detail Sensor Raw</div>
                    </div>
                    @foreach([
                        ['Gyro X',       number_format($latestSensor->gyro_x,4).'°'],
                        ['Gyro Y',       number_format($latestSensor->gyro_y,4).'°'],
                        ['Gyro Z',       number_format($latestSensor->gyro_z,4).'°'],
                        ['Soil Moisture',$latestSensor->soil_moisture.'%'],
                        ['Suhu',         number_format($latestSensor->suhu,1).'°C'],
                        ['Curah Hujan',  $rain.' mm'],
                        ['Kondisi',      $rainInfo[0]],
                        ['Latitude',     $latestSensor->latitude],
                        ['Longitude',    $latestSensor->longitude],
                    ] as [$l,$v])
                    <div class="esp-detail-row">
                        <span class="esp-dl">{{ $l }}</span>
                        <span class="esp-dv">{{ $v }}</span>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    @else
    <div class="card" style="margin-top:24px;text-align:center;padding:40px">
        <div style="font-size:28px;margin-bottom:8px">📡</div>
        <div style="font-weight:600;color:var(--ink)">Menunggu data sensor ESP32...</div>
        <div style="font-size:12px;color:var(--ink-4);margin-top:4px">Pastikan perangkat sudah terhubung ke jaringan</div>
    </div>
    @endif

</div>

<script>
    // Clock
    function tickSb() {
        const n = new Date(), p = v => String(v).padStart(2,'0');
        const el = document.getElementById('sb-time');
        if(el) el.textContent = `${p(n.getDate())}/${p(n.getMonth()+1)}/${n.getFullYear()} ${p(n.getHours())}:${p(n.getMinutes())}`;
    }
    tickSb(); setInterval(tickSb, 60000);

    // Chart Tilt (Node-RED)
    @php
        $tx01   = \App\Models\SajagaReading::where('node_id','TX-01')->latest()->take(10)->get()->reverse()->values();
        $tx02   = \App\Models\SajagaReading::where('node_id','TX-02')->latest()->take(10)->get()->reverse()->values();
        $tx03   = \App\Models\SajagaReading::where('node_id','TX-03')->latest()->take(10)->get()->reverse()->values();
        $labels = $tx01->count() > 0
            ? $tx01->map(fn($r) => $r->created_at->format('H:i'))->toArray()
            : array_map(fn($i) => "T-$i", range(10,1));
    @endphp
    new Chart(document.getElementById('tiltChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [
                { label:'TX-01 Lereng Nagrak', data:@json($tx01->pluck('tilt_angle')->toArray()), borderColor:'#2563eb', backgroundColor:'rgba(37,99,235,.06)', borderWidth:2, pointRadius:3, fill:true, tension:.4 },
                { label:'TX-02 Talagaherang',  data:@json($tx02->pluck('tilt_angle')->toArray()), borderColor:'#059669', backgroundColor:'rgba(5,150,105,.06)',  borderWidth:2, pointRadius:3, fill:true, tension:.4 },
                { label:'TX-03 Bojongsawah',   data:@json($tx03->pluck('tilt_angle')->toArray()), borderColor:'#d97706', backgroundColor:'rgba(217,119,6,.06)',  borderWidth:2, pointRadius:3, fill:true, tension:.4 },
            ]
        },
        options: {
            responsive:true, maintainAspectRatio:false,
            plugins: { legend:{ position:'bottom', labels:{ font:{ family:'Plus Jakarta Sans', size:11 }, boxWidth:10, padding:16 } }, tooltip:{ mode:'index', intersect:false } },
            scales: {
                x:{ grid:{ display:false }, ticks:{ font:{ family:'JetBrains Mono', size:10 }, color:'#9ca3af' } },
                y:{ grid:{ color:'rgba(0,0,0,.04)' }, ticks:{ font:{ family:'JetBrains Mono', size:10 }, color:'#9ca3af' }, title:{ display:true, text:'Kemiringan (°)', font:{ size:10 }, color:'#9ca3af' } }
            }
        }
    });

    // Chart ESP32
    @if(isset($sensorHistory) && $sensorHistory->count() > 0)
    const esp32Ctx = document.getElementById('esp32Chart');
    if(esp32Ctx) {
        new Chart(esp32Ctx.getContext('2d'), {
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
                plugins:{ legend:{ position:'bottom', labels:{ font:{ family:'Plus Jakarta Sans', size:11 }, boxWidth:10, padding:16 } } },
                scales:{
                    y:{ grid:{ color:'rgba(0,0,0,.04)' }, ticks:{ font:{ family:'JetBrains Mono', size:10 }, color:'#9ca3af', callback: v => v+'°' } },
                    x:{ grid:{ display:false }, ticks:{ font:{ family:'JetBrains Mono', size:10 }, color:'#9ca3af', maxTicksLimit:6 } }
                }
            }
        });
    }
    @endif

    setTimeout(() => location.reload(), 15000);
</script>
@endsection