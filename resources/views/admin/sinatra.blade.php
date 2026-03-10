@extends('layouts.admin')

@section('eyebrow', 'SINATRA')
@section('title', 'Irigasi Otomatis')

@section('styles')
<style>
    .page { padding: 28px; }

    /* ── KPI ── */
    .kpi-grid {
        display: grid; grid-template-columns: repeat(4,1fr);
        gap: 16px; margin-bottom: 24px;
    }
    .kpi-card {
        background: var(--surface); border: 1px solid var(--rule);
        border-radius: var(--r-lg); padding: 18px 20px;
        box-shadow: var(--shadow-sm); position: relative; overflow: hidden;
    }
    .kpi-card::after {
        content: ''; position: absolute;
        top: 0; left: 0; right: 0; height: 2px;
    }
    .kpi-card.c-water::after { background: var(--water); }
    .kpi-card.c-safe::after  { background: var(--safe); }
    .kpi-card.c-blue::after  { background: var(--blue); }
    .kpi-card.c-warn::after  { background: var(--warn); }
    .kpi-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .kpi-ico {
        width: 36px; height: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }
    .c-water .kpi-ico { background: var(--water-bg); color: var(--water); }
    .c-safe  .kpi-ico { background: var(--safe-bg);  color: var(--safe); }
    .c-blue  .kpi-ico { background: var(--blue-l);   color: var(--blue); }
    .c-warn  .kpi-ico { background: var(--warn-bg);  color: var(--warn); }
    .kpi-val   { font-size: 28px; font-weight: 800; letter-spacing: -1px; color: var(--ink); margin-bottom: 4px; }
    .kpi-label { font-size: 12px; color: var(--ink-3); font-weight: 500; }

    /* ── ZONE GRID ── */
    .zone-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 20px; margin-bottom: 24px;
    }
    .zone-card {
        background: var(--surface); border: 1px solid var(--rule);
        border-radius: var(--r-lg); overflow: hidden;
        box-shadow: var(--shadow-sm); transition: box-shadow .2s;
    }
    .zone-card:hover { box-shadow: var(--shadow); }
    .zone-top { height: 4px; }
    .zone-body { padding: 20px 22px; }
    .zone-head { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; }
    .zone-id   { font-family: var(--mono); font-size: 9px; color: var(--ink-4); letter-spacing: 1px; margin-bottom: 4px; }
    .zone-name { font-size: 15px; font-weight: 700; color: var(--ink); margin-bottom: 2px; }
    .zone-pipe { font-size: 11px; color: var(--ink-4); }

    /* Gauge */
    .gauge-wrap {
        display: flex; align-items: center; gap: 20px; margin-bottom: 20px;
    }
    .gauge-svg-wrap { position: relative; width: 100px; height: 100px; flex-shrink: 0; }
    .gauge-svg { transform: rotate(-90deg); }
    .gauge-bg   { fill: none; stroke: var(--surf-3); stroke-width: 8; }
    .gauge-fill { fill: none; stroke-width: 8; stroke-linecap: round; transition: stroke-dashoffset .8s ease; }
    .gauge-center {
        position: absolute; inset: 0;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
    }
    .gauge-pct { font-size: 20px; font-weight: 800; letter-spacing: -1px; color: var(--ink); }
    .gauge-lbl { font-size: 9px; color: var(--ink-4); font-family: var(--mono); }
    .gauge-info { flex: 1; }
    .gi-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 8px 12px; background: var(--surf-2); border-radius: 8px; margin-bottom: 8px;
    }
    .gi-row:last-child { margin-bottom: 0; }
    .gi-label { font-size: 11px; color: var(--ink-3); }
    .gi-val   { font-family: var(--mono); font-size: 12px; font-weight: 600; color: var(--ink); }

    /* Valve indicator */
    .valve-indicator {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 14px; border-radius: var(--r);
        border: 1px solid; margin-bottom: 16px;
    }
    .valve-indicator.open   { background: var(--water-bg); border-color: var(--water-bd); }
    .valve-indicator.closed { background: var(--surf-2);   border-color: var(--rule); }
    .vi-dot {
        width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
    }
    .open   .vi-dot { background: var(--water); animation: pulse-dot 2s ease-in-out infinite; }
    .closed .vi-dot { background: var(--ink-4); }
    .vi-label { font-size: 12px; font-weight: 700; }
    .open   .vi-label { color: var(--water); }
    .closed .vi-label { color: var(--ink-3); }
    .vi-sub { font-size: 11px; color: var(--ink-4); }
    .vi-time { margin-left: auto; font-family: var(--mono); font-size: 10px; color: var(--ink-4); }

    /* Zone empty */
    .zone-empty {
        background: var(--surface); border: 1px dashed var(--rule);
        border-radius: var(--r-lg); padding: 40px 22px;
        text-align: center;
    }

    /* ── BOTTOM GRID ── */
    .bottom-grid { display: grid; grid-template-columns: 1.4fr 1fr; gap: 20px; }

    /* Chart */
    .chart-wrap { height: 220px; position: relative; }

    /* Threshold */
    .th-grid { display: flex; flex-direction: column; }
    .th-row {
        display: flex; gap: 14px; align-items: flex-start;
        padding: 14px 20px; border-bottom: 1px solid var(--rule-2);
    }
    .th-row:last-child { border-bottom: none; }
    .th-bar  { width: 3px; min-height: 48px; border-radius: 4px; flex-shrink: 0; margin-top: 2px; }
    .th-label{ font-size: 13px; font-weight: 700; margin-bottom: 4px; }
    .th-param{ font-family: var(--mono); font-size: 11px; color: var(--ink-3); margin-bottom: 2px; }
    .th-sub  { font-size: 11px; color: var(--ink-4); margin-top: 4px; }
</style>
@endsection

@section('content')
<div class="page">

    {{-- KPI --}}
    @php
        $activeZones = collect($zones)->filter(fn($z) => $z->valve_open)->count();
        $avgLevel    = collect($zones)->avg('level_pct') ?? 0;
        $maxAdc      = collect($zones)->max('adc_raw') ?? 0;
    @endphp
    <div class="kpi-grid">
        <div class="kpi-card c-water">
            <div class="kpi-top">
                <div class="kpi-ico">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
                </div>
            </div>
            <div class="kpi-val">{{ $activeZones }}<span style="font-size:16px;color:var(--ink-4)">/2</span></div>
            <div class="kpi-label">Zona Aktif (Katup Buka)</div>
        </div>
        <div class="kpi-card c-safe">
            <div class="kpi-top">
                <div class="kpi-ico">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                </div>
            </div>
            <div class="kpi-val">{{ count($zones) }}<span style="font-size:16px;color:var(--ink-4)">/2</span></div>
            <div class="kpi-label">Zona Terdeteksi</div>
        </div>
        <div class="kpi-card c-blue">
            <div class="kpi-top">
                <div class="kpi-ico">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
            </div>
            <div class="kpi-val">{{ number_format($avgLevel, 0) }}<span style="font-size:16px;color:var(--ink-4)">%</span></div>
            <div class="kpi-label">Rata-rata Level Air</div>
        </div>
        <div class="kpi-card c-warn">
            <div class="kpi-top">
                <div class="kpi-ico">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
            </div>
            <div class="kpi-val">{{ $maxAdc }}</div>
            <div class="kpi-label">ADC Tertinggi</div>
        </div>
    </div>

    {{-- ZONE CARDS --}}
    <div class="zone-grid">
        @foreach($zoneList as $z)
        @php $zone = collect($zones)->firstWhere('zone_id', $z['id']); @endphp

        @if($zone)
        @php
            $isOpen     = $zone->valve_open;
            $accentColor= $isOpen ? 'var(--water)' : '#e5e7eb';
            $r          = 44; $circ = 2 * M_PI * $r;
            $offset     = $circ - ($zone->level_pct / 100) * $circ;
            $gaugeColor = $isOpen ? '#0284c7' : '#9ca3af';
        @endphp
        <div class="zone-card">
            <div class="zone-top" style="background:{{ $accentColor }}"></div>
            <div class="zone-body">
                <div class="zone-head">
                    <div>
                        <div class="zone-id">{{ $zone->zone_id }}</div>
                        <div class="zone-name">{{ $zone->zone_name }}</div>
                        <div class="zone-pipe">Pipa {{ $z['pipe'] }}</div>
                    </div>
                    <span class="badge badge-{{ $isOpen ? 'buka' : 'tutup' }}">
                        <span class="badge-dot" style="background:currentColor"></span>
                        {{ $isOpen ? 'BUKA' : 'TUTUP' }}
                    </span>
                </div>

                {{-- Gauge --}}
                <div class="gauge-wrap">
                    <div class="gauge-svg-wrap">
                        <svg class="gauge-svg" width="100" height="100" viewBox="0 0 100 100">
                            <circle class="gauge-bg" cx="50" cy="50" r="{{ $r }}"/>
                            <circle class="gauge-fill"
                                cx="50" cy="50" r="{{ $r }}"
                                stroke="{{ $gaugeColor }}"
                                stroke-dasharray="{{ $circ }}"
                                stroke-dashoffset="{{ $offset }}"/>
                        </svg>
                        <div class="gauge-center">
                            <div class="gauge-pct" style="color:{{ $gaugeColor }}">{{ $zone->level_pct }}%</div>
                            <div class="gauge-lbl">LEVEL</div>
                        </div>
                    </div>
                    <div class="gauge-info">
                        <div class="gi-row">
                            <span class="gi-label">ADC Raw</span>
                            <span class="gi-val">{{ $zone->adc_raw }}</span>
                        </div>
                        <div class="gi-row">
                            <span class="gi-label">Status</span>
                            <span class="gi-val">{{ $zone->status }}</span>
                        </div>
                        <div class="gi-row">
                            <span class="gi-label">Update</span>
                            <span class="gi-val" style="font-size:10px">{{ $zone->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                {{-- Valve Indicator --}}
                <div class="valve-indicator {{ $isOpen ? 'open' : 'closed' }}">
                    <div class="vi-dot"></div>
                    <div>
                        <div class="vi-label">{{ $isOpen ? 'Katup Terbuka — Air Mengalir' : 'Katup Tertutup' }}</div>
                        <div class="vi-sub">{{ $isOpen ? 'Irigasi aktif otomatis' : 'Level air di bawah threshold' }}</div>
                    </div>
                    <div class="vi-time">{{ $zone->created_at->format('H:i') }}</div>
                </div>

            </div>
        </div>
        @else
        <div class="zone-empty">
            <div style="font-family:var(--mono);font-size:11px;color:var(--ink-4);margin-bottom:8px">{{ $z['id'] }}</div>
            <div style="font-size:14px;font-weight:700;color:var(--ink-2);margin-bottom:4px">{{ $z['name'] }}</div>
            <div style="font-size:12px;color:var(--ink-4)">Menunggu data sensor...</div>
        </div>
        @endif
        @endforeach
    </div>

    {{-- BOTTOM GRID --}}
    <div class="bottom-grid">

        {{-- Chart --}}
        <div class="card">
            <div class="card-head">
                <div>
                    <div class="card-eyebrow">Historis</div>
                    <div class="card-title">Tren Level Air (10 Data Terakhir)</div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-wrap">
                    <canvas id="sinatraChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Threshold --}}
        <div class="card">
            <div class="card-head">
                <div>
                    <div class="card-eyebrow">Referensi</div>
                    <div class="card-title">Logika Kontrol Katup</div>
                </div>
            </div>
            <div class="th-grid">
                @foreach([
                    ['BUKA',  'var(--water)', 'ADC ≥ 614  (Level ≥ 60%)', 'Katup dibuka otomatis'],
                    ['HOLD',  'var(--warn)',  'ADC 307–613 (Level 30–60%)', 'Pertahankan kondisi saat ini'],
                    ['TUTUP', 'var(--ink-4)', 'ADC ≤ 307  (Level ≤ 30%)', 'Katup ditutup otomatis'],
                ] as [$lbl,$clr,$param,$sub])
                <div class="th-row">
                    <div class="th-bar" style="background:{{ $clr }}"></div>
                    <div>
                        <div class="th-label" style="color:{{ $clr }}">{{ $lbl }}</div>
                        <div class="th-param">{{ $param }}</div>
                        <div class="th-sub">{{ $sub }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

<script>
@php
    $z1 = \App\Models\SinatraReading::where('zone_id','ZONA-1')->latest()->take(10)->get()->reverse()->values();
    $z2 = \App\Models\SinatraReading::where('zone_id','ZONA-2')->latest()->take(10)->get()->reverse()->values();
    $labels = $z1->count() > 0
        ? $z1->map(fn($r) => $r->created_at->format('H:i'))->toArray()
        : array_map(fn($i) => "T-$i", range(10,1));
@endphp

const ctx = document.getElementById('sinatraChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [
            {
                label: 'ZONA-1 Bak Utama',
                data: @json($z1->pluck('level_pct')),
                borderColor: '#0284c7', backgroundColor: 'rgba(2,132,199,.06)',
                borderWidth: 2, pointRadius: 3, pointHoverRadius: 5,
                fill: true, tension: .4,
            },
            {
                label: 'ZONA-2 Bak Sekunder',
                data: @json($z2->pluck('level_pct')),
                borderColor: '#059669', backgroundColor: 'rgba(5,150,105,.06)',
                borderWidth: 2, pointRadius: 3, pointHoverRadius: 5,
                fill: true, tension: .4,
            },
        ]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
            legend: { position:'bottom', labels:{ font:{family:'Plus Jakarta Sans',size:11}, boxWidth:10, padding:14 } },
            tooltip: { mode:'index', intersect:false }
        },
        scales: {
            x: { grid:{display:false}, ticks:{font:{family:'JetBrains Mono',size:10},color:'#9ca3af'} },
            y: {
                min: 0, max: 100,
                grid:{color:'rgba(0,0,0,.04)'},
                ticks:{font:{family:'JetBrains Mono',size:10},color:'#9ca3af',callback: v => v+'%'},
            }
        }
    }
});

setTimeout(() => location.reload(), 15000);
</script>
@endsection