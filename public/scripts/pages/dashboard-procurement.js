/**
 * Dashboard Control Center SIMPPEL
 * Mengambil data dari GET /dashboard-control-center/data lalu merender grafik ApexCharts.
 */
(function () {
    'use strict';

    const MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const PALETTE = ['#2563eb', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#ec4899', '#64748b'];

    const charts = {};
    let lastData = null;

    const $ = (id) => document.getElementById(id);

    const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));

    const fmtInt = (n) => Number(n || 0).toLocaleString('id-ID');

    const fmtRp = (n) => 'Rp ' + Number(n || 0).toLocaleString('id-ID', { maximumFractionDigits: 0 });

    const fmtShort = (n) => {
        n = Number(n || 0);
        if (Math.abs(n) >= 1e12) return 'Rp ' + (n / 1e12).toLocaleString('id-ID', { maximumFractionDigits: 2 }) + ' T';
        if (Math.abs(n) >= 1e9) return 'Rp ' + (n / 1e9).toLocaleString('id-ID', { maximumFractionDigits: 2 }) + ' M';
        if (Math.abs(n) >= 1e6) return 'Rp ' + (n / 1e6).toLocaleString('id-ID', { maximumFractionDigits: 1 }) + ' Jt';
        return fmtRp(n);
    };

    const isDark = () => document.documentElement.getAttribute('data-bs-theme') === 'dark';

    function baseOptions(extra) {
        return Object.assign({
            chart: {
                fontFamily: 'inherit',
                toolbar: { show: false },
                background: 'transparent',
                animations: { enabled: true, speed: 400 }
            },
            theme: { mode: isDark() ? 'dark' : 'light' },
            colors: PALETTE,
            dataLabels: { enabled: false },
            grid: { borderColor: isDark() ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)' },
            legend: { position: 'top' },
            noData: { text: 'Belum ada data' }
        }, extra || {});
    }

    function render(key, el, options) {
        if (!el) return;
        if (charts[key]) {
            charts[key].destroy();
            delete charts[key];
        }
        el.innerHTML = '';
        charts[key] = new ApexCharts(el, options);
        charts[key].render();
    }

    function renderEmpty(key, el, message) {
        if (!el) return;
        if (charts[key]) {
            charts[key].destroy();
            delete charts[key];
        }
        el.innerHTML = '<div class="cc-empty">' + esc(message || 'Belum ada data') + '</div>';
    }

    // ------------------------------------------------------------------
    // KPI
    // ------------------------------------------------------------------
    function renderKpi(k) {
        $('kpiRup').textContent = fmtInt(k.total_rup) + ' Paket';
        $('kpiPagu').textContent = 'Pagu ' + fmtShort(k.total_pagu);
        $('kpiMasuk').textContent = fmtInt(k.paket_masuk) + ' Paket';
        $('kpiSerapan').textContent = k.serapan_persen + '% dari RUP sudah masuk';
        $('kpiProses').textContent = fmtInt(k.paket_proses) + ' Paket';
        $('kpiBelum').textContent = fmtInt(k.belum_masuk) + ' RUP belum diajukan';
        $('kpiSelesai').textContent = fmtInt(k.paket_selesai) + ' Paket';
        $('kpiKontrak').textContent = 'Kontrak ' + fmtShort(k.total_kontrak);
        $('kpiHps').textContent = fmtShort(k.total_hps);
        $('kpiEfisiensi').textContent = fmtShort(k.efisiensi_rp);

        render('radial', $('chartRadial'), baseOptions({
            chart: Object.assign(baseOptions().chart, { type: 'radialBar', height: 270 }),
            series: [Number(k.serapan_persen) || 0, Number(k.selesai_persen) || 0, Number(k.efisiensi_persen) || 0],
            labels: ['RUP Masuk UKPBJ', 'Paket Selesai', 'Efisiensi'],
            colors: ['#2563eb', '#10b981', '#f59e0b'],
            plotOptions: {
                radialBar: {
                    hollow: { size: '32%' },
                    track: { background: isDark() ? 'rgba(255,255,255,0.06)' : '#eef2f7' },
                    dataLabels: {
                        name: { fontSize: '12px' },
                        value: { fontSize: '16px', formatter: (v) => Number(v).toLocaleString('id-ID') + '%' },
                        total: {
                            show: true,
                            label: 'Efisiensi',
                            formatter: () => Number(k.efisiensi_persen || 0).toLocaleString('id-ID') + '%'
                        }
                    }
                }
            },
            legend: { show: true, position: 'bottom' }
        }));
    }

    // ------------------------------------------------------------------
    // Tren bulanan
    // ------------------------------------------------------------------
    function renderTrend(m) {
        const mode = document.querySelector('input[name="ccTrendMode"]:checked')?.value || 'paket';
        const nilai = mode === 'nilai';

        const series = nilai
            ? [
                { name: 'Rencana Pagu', type: 'column', data: m.rencana_pagu },
                { name: 'HPS Masuk', type: 'column', data: m.masuk_hps },
                { name: 'Nilai Kontrak', type: 'line', data: m.kontrak }
            ]
            : [
                { name: 'Rencana (RUP)', type: 'column', data: m.rencana_paket },
                { name: 'Masuk UKPBJ', type: 'column', data: m.masuk_paket },
                { name: 'Selesai', type: 'line', data: m.selesai_paket }
            ];

        render('trend', $('chartTrend'), baseOptions({
            chart: Object.assign(baseOptions().chart, { type: 'line', height: 320, stacked: false }),
            series: series,
            colors: ['#93c5fd', '#2563eb', '#10b981'],
            stroke: { width: [0, 0, 3], curve: 'smooth' },
            markers: { size: [0, 0, 4] },
            plotOptions: { bar: { columnWidth: '55%', borderRadius: 3 } },
            xaxis: { categories: MONTHS },
            yaxis: {
                labels: { formatter: (v) => nilai ? fmtShort(v).replace('Rp ', '') : fmtInt(Math.round(v)) }
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: { formatter: (v) => nilai ? fmtRp(v) : fmtInt(v) + ' paket' }
            }
        }));
    }

    // ------------------------------------------------------------------
    // Pipeline
    // ------------------------------------------------------------------
    function renderPipeline(p) {
        const stages = p.stages || [];
        render('pipeline', $('chartPipeline'), baseOptions({
            chart: Object.assign(baseOptions().chart, { type: 'bar', height: 320 }),
            series: [{ name: 'Jumlah Paket', data: stages.map((s) => s.count) }],
            colors: ['#94a3b8', '#f59e0b', '#06b6d4', '#a855f7', '#2563eb', '#14b8a6', '#10b981', '#ef4444'],
            plotOptions: { bar: { horizontal: true, distributed: true, borderRadius: 4, barHeight: '70%' } },
            dataLabels: { enabled: true, formatter: (v) => fmtInt(v), style: { fontSize: '11px' } },
            xaxis: { categories: stages.map((s) => s.label), labels: { formatter: (v) => fmtInt(Math.round(v)) } },
            legend: { show: false },
            tooltip: {
                y: {
                    formatter: (v, o) => fmtInt(v) + ' paket — HPS ' + fmtShort((stages[o.dataPointIndex] || {}).hps)
                }
            }
        }));
    }

    // ------------------------------------------------------------------
    // Komposisi (donut / bar)
    // ------------------------------------------------------------------
    function renderDonut(key, el, rows, valueKey) {
        const vals = (rows || []).map((r) => Number(r[valueKey]) || 0);
        const total = vals.reduce((a, b) => a + b, 0);
        if (!rows || rows.length === 0 || total <= 0) {
            renderEmpty(key, el, 'Belum ada data untuk ditampilkan.');
            return;
        }
        render(key, el, baseOptions({
            chart: Object.assign(baseOptions().chart, { type: 'donut', height: 300 }),
            series: vals,
            labels: rows.map((r) => r.label),
            legend: { position: 'bottom' },
            dataLabels: { enabled: true, formatter: (v) => v.toFixed(0) + '%' },
            plotOptions: {
                pie: {
                    donut: {
                        size: '62%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: valueKey === 'pagu' ? 'Total Pagu' : 'Total Paket',
                                formatter: (w) => {
                                    const sum = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    return valueKey === 'pagu' ? fmtShort(sum) : fmtInt(sum);
                                }
                            }
                        }
                    }
                }
            },
            tooltip: {
                y: { formatter: (v) => valueKey === 'pagu' ? fmtRp(v) : fmtInt(v) + ' paket' }
            }
        }));
    }

    function renderMetode(rows) {
        if (!rows || rows.length === 0) {
            renderEmpty('metode', $('chartMetode'), 'Belum ada data metode pemilihan.');
            return;
        }
        render('metode', $('chartMetode'), baseOptions({
            chart: Object.assign(baseOptions().chart, { type: 'bar', height: 300 }),
            series: [
                { name: 'Jumlah Paket', data: rows.map((r) => r.count) }
            ],
            colors: PALETTE,
            plotOptions: { bar: { borderRadius: 4, columnWidth: '50%', distributed: true } },
            legend: { show: false },
            dataLabels: { enabled: true },
            xaxis: { categories: rows.map((r) => r.label), labels: { rotate: -30, trim: true } },
            yaxis: { labels: { formatter: (v) => fmtInt(Math.round(v)) } },
            tooltip: {
                y: { formatter: (v, o) => fmtInt(v) + ' paket — ' + fmtShort((rows[o.dataPointIndex] || {}).pagu) }
            }
        }));
    }

    function renderSkpd(rows) {
        if (!rows || rows.length === 0) {
            renderEmpty('skpd', $('chartSkpd'), 'Belum ada data Pagu RUP instansi.');
            return;
        }
        render('skpd', $('chartSkpd'), baseOptions({
            chart: Object.assign(baseOptions().chart, { type: 'bar', height: 360 }),
            series: [{ name: 'Pagu RUP', data: rows.map((r) => r.pagu) }],
            colors: ['#2563eb'],
            plotOptions: { bar: { horizontal: true, borderRadius: 4, barHeight: '65%' } },
            dataLabels: {
                enabled: true,
                formatter: (v) => fmtShort(v),
                style: { fontSize: '10px' },
                offsetX: 6
            },
            xaxis: {
                categories: rows.map((r) => r.label.length > 38 ? r.label.slice(0, 36) + '…' : r.label),
                labels: { formatter: (v) => fmtShort(v).replace('Rp ', '') }
            },
            tooltip: {
                y: { formatter: (v, o) => fmtRp(v) + ' (' + fmtInt((rows[o.dataPointIndex] || {}).count) + ' paket)' }
            }
        }));
    }

    function renderAging(a) {
        render('aging', $('chartAging'), baseOptions({
            chart: Object.assign(baseOptions().chart, { type: 'bar', height: 220 }),
            series: [{ name: 'Paket', data: a.values || [] }],
            colors: ['#10b981', '#84cc16', '#f59e0b', '#f97316', '#ef4444'],
            plotOptions: { bar: { distributed: true, borderRadius: 4, columnWidth: '55%' } },
            legend: { show: false },
            dataLabels: { enabled: true },
            xaxis: { categories: a.labels || [] },
            yaxis: { labels: { formatter: (v) => fmtInt(Math.round(v)) } }
        }));

        const list = $('ccOldest');
        const oldest = a.oldest || [];
        list.innerHTML = oldest.length === 0
            ? '<li class="text-muted">Tidak ada paket berjalan.</li>'
            : oldest.map((o) => `
                <li class="d-flex align-items-start gap-2 py-1 border-bottom">
                    <span class="badge ${o.days > 30 ? 'bg-danger' : (o.days > 14 ? 'bg-warning text-dark' : 'bg-success')} font-monospace">${fmtInt(o.days)} hr</span>
                    <div class="min-w-0">
                        <div class="fw-semibold text-truncate" title="${esc(o.name)}">${esc(o.name)}</div>
                        <div class="fs-xs text-muted">${esc(o.no || '#' + o.id)} · ${esc(o.status)}</div>
                    </div>
                </li>`).join('');
    }

    function renderPokja(rows) {
        if (!rows || rows.length === 0) {
            renderEmpty('pokja', $('chartPokja'), 'Belum ada penugasan anggota Pokja pada tahun/instansi ini.');
            return;
        }
        render('pokja', $('chartPokja'), baseOptions({
            chart: Object.assign(baseOptions().chart, { type: 'bar', height: 340, stacked: true }),
            series: [
                { name: 'Aktif', data: rows.map((r) => r.aktif) },
                { name: 'Selesai', data: rows.map((r) => r.selesai) }
            ],
            colors: ['#f59e0b', '#10b981'],
            plotOptions: { bar: { borderRadius: 3, columnWidth: '50%' } },
            xaxis: { categories: rows.map((r) => r.name), labels: { rotate: -35, trim: true } },
            yaxis: { labels: { formatter: (v) => fmtInt(Math.round(v)) } },
            tooltip: { y: { formatter: (v) => fmtInt(v) + ' paket' } }
        }));
    }

    // ------------------------------------------------------------------
    // Antrean & aktivitas (HTML)
    // ------------------------------------------------------------------
    function renderQueue(q) {
        const box = $('ccQueue');
        const items = (q && q.items) || [];
        if (items.length === 0) {
            box.innerHTML = '<div class="cc-empty">Tidak ada antrean.</div>';
            return;
        }
        box.innerHTML = items.map((i) => `
            <a href="/paket" class="cc-queue-item">
                <span class="d-flex align-items-center gap-2">
                    <span class="rounded-circle bg-${esc(i.color)}" style="width:8px;height:8px;display:inline-block;"></span>
                    <span class="fs-sm">${esc(i.label)}</span>
                </span>
                <span class="badge bg-${esc(i.color)}${i.color === 'warning' ? ' text-dark' : ''} rounded-pill fs-sm">${fmtInt(i.count)}</span>
            </a>`).join('');
    }

    function renderActivity(rows) {
        const box = $('ccActivity');
        if (!rows || rows.length === 0) {
            box.innerHTML = '<div class="cc-empty">Belum ada catatan pada paket.</div>';
            return;
        }
        box.innerHTML = rows.map((r) => `
            <div class="cc-activity-item mb-3">
                <div class="d-flex flex-wrap align-items-center gap-1 fs-xs text-muted">
                    <strong class="text-body-emphasis">${esc(r.user || '-')}</strong>
                    <span class="badge bg-secondary-subtle text-secondary">${esc(r.role || '')}</span>
                    <span class="ms-auto font-monospace">${esc(r.time)}</span>
                </div>
                <div class="fs-sm fw-semibold text-truncate" title="${esc(r.paket)}">${esc(r.paket || '-')}</div>
                <div class="fs-xs text-muted mb-1">Tahap: ${esc(r.status)}</div>
                <div class="fs-sm">${esc(r.note)}</div>
            </div>`).join('');
    }

    // ------------------------------------------------------------------
    // Loader
    // ------------------------------------------------------------------
    function renderAll(d) {
        lastData = d;
        $('ccGenerated').textContent = d.generated || '-';
        renderKpi(d.kpi || {});
        renderTrend(d.monthly || {});
        renderPipeline(d.pipeline || {});
        renderDonut('jenis', $('chartJenis'), d.jenis || [], 'count');
        renderMetode(d.metode || []);
        renderDonut('sumber', $('chartSumber'), d.sumber || [], 'pagu');
        renderSkpd(d.topSkpd || []);
        renderAging(d.aging || {});
        renderPokja(d.pokja || []);
        renderQueue(d.myQueue);
        renderActivity(d.activity || []);
    }

    function load() {
        const root = $('ccRoot');
        const err = $('ccError');
        const params = new URLSearchParams();
        params.set('tahun', $('ccTahun').value);
        if ($('ccSkpd')) params.set('skpd_id', $('ccSkpd').value);

        root.classList.add('cc-loading');
        err.classList.add('d-none');

        fetch('/dashboard-control-center/data?' + params.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
            .then((r) => {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.json();
            })
            .then((d) => {
                if (d.status !== 'success') throw new Error(d.message || 'Gagal memuat data');
                renderAll(d);
            })
            .catch((e) => {
                err.textContent = 'Gagal memuat data dashboard: ' + e.message;
                err.classList.remove('d-none');
            })
            .finally(() => root.classList.remove('cc-loading'));
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (typeof ApexCharts === 'undefined') {
            $('ccError').textContent = 'Library grafik (ApexCharts) gagal dimuat.';
            $('ccError').classList.remove('d-none');
            return;
        }

        $('ccTahun').addEventListener('change', load);
        if ($('ccSkpd')) $('ccSkpd').addEventListener('change', load);
        $('ccRefresh').addEventListener('click', load);

        document.querySelectorAll('input[name="ccTrendMode"]').forEach((r) => {
            r.addEventListener('change', () => lastData && renderTrend(lastData.monthly || {}));
        });

        // Render ulang saat tema terang/gelap diganti
        new MutationObserver(() => lastData && renderAll(lastData))
            .observe(document.documentElement, { attributes: true, attributeFilter: ['data-bs-theme'] });

        load();
    });
})();
