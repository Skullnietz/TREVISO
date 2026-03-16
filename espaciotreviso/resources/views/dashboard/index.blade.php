@extends('layouts.sidebar')

@section('title','Dashboard')

@section('content')
{{-- Page header --}}
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-3xl font-black text-lt-text dark:text-dk-text leading-tight">Dashboard</h1>
        <p class="text-sm text-accent mt-1">Bienvenido, <span class="text-primary font-semibold">{{ Auth::user()->NickUsuarioEmpleado }}</span> &mdash; {{ now()->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</p>
    </div>
    <a href="{{ route('cfdi.index') }}"
       class="flex items-center gap-2 bg-primary hover:bg-primary-hover text-white text-sm font-bold px-4 py-2.5 rounded-lg">
        <span class="material-symbols-outlined text-[18px]">receipt_long</span> Ver CFDIs
    </a>
</div>

{{-- ── STAT CARDS ── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-5">

    <div class="bg-lt-surface dark:bg-dk-surface border border-lt-border dark:border-dk-border rounded-xl p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-accent text-sm font-medium">Total CFDIs</p>
                <p class="text-3xl font-bold mt-1 text-lt-text dark:text-dk-text">{{ number_format($totalXml) }}</p>
                <p class="text-xs text-accent mt-1">En el sistema</p>
            </div>
            <div class="flex items-center justify-center w-10 h-10 bg-primary/15 rounded-lg flex-shrink-0">
                <span class="material-symbols-outlined text-primary">receipt_long</span>
            </div>
        </div>
    </div>

    <div class="bg-lt-surface dark:bg-dk-surface border border-lt-border dark:border-dk-border rounded-xl p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-accent text-sm font-medium">Clientes Activos</p>
                <p class="text-3xl font-bold mt-1 text-lt-text dark:text-dk-text">{{ $totalClientes }}</p>
                <p class="text-xs text-accent mt-1">Cuentas vigentes</p>
            </div>
            <div class="flex items-center justify-center w-10 h-10 bg-green-500/15 rounded-lg flex-shrink-0">
                <span class="material-symbols-outlined text-green-500 dark:text-green-400">groups</span>
            </div>
        </div>
    </div>

    <div class="bg-lt-surface dark:bg-dk-surface border border-lt-border dark:border-dk-border rounded-xl p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-accent text-sm font-medium">Por Contabilizar</p>
                <p class="text-3xl font-bold mt-1 {{ $pendientesConta > 0 ? 'text-amber-500 dark:text-yellow-400' : 'text-green-600 dark:text-green-400' }}">{{ number_format($pendientesConta) }}</p>
                <p class="text-xs text-accent mt-1">CFDIs pendientes</p>
            </div>
            <div class="flex items-center justify-center w-10 h-10 bg-amber-500/15 rounded-lg flex-shrink-0">
                <span class="material-symbols-outlined text-amber-500 dark:text-yellow-400">calculate</span>
            </div>
        </div>
    </div>

    <div class="bg-lt-surface dark:bg-dk-surface border border-lt-border dark:border-dk-border rounded-xl p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-accent text-sm font-medium">Solicitudes</p>
                <p class="text-3xl font-bold mt-1 {{ $solicitudes > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">{{ $solicitudes }}</p>
                <p class="text-xs text-accent mt-1">Sin atender</p>
            </div>
            <div class="flex items-center justify-center w-10 h-10 bg-red-500/15 rounded-lg flex-shrink-0">
                <span class="material-symbols-outlined text-red-600 dark:text-red-400">edit_note</span>
            </div>
        </div>
    </div>
</div>

{{-- ── CHARTS ROW 1 ── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
    {{-- Line: CFDIs por mes --}}
    <div class="lg:col-span-2 bg-lt-surface dark:bg-dk-surface border border-lt-border dark:border-dk-border rounded-xl p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lt-text dark:text-dk-text">CFDIs Procesados — Últimos 6 Meses</h3>
            <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded-full font-medium">Mensual</span>
        </div>
        <div class="h-56"><canvas id="chartXmlMes"></canvas></div>
    </div>

    {{-- Doughnut: Tipo XML --}}
    <div class="bg-lt-surface dark:bg-dk-surface border border-lt-border dark:border-dk-border rounded-xl p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lt-text dark:text-dk-text">Tipo de CFDI</h3>
            <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded-full font-medium">Total</span>
        </div>
        <div class="h-44 flex items-center justify-center">
            <canvas id="chartTipoXml"></canvas>
        </div>
        <div class="mt-3 grid grid-cols-2 gap-1.5">
            @foreach($chart2Labels as $i => $label)
            <div class="flex items-center gap-1.5 text-xs text-accent">
                <span class="w-2.5 h-2.5 rounded-full flex-shrink-0"
                      style="background:{{ ['#32a5d7','#47bcea','#f59e0b','#8e989e'][$i % 4] }}"></span>
                <span class="truncate">{{ $label }}: {{ number_format($chart2Data[$i] ?? 0) }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ── CHARTS ROW 2 ── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
    {{-- Bar: Depósitos vs Reembolsos --}}
    <div class="lg:col-span-2 bg-lt-surface dark:bg-dk-surface border border-lt-border dark:border-dk-border rounded-xl p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lt-text dark:text-dk-text">Depósitos vs Reembolsos — Últimos 6 Meses</h3>
            <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded-full font-medium">MXN</span>
        </div>
        <div class="h-56"><canvas id="chartDepReem"></canvas></div>
    </div>

    {{-- Admin: clientes por empleado / Colaborador: estado CFDIs --}}
    <div class="bg-lt-surface dark:bg-dk-surface border border-lt-border dark:border-dk-border rounded-xl p-5">
        @if($esAdmin)
            <h3 class="font-bold text-lt-text dark:text-dk-text mb-4">Clientes por Empleado</h3>
            <div class="h-56"><canvas id="chartCliEmp"></canvas></div>
        @else
            <h3 class="font-bold text-lt-text dark:text-dk-text mb-4">Estado de CFDIs</h3>
            <div class="h-44 flex items-center justify-center">
                <canvas id="chartEstadoCfdi"></canvas>
            </div>
            <div class="mt-4 space-y-2">
                <div class="flex items-center gap-2 text-xs text-lt-text dark:text-dk-text">
                    <span class="w-3 h-3 rounded-full bg-green-500 flex-shrink-0"></span>
                    Contabilizados: <strong>{{ number_format($totalXml - $pendientesConta) }}</strong>
                </div>
                <div class="flex items-center gap-2 text-xs text-lt-text dark:text-dk-text">
                    <span class="w-3 h-3 rounded-full bg-amber-400 flex-shrink-0"></span>
                    Por contabilizar: <strong>{{ number_format($pendientesConta) }}</strong>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ── BOTTOM ROW ── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

    {{-- Top 5 clientes --}}
    <div class="lg:col-span-2 bg-lt-surface dark:bg-dk-surface border border-lt-border dark:border-dk-border rounded-xl p-5">
        <h3 class="font-bold text-lt-text dark:text-dk-text mb-4">Top 5 Clientes por Volumen de CFDI</h3>
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-lt-border dark:border-dk-border">
                    <th class="text-left text-xs text-accent uppercase pb-2 pr-4 font-semibold">#</th>
                    <th class="text-left text-xs text-accent uppercase pb-2 pr-4 font-semibold">Cliente</th>
                    <th class="text-right text-xs text-accent uppercase pb-2 font-semibold">CFDIs</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-lt-border dark:divide-dk-border">
                @foreach($topClientes as $i => $c)
                <tr class="hover:bg-lt-hover dark:hover:bg-dk-hover transition-colors">
                    <td class="py-3 pr-4 text-accent font-medium">{{ $i+1 }}</td>
                    <td class="py-3 pr-4 font-medium text-lt-text dark:text-dk-text">
                        <span class="block truncate max-w-[200px]">{{ $c->NombreCliente }}</span>
                    </td>
                    <td class="py-3 text-right">
                        <span class="bg-primary/15 text-primary text-xs font-bold px-2.5 py-1 rounded-full">{{ number_format($c->total) }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Right column --}}
    <div class="space-y-4">

        {{-- Accesos rápidos --}}
        <div class="bg-lt-surface dark:bg-dk-surface border border-lt-border dark:border-dk-border rounded-xl p-5">
            <h3 class="font-bold text-lt-text dark:text-dk-text mb-3">Accesos Rápidos</h3>
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('cfdi.index') }}"
                   class="flex flex-col items-center gap-1.5 p-3 rounded-lg group transition-colors
                          bg-lt-input dark:bg-dk-input hover:bg-primary/15">
                    <span class="material-symbols-outlined text-primary text-[24px]">receipt_long</span>
                    <span class="text-xs text-accent group-hover:text-primary text-center">Ver CFDIs</span>
                </a>
                <a href="{{ route('operaciones.index') }}"
                   class="flex flex-col items-center gap-1.5 p-3 rounded-lg group transition-colors
                          bg-lt-input dark:bg-dk-input hover:bg-primary/15">
                    <span class="material-symbols-outlined text-primary text-[24px]">swap_horiz</span>
                    <span class="text-xs text-accent group-hover:text-primary text-center">Operaciones</span>
                </a>
                <a href="{{ route('reportes.index') }}"
                   class="flex flex-col items-center gap-1.5 p-3 rounded-lg group transition-colors
                          bg-lt-input dark:bg-dk-input hover:bg-primary/15">
                    <span class="material-symbols-outlined text-primary text-[24px]">assessment</span>
                    <span class="text-xs text-accent group-hover:text-primary text-center">Reportes</span>
                </a>
                <a href="{{ route('clientes.index') }}"
                   class="flex flex-col items-center gap-1.5 p-3 rounded-lg group transition-colors
                          bg-lt-input dark:bg-dk-input hover:bg-primary/15">
                    <span class="material-symbols-outlined text-primary text-[24px]">groups</span>
                    <span class="text-xs text-accent group-hover:text-primary text-center">Clientes</span>
                </a>
            </div>
        </div>

        {{-- Notificaciones --}}
        <div class="bg-lt-surface dark:bg-dk-surface border border-lt-border dark:border-dk-border rounded-xl p-5">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-lt-text dark:text-dk-text">Notificaciones</h3>
                <a href="{{ route('notificaciones.index') }}" class="text-xs text-primary hover:underline">Ver todas</a>
            </div>
            @if($notificaciones->isEmpty())
                <p class="text-xs text-accent text-center py-4">Sin notificaciones recientes</p>
            @else
            <ul class="space-y-3">
                @foreach($notificaciones as $n)
                <li class="flex items-start gap-2.5">
                    <div class="flex-shrink-0 w-7 h-7 bg-primary/15 rounded-full flex items-center justify-center mt-0.5">
                        <span class="material-symbols-outlined text-primary text-[14px]">notifications</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-lt-text dark:text-dk-text leading-snug">
                            {{ Str::limit($n->DescripcionNotificacion ?? 'Notificación', 60) }}
                        </p>
                        <p class="text-xs text-accent mt-0.5">{{ \Carbon\Carbon::parse($n->FechaNotificacion)->diffForHumans() }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// ── Chart theme colors ──────────────────────────────────
var THEME = {
    dark: {
        grid:   'rgba(255,255,255,0.06)',
        tick:   '#8e989e',
        legend: '#8e989e',
        border: '#1a2428',
    },
    light: {
        grid:   'rgba(0,0,0,0.07)',
        tick:   '#64748b',
        legend: '#475569',
        border: '#ffffff',
    }
};

function isDark() {
    return document.getElementById('htmlRoot').classList.contains('dark');
}
function tc() { return isDark() ? THEME.dark : THEME.light; }

// ── Chart.js defaults ───────────────────────────────────
Chart.defaults.font.family = 'Inter, sans-serif';
Chart.defaults.font.size   = 12;

const PRIMARY   = '#32a5d7';
const SECONDARY = '#47bcea';
const AMBER     = '#f59e0b';
const GRAY      = '#8e989e';

// ── Chart instances ─────────────────────────────────────
var charts = [];

function buildScalesXY(showXGrid) {
    var t = tc();
    return {
        x: {
            grid:  { color: showXGrid ? t.grid : 'transparent', display: !!showXGrid },
            ticks: { color: t.tick }
        },
        y: {
            grid:  { color: t.grid },
            ticks: { color: t.tick }
        }
    };
}

// Chart 1 — Line: CFDIs por mes
var c1 = new Chart(document.getElementById('chartXmlMes'), {
    type: 'line',
    data: {
        labels: {!! json_encode($chart1Labels) !!},
        datasets: [{
            label: 'CFDIs',
            data:  {!! json_encode($chart1Data) !!},
            borderColor:           PRIMARY,
            backgroundColor:       'rgba(50,165,215,0.10)',
            borderWidth:           2,
            pointBackgroundColor:  PRIMARY,
            pointRadius:           4,
            pointHoverRadius:      6,
            tension:               0.4,
            fill:                  true,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: Object.assign(buildScalesXY(false), {
            y: {
                grid:  { color: tc().grid },
                ticks: { color: tc().tick, callback: function(v){ return v>=1000?(v/1000)+'k':v; } },
                beginAtZero: true,
            }
        })
    }
});
charts.push(c1);

// Chart 2 — Doughnut: Tipo XML
var c2 = new Chart(document.getElementById('chartTipoXml'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($chart2Labels) !!},
        datasets: [{
            data:            {!! json_encode($chart2Data) !!},
            backgroundColor: [PRIMARY, SECONDARY, AMBER, GRAY],
            borderWidth:     3,
            borderColor:     tc().border,
            hoverOffset:     6,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        cutout: '66%',
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: function(ctx){ return ' '+ctx.label+': '+ctx.raw.toLocaleString('es-MX'); } } }
        }
    }
});
charts.push(c2);

// Chart 3 — Bar: Depósitos vs Reembolsos
var c3 = new Chart(document.getElementById('chartDepReem'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($chart3Labels) !!},
        datasets: [
            {
                label: 'Depósitos',
                data:  {!! json_encode($chart3Deposits) !!},
                backgroundColor: 'rgba(50,165,215,0.75)',
                hoverBackgroundColor: PRIMARY,
                borderRadius: 4,
            },
            {
                label: 'Reembolsos',
                data:  {!! json_encode($chart3Reembolsos) !!},
                backgroundColor: 'rgba(245,158,11,0.75)',
                hoverBackgroundColor: AMBER,
                borderRadius: 4,
            }
        ]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
            legend: { position: 'top', labels: { boxWidth: 12, padding: 14, color: tc().legend } },
            tooltip: { callbacks: { label: function(ctx){ return ' $'+ctx.raw.toLocaleString('es-MX',{minimumFractionDigits:2}); } } }
        },
        scales: {
            x: { grid: { display: false }, ticks: { color: tc().tick } },
            y: {
                grid:  { color: tc().grid },
                ticks: { color: tc().tick, callback: function(v){ return '$'+(v>=1e6?(v/1e6).toFixed(1)+'M':v>=1000?(v/1000).toFixed(0)+'k':v); } },
                beginAtZero: true,
            }
        }
    }
});
charts.push(c3);

@if($esAdmin)
// Chart 4a — Horizontal bar: Clientes por empleado
var c4 = new Chart(document.getElementById('chartCliEmp'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($chart4Labels) !!},
        datasets: [{
            label: 'Clientes',
            data:  {!! json_encode($chart4Data) !!},
            backgroundColor: PRIMARY,
            hoverBackgroundColor: SECONDARY,
            borderRadius: 4,
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: tc().grid }, ticks: { color: tc().tick }, beginAtZero: true },
            y: {
                grid: { display: false },
                ticks: {
                    color: tc().tick,
                    font: { size: 11 },
                    callback: function(v){ var l=this.getLabelForValue(v); return l.length>14?l.substr(0,14)+'…':l; }
                }
            }
        }
    }
});
charts.push(c4);
@else
// Chart 4b — Doughnut: Estado CFDIs
var c4 = new Chart(document.getElementById('chartEstadoCfdi'), {
    type: 'doughnut',
    data: {
        labels: ['Contabilizados','Por contabilizar'],
        datasets: [{
            data: [{{ ($totalXml - $pendientesConta) }}, {{ $pendientesConta }}],
            backgroundColor: ['#22c55e','#f59e0b'],
            borderWidth:  3,
            borderColor:  tc().border,
            hoverOffset:  6,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        cutout: '66%',
        plugins: { legend: { display: false } }
    }
});
charts.push(c4);
@endif

// ── Update charts when theme changes ───────────────────
document.addEventListener('themechange', function () {
    var t = tc();

    // Update scale colors on all axis-based charts
    [c1, c3].forEach(function (ch) {
        if (!ch || !ch.options.scales) return;
        var sx = ch.options.scales.x, sy = ch.options.scales.y;
        if (sx) { if(sx.grid) sx.grid.color = 'transparent'; if(sx.ticks) sx.ticks.color = t.tick; }
        if (sy) { if(sy.grid) sy.grid.color = t.grid; if(sy.ticks) sy.ticks.color = t.tick; }
    });

    // c1 x-grid stays transparent; y ticks ok
    if (c1.options.scales.x && c1.options.scales.x.ticks) c1.options.scales.x.ticks.color = t.tick;

    // c3 legend
    if (c3.options.plugins && c3.options.plugins.legend && c3.options.plugins.legend.labels) {
        c3.options.plugins.legend.labels.color = t.legend;
    }
    if (c3.options.scales.x && c3.options.scales.x.ticks) c3.options.scales.x.ticks.color = t.tick;

    // c4 (bar or doughnut)
    if (c4 && c4.options.scales) {
        var sx4 = c4.options.scales.x, sy4 = c4.options.scales.y;
        if (sx4) { if(sx4.grid) sx4.grid.color = t.grid; if(sx4.ticks) sx4.ticks.color = t.tick; }
        if (sy4) { if(sy4.grid) { sy4.grid.display=false; } if(sy4.ticks) sy4.ticks.color = t.tick; }
    }

    // Doughnut border colors
    [c2, c4].forEach(function (ch) {
        if (!ch || !ch.data || !ch.data.datasets) return;
        ch.data.datasets.forEach(function(ds){ ds.borderColor = t.border; });
    });

    charts.forEach(function (ch) { if (ch) ch.update('none'); });
});
</script>
@endsection
