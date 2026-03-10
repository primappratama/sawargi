@extends('layouts.admin')

@section('eyebrow', 'SAJAGA')
@section('title', 'Peringatan Dini Longsor')

@section('styles')
<style>
    .page { padding: 28px; }

    /* ── KPI ── */
    .kpi-grid {
        display: grid; grid-template-columns: repeat(3,1fr);
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
    .kpi-card.c-safe::after  { background: var(--safe); }
    .kpi-card.c-warn::after  { background: var(--warn); }
    .kpi-card.c-danger::after{ background: var(--danger); }
    .kpi-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .kpi-ico {
        width: 36px; height: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }
    .c-safe   .kpi-ico { background: var(--safe-bg);   color: var(--safe); }
    .c-warn   .kpi-ico { background: var(--warn-bg);   color: var(--warn); }
    .c-danger .kpi-ico { background: var(--danger-bg); color: var(--danger); }
    .kpi-val   { font-size: 28px; font-weight: 800; letter-spacing: -1px; color: var(--ink); margin-bottom: 4px; }
    .kpi-label { font-size: 12px; color: var(--ink-3); font-weight: 500; }

    /* ── NODE GRID ── */
    .node-grid {
        display: grid; grid-template-columns: repeat(3,1fr);
        gap: 18px; margin-bottom: 24px;
    }
    .node-card {
        background: var(--surface); border: 1px solid var(--rule);
        border-radius: var(--r-lg); overflow: hidden; box-shadow: var(--shadow-sm);
        transition: box-shadow .2s;
    }
    .node-card:hover { box-shadow: var(--shadow); }
    .node-top {
        height: 4px;
    }
    .node-body { padding: 18px 20px 16px; }
    .node-head { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; }
    .node-id   { font-family: var(--mono); font-size: 9px; color: var(--ink-4); letter-spacing: 1px; margin-bottom: 4px; }
    .node-name { font-size: 14px; font-weight: 700; color: var(--ink); }

    /* Sensor meters */
    .sensor-meters { display: flex; flex-direction: column; gap: 10px; margin-bottom: 16px; }
    .sm-row { }
    .sm-label-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; }
    .sm-label { font-size: 11px; color: var(--ink-3); font-weight: 500; }
    .sm-val   { font-family: var(--mono); font-size: 11px; font-weight: 600; }
    .sm-bar-wrap { height: 5px; background: var(--surf-3); border-radius: 10px; overflow: hidden; }
    .sm-bar      { height: 100%; border-radius: 10px; transition: width .5s ease; }

    /* Node footer */
    .node-footer {
        display: flex; justify-content: space-between;
        padding-top: 12px; border-top: 1px solid var(--rule);
    }
    .nf-item { }
    .nf-label { font-size: 9px; color: var(--ink-4); font-family: var(--mono); margin-bottom: 2px; }
    .nf-val   { font-size: 11px; font-weight: 600; font-family: var(--mono); color: var(--ink-2); }

    /* Empty node */
    .node-empty {
        background: var(--surface); border: 1px dashed var(--rule);
        border-radius: var(--r-lg); padding: 36px 20px;
        text-align: center; box-shadow: var(--shadow-sm);
    }

    /* ── BOTTOM GRID ── */
    .bottom-grid { display: grid; grid-template-columns: 1.4fr 1fr; gap: 20px; }

    /* ── CHART ── */
    .chart-tabs { display: flex; gap: 4px; }
    .chart-tab {
        padding: 5px 12px; border-radius: var(--r-sm);
        font-size: 11px; font-weight: 600; cursor: pointer;
        color: var(--ink-3); background: var(--surf-2);
        border: 1px solid var(--rule); transition: all .15s;
    }
    .chart-tab.active { background: var(--blue-l); color: var(--blue); border-color: rgba(37,99,235,.2); }
    .chart-wrap { height: 220px; position: relative; }

    /* ── THRESHOLD ── */
    .th-grid { display: flex; flex-direction: column; gap: 0; }
    .th-row {
        display: flex; gap: 14px; align-items: flex-start;
        padding: 14px 20px; border-bottom: 1px solid var(--rule-2);
    }
    .th-row:last-child { border-bottom: none; }
    .th-bar { width: 3px; min-height: 48px; border-radius: 4px; flex-shrink: 0; margin-top: 2px; }
    .th-label { font-size: 13px; font-weight: 700; margin-bottom: 6px; }
    .th-params { display: flex; flex-direction: column; gap: 3px; }
    .th-param  { font-family: var(--mono); font-size: 11px; color: var(--ink-3); }
</style>
@endsection

@section('content')
<div class="page">

    {{-- KPI --}}
    @php
        $amanCount   = collect($nodes)->where('status','AMAN')->count();
        $waspadaCount= collect($nodes)->where('status','WASPADA')->count();
        $bahayaCount = collect($nodes)->where('status','BAHAYA')->count();
    @endphp
    <div class="kpi-grid">
        <div class="kpi-card c-safe">
            <div class="kpi-top">
                <div class="kpi-ico">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <span class="badge badge-aman">AMAN</span>
            </div>
            <div class="kpi-val">{{ $amanCount }}</div>
            <div class="kpi-label">Node Status Aman</div>
        </div>
        <div class="kpi-card c-warn">
            <div class="kpi-top">
                <div class="kpi-ico">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                </div>
                <span class="badge badge-waspada">WASPADA</span>
            </div>
            <div class="kpi-val" style="{{ $waspadaCount > 0 ? 'color:var(--warn)' : '' }}">{{ $waspadaCount }}</div>
            <div class="kpi-label">Node Status Waspada</div>
        </div>
        <div class="kpi-card c-danger">
            <div class="kpi-top">
                <div class="kpi-ico">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/></svg>
                </div>
                <span class="badge badge-bahaya">BAHAYA</span>
            </div>
            <div class="kpi-val" style="{{ $bahayaCount > 0 ? 'color:var(--danger)' : '' }}">{{ $bahayaCount }}</div>
            <div class="kpi-label">Node Status Bahaya</div>
        </div>
    </div>

    {{-- NODE CARDS --}}
    <div class="node-grid">
        @foreach($nodeList as $n)
        @php $node = collect($nodes)->firstWhere('node_id', $n['id']); @endphp

        @if($node)
        @php
            $s = $node->status;
            $accent = $s === 'BAHAYA' ? 'var(--danger)' : ($s === 'WASPADA' ? 'var(--warn)' : 'var(--safe)');

            $tiltPct  = min(100, ($node->tilt_angle / 3) * 100);
            $tiltColor= $node->tilt_angle > 2.0 ? 'var(--danger)' : ($node->tilt_angle >= 0.5 ? 'var(--warn)' : 'var(--safe)');

            $rainPct  = min(100, ($node->rainfall / 100) * 100);
            $rainColor= $node->rainfall > 70 ? 'var(--danger)' : ($node->rainfall >= 20 ? 'var(--warn)' : 'var(--water)');

            $soilPct  = min(100, $node->soil_moist);
            $soilColor= $node->soil_moist > 80 ? 'var(--danger)' : ($node->soil_moist >= 50 ? 'var(--warn)' : 'var(--safe)');
        @endphp
        <div class="node-card">
            <div class="node-top" style="background:{{ $accent }}; opacity:.7"></div>
            <div class="node-body">
                <div class="node-head">
                    <div>
                        <div class="node-id">{{ $node->node_id }}</div>
                        <div class="node-name">{{ $node->node_name }}</div>
                    </div>
                    <span class="badge badge-{{ strtolower($s) }}">
                        <span class="badge-dot" style="background:currentColor;
                            {{ $s !== 'AMAN' ? 'animation:pulse-dot 2s ease-in-out infinite' : '' }}">
                        </span>
                        {{ $s }}
                    </span>
                </div>

                <div class="sensor-meters">
                    <div class="sm-row">
                        <div class="sm-label-row">
                            <span class="sm-label">Kemiringan</span>
                            <span class="sm-val" style="color:{{ $tiltColor }}">{{ number_format($node->tilt_angle,2) }}°</span>
                        </div>
                        <div class="sm-bar-wrap">
                            <div class="sm-bar" style="width:{{ $tiltPct }}%;background:{{ $tiltColor }}"></div>
                        </div>
                    </div>
                    <div class="sm-row">
                        <div class="sm-label-row">
                            <span class="sm-label">Curah Hujan</span>
                            <span class="sm-val" style="color:{{ $rainColor }}">{{ $node->rainfall }} mm</span>
                        </div>
                        <div class="sm-bar-wrap">
                            <div class="sm-bar" style="width:{{ $rainPct }}%;background:{{ $rainColor }}"></div>
                        </div>
                    </div>
                    <div class="sm-row">
                        <div class="sm-label-row">
                            <span class="sm-label">Kelembaban Tanah</span>
                            <span class="sm-val" style="color:{{ $soilColor }}">{{ $node->soil_moist }}%</span>
                        </div>
                        <div class="sm-bar-wrap">
                            <div class="sm-bar" style="width:{{ $soilPct }}%;background:{{ $soilColor }}"></div>
                        </div>
                    </div>
                </div>

                <div class="node-footer">
                    @if($node->battery)
                    <div class="nf-item">
                        <div class="nf-label">BATTERY</div>
                        <div class="nf-val">{{ $node->battery }}%</div>
                    </div>
                    @endif
                    @if($node->rssi)
                    <div class="nf-item">
                        <div class="nf-label">RSSI</div>
                        <div class="nf-val">{{ $node->rssi }} dBm</div>
                    </div>
                    @endif
                    <div class="nf-item">
                        <div class="nf-label">UPDATE</div>
                        <div class="nf-val">{{ $node->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="node-empty">
            <div style="font-family:var(--mono);font-size:11px;color:var(--ink-4);margin-bottom:8px">{{ $n['id'] }}</div>
            <div style="font-size:14px;font-weight:700;color:var(--ink-2);margin-bottom:4px">{{ $n['name'] }}</div>
            <div style="font-size:12px;color:var(--ink-4)">Menunggu data...</div>
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
                    <div class="card-title">Tren Sensor</div>
                </div>
                <div class="chart-tabs">
                    <div class="chart-tab active" onclick="switchChart('tilt',this)">Kemiringan</div>
                    <div class="chart-tab" onclick="switchChart('rain',this)">Hujan</div>
                    <div class="chart-tab" onclick="switchChart('soil',this)">Kelembaban</div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-wrap">
                    <canvas id="sajagaChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Threshold --}}
        <div class="card">
            <div class="card-head">
                <div>
                    <div class="card-eyebrow">Referensi</div>
                    <div class="card-title">Ambang Batas Status</div>
                </div>
            </div>
            <div class="th-grid">
                @foreach([
                    ['AMAN',    'var(--safe)',   ['Sudut < 0.5°','Hujan < 20 mm','Lembab < 50%']],
                    ['WASPADA', 'var(--warn)',   ['Sudut 0.5° – 2.0°','Hujan 20 – 70 mm','Lembab 50% – 80%']],
                    ['BAHAYA',  'var(--danger)', ['Sudut > 2.0°','Hujan > 70 mm','Lembab > 80%']],
                ] as [$lbl,$clr,$params])
                <div class="th-row">
                    <div class="th-bar" style="background:{{ $clr }}"></div>
                    <div>
                        <div class="th-label" style="color:{{ $clr }}">{{ $lbl }}</div>
                        <div class="th-params">
                            @foreach($params as $p)
                            <div class="th-param">{{ $p }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

<script>
@php
    $tx01 = \App\Models\SajagaReading::where('node_id','TX-01')->latest()->take(10)->get()->reverse()->values();
    $tx02 = \App\Models\SajagaReading::where('node_id','TX-02')->latest()->take(10)->get()->reverse()->values();
    $tx03 = \App\Models\SajagaReading::where('node_id','TX-03')->latest()->take(10)->get()->reverse()->values();
    $labels = $tx01->count() > 0
        ? $tx01->map(fn($r) => $r->created_at->format('H:i'))->toArray()
        : array_map(fn($i) => "T-$i", range(10,1));
@endphp

const chartData = {
    tilt: {
        label: 'Kemiringan (°)',
        datasets: [
            { label:'TX-01', data: @json($tx01->pluck('tilt_angle')), borderColor:'#2563eb', backgroundColor:'rgba(37,99,235,.05)' },
            { label:'TX-02', data: @json($tx02->pluck('tilt_angle')), borderColor:'#059669', backgroundColor:'rgba(5,150,105,.05)' },
            { label:'TX-03', data: @json($tx03->pluck('tilt_angle')), borderColor:'#d97706', backgroundColor:'rgba(217,119,6,.05)' },
        ]
    },
    rain: {
        label: 'Curah Hujan (mm)',
        datasets: [
            { label:'TX-01', data: @json($tx01->pluck('rainfall')), borderColor:'#2563eb', backgroundColor:'rgba(37,99,235,.05)' },
            { label:'TX-02', data: @json($tx02->pluck('rainfall')), borderColor:'#059669', backgroundColor:'rgba(5,150,105,.05)' },
            { label:'TX-03', data: @json($tx03->pluck('rainfall')), borderColor:'#d97706', backgroundColor:'rgba(217,119,6,.05)' },
        ]
    },
    soil: {
        label: 'Kelembaban (%)',
        datasets: [
            { label:'TX-01', data: @json($tx01->pluck('soil_moist')), borderColor:'#2563eb', backgroundColor:'rgba(37,99,235,.05)' },
            { label:'TX-02', data: @json($tx02->pluck('soil_moist')), borderColor:'#059669', backgroundColor:'rgba(5,150,105,.05)' },
            { label:'TX-03', data: @json($tx03->pluck('soil_moist')), borderColor:'#d97706', backgroundColor:'rgba(217,119,6,.05)' },
        ]
    }
};

const labels = @json($labels);

function buildDatasets(key) {
    return chartData[key].datasets.map(d => ({
        ...d, borderWidth: 2, pointRadius: 3, pointHoverRadius: 5,
        fill: true, tension: .4
    }));
}

const ctx = document.getElementById('sajagaChart').getContext('2d');
let chart = new Chart(ctx, {
    type: 'line',
    data: { labels, datasets: buildDatasets('tilt') },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
            legend: { position:'bottom', labels:{ font:{family:'Plus Jakarta Sans',size:11}, boxWidth:10, padding:14 } },
            tooltip: { mode:'index', intersect:false }
        },
        scales: {
            x: { grid:{display:false}, ticks:{font:{family:'JetBrains Mono',size:10},color:'#9ca3af'} },
            y: { grid:{color:'rgba(0,0,0,.04)'}, ticks:{font:{family:'JetBrains Mono',size:10},color:'#9ca3af'} }
        }
    }
});

function switchChart(key, el) {
    document.querySelectorAll('.chart-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    chart.data.datasets = buildDatasets(key);
    chart.options.scales.y.title = { display:true, text:chartData[key].label, font:{size:10}, color:'#9ca3af' };
    chart.update();
}

setTimeout(() => location.reload(), 15000);
</script>
@endsection