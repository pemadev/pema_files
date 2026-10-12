@extends('admin.layouts.master')

@section('title', 'Halaman Terpopuler')
@section('page_title', 'Halaman Terpopuler')

@section('content')
@php
    $items = $pages->map(fn ($p) => [
        'name'  => $p['pageTitle'] ?? ($p['fullPageUrl'] ?? '-'),
        'views' => (int) ($p['screenPageViews'] ?? 0),
    ])->values();
@endphp

<div class="pp-wrap">
    <a class="pp-back" href="{{ route('admin.dashboard') }}">← Kembali ke Dashboard</a>
    <h1 class="pp-title">Halaman Terpopuler</h1>

    <div class="pp-stats">
        <div class="pp-stat"><span>Total Kunjungan</span><b id="ppTotal">0</b></div>
        <div class="pp-stat"><span>Jumlah Halaman</span><b id="ppCount">0</b></div>
        <div class="pp-stat"><span>Terpopuler</span><b id="ppTop">-</b></div>
    </div>

    <div class="pp-card">
        <h2>Grafik Total Kunjungan</h2>
        <div class="pp-chart" id="ppChart"></div>
    </div>

    <div class="pp-card">
        <h2>Semua Halaman</h2>
        <div class="pp-tools">
            <input id="ppSearch" type="search" placeholder="Cari halaman...">
            <button id="ppSort" type="button">Urut: Tertinggi</button>
        </div>
        <div class="pp-tbl">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Halaman</th>
                        <th class="n">Kunjungan</th>
                        <th class="n">Persentase</th>
                    </tr>
                </thead>
                <tbody id="ppRows"></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.pp-wrap{max-width:900px;margin:0 auto;padding:20px 16px 40px;color:#1e2433}
.pp-wrap *{box-sizing:border-box}
.pp-back{display:inline-block;color:#3b6cf6;text-decoration:none;font-size:14px;margin-bottom:12px}
.pp-title{font-size:20px;font-weight:600;margin:0 0 16px}
.pp-card{background:#fff;border-radius:16px;box-shadow:0 1px 6px rgba(0,0,0,.06);margin-bottom:16px;overflow:hidden}
.pp-card h2{font-size:15px;font-weight:600;margin:0;padding:16px 20px;border-bottom:1px solid #eef0f4}
.pp-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:16px}
.pp-stat{background:#fff;border-radius:16px;padding:14px 16px;box-shadow:0 1px 6px rgba(0,0,0,.06)}
.pp-stat span{display:block;font-size:12px;color:#8a93a6}
.pp-stat b{font-size:22px}
.pp-chart{padding:8px 20px 16px}
.pp-bar{padding:10px 0}
.pp-bar-top{display:flex;justify-content:space-between;gap:12px;font-size:14px}
.pp-bar-top span{min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.pp-bar-top em{font-style:normal;color:#8a93a6;font-weight:600;white-space:nowrap}
.pp-track{height:10px;border-radius:6px;background:#e8edfb;margin-top:6px;overflow:hidden}
.pp-fill{height:100%;background:#3b6cf6;border-radius:6px;transition:width .5s}
.pp-tools{display:flex;gap:8px;padding:12px 20px;border-bottom:1px solid #eef0f4}
.pp-tools input,.pp-tools button{font:inherit;font-size:14px;padding:8px 12px;border-radius:10px;border:1px solid #eef0f4;background:#f4f6f9;color:#1e2433}
.pp-tools input{flex:1;min-width:0}
.pp-tools button{cursor:pointer}
.pp-tbl{overflow-x:auto}
.pp-tbl table{width:100%;border-collapse:collapse;font-size:14px}
.pp-tbl th,.pp-tbl td{padding:12px 20px;text-align:left;border-bottom:1px solid #eef0f4}
.pp-tbl th{font-size:12px;color:#8a93a6;font-weight:600}
.pp-tbl td.n,.pp-tbl th.n{text-align:right}
.pp-tbl td.n{color:#8a93a6;font-weight:600}
.pp-tbl tr:last-child td{border-bottom:0}
@media (max-width:560px){.pp-stats{grid-template-columns:1fr}}
</style>
@endpush

@push('scripts')
<script>
(function () {
    const data  = @json($items);
    const total = {{ (int) ($grandTotal ?? 0) }} || data.reduce((s, d) => s + d.views, 0);
    const max   = Math.max(1, ...data.map(d => d.views));
    let desc = true;

    const fmt = n => n.toLocaleString('id-ID');
    const esc = s => String(s).replace(/[&<>"]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));

    document.getElementById('ppTotal').textContent = fmt(total);
    document.getElementById('ppCount').textContent = data.length >= 100 ? '10' : data.length;
    document.getElementById('ppTop').textContent   = data.length ? fmt(Math.max(...data.map(d => d.views))) : '-';

    // Grafik batang (15 teratas)
    const chart = data.slice(0, 5).map(d =>
        '<div class="pp-bar"><div class="pp-bar-top"><span>' + esc(d.name) + '</span><em>' + fmt(d.views) + '</em></div>' +
        '<div class="pp-track"><div class="pp-fill" style="width:' + (d.views / max * 100) + '%"></div></div></div>'
    ).join('');
    document.getElementById('ppChart').innerHTML = chart || '<p style="padding:16px 0;text-align:center;color:#8a93a6">Belum ada data.</p>';

    // Tabel + cari + urut
    function render() {
        const q = document.getElementById('ppSearch').value.toLowerCase();
        const list = data
    .filter(d => d.name.toLowerCase().includes(q))
    .sort((a, b) => desc ? b.views - a.views : a.views - b.views)
    .slice(0, 10);

        document.getElementById('ppRows').innerHTML = list.length
            ? list.map((d, i) =>
                '<tr><td>' + (i + 1) + '</td><td>' + esc(d.name) + '</td>' +
                '<td class="n">' + fmt(d.views) + '</td>' +
                '<td class="n">' + (total ? (d.views / total * 100).toFixed(1).replace('.', ',') : '0') + '%</td></tr>'
              ).join('')
            : '<tr><td colspan="4" style="text-align:center;color:#8a93a6">Tidak ada hasil</td></tr>';
    }

    document.getElementById('ppSearch').addEventListener('input', render);
    document.getElementById('ppSort').addEventListener('click', function () {
        desc = !desc;
        this.textContent = 'Urut: ' + (desc ? 'Tertinggi' : 'Terendah');
        render();
    });
    render();
})();
</script>
@endpush