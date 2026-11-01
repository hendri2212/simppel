<!-- MODAL 1: Detail RUP (Modul 1 & Modul 2) -->
<div class="modal fade" id="monevRupModal" tabindex="-1" aria-labelledby="monevRupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-body-tertiary">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary font-monospace" id="mdRupCode">-</span>
                    <h6 class="modal-title fw-bold mb-0" id="monevRupModalLabel">Detail Rencana Umum Pengadaan (RUP)</h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4">
                <h5 class="fw-bold text-body-emphasis mb-1" id="mdRupPackageName">-</h5>
                <p class="text-muted fs-sm mb-3" id="mdRupActivity">-</p>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded-2 bg-body-tertiary border h-100">
                            <div class="fs-xs text-uppercase text-muted fw-bold mb-1">Dinas / Instansi (SKPD)</div>
                            <div class="fw-semibold" id="mdRupSkpd">-</div>
                            <hr class="my-2">
                            <div class="fs-xs text-uppercase text-muted fw-bold mb-1">Pejabat Pembuat Komitmen (PPK)</div>
                            <div class="fw-semibold" id="mdRupPpk">-</div>
                            <div class="fs-xs text-muted font-monospace" id="mdRupPpkNip">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-2 bg-body-tertiary border h-100">
                            <div class="fs-xs text-uppercase text-muted fw-bold mb-1">Pagu Anggaran</div>
                            <div class="fs-5 fw-bold text-primary font-monospace" id="mdRupPagu">Rp 0</div>
                            <hr class="my-2">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="fs-xs text-uppercase text-muted fw-bold">Jenis Pengadaan</div>
                                    <div class="fw-semibold fs-sm" id="mdRupJenis">-</div>
                                </div>
                                <div class="col-6">
                                    <div class="fs-xs text-uppercase text-muted fw-bold">DAK / Non-DAK</div>
                                    <div class="fw-semibold fs-sm" id="mdRupDak">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0 fs-sm">
                                <tbody>
                                    <tr>
                                        <th class="bg-body-tertiary" style="width: 30%;">Metode Pemilihan</th>
                                        <td id="mdRupMetode">-</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-body-tertiary">Sumber Dana</th>
                                        <td id="mdRupSumberDana">-</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-body-tertiary">Jenis Belanja</th>
                                        <td id="mdRupBelanja">-</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-body-tertiary">Lokasi & Volume</th>
                                        <td id="mdRupLokasiVolume">-</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-body-tertiary">Waktu Pekerjaan</th>
                                        <td id="mdRupDurasi">-</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-body-tertiary">Rencana Pengajuan</th>
                                        <td id="mdRupTanggal">-</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-body-tertiary">Uraian / Keterangan</th>
                                        <td id="mdRupDeskripsi">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-body-tertiary py-2">
                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 2: Detail Paket Lelang Komprehensif (Modul 4, 5, 7, 8) -->
<div class="modal fade" id="monevPaketModal" tabindex="-1" aria-labelledby="monevPaketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-body-tertiary">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <span class="badge bg-primary font-monospace" id="mdPaketNo">-</span>
                    <span class="badge bg-info text-white" id="mdPaketStatus">-</span>
                    <h6 class="modal-title fw-bold mb-0 ms-1" id="monevPaketModalLabel">Detail Paket Lelang (e-MONEV)</h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="px-4 pt-3 pb-0 border-bottom bg-body">
                <h5 class="fw-bold text-body-emphasis mb-1" id="mdPaketName">-</h5>
                <div class="text-muted fs-sm mb-3" id="mdPaketActivity">-</div>

                <ul class="nav nav-tabs nav-tabs-clean border-0 gap-2" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-semibold px-3 py-2" data-bs-toggle="tab" data-bs-target="#tabMonevPaketInfo" type="button" role="tab">
                            Rincian Paket & Hasil
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold px-3 py-2" data-bs-toggle="tab" data-bs-target="#tabMonevPaketPokja" type="button" role="tab">
                            Anggota Pokja <span class="badge bg-secondary rounded-pill ms-1" id="mdPaketPokjaCount">0</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold px-3 py-2" data-bs-toggle="tab" data-bs-target="#tabMonevPaketCatatan" type="button" role="tab">
                            Catatan & Riwayat <span class="badge bg-secondary rounded-pill ms-1" id="mdPaketCatatanCount">0</span>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="modal-body p-4">
                <div class="tab-content">
                    <!-- Tab 1: Rincian Paket -->
                    <div class="tab-pane fade show active" id="tabMonevPaketInfo" role="tabpanel">
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <div class="p-3 rounded-2 bg-body-tertiary border h-100">
                                    <div class="fs-xs text-uppercase text-muted fw-bold">Pagu Anggaran RUP</div>
                                    <div class="fs-5 fw-bold text-body-emphasis font-monospace" id="mdPaketPagu">Rp 0</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded-2 bg-body-tertiary border h-100">
                                    <div class="fs-xs text-uppercase text-muted fw-bold">Nilai HPS</div>
                                    <div class="fs-5 fw-bold text-primary font-monospace" id="mdPaketHps">Rp 0</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded-2 bg-body-tertiary border h-100">
                                    <div class="fs-xs text-uppercase text-muted fw-bold">Nilai Kontrak / Pemenang</div>
                                    <div class="fs-5 fw-bold text-success font-monospace" id="mdPaketKontrak">-</div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0 fs-sm">
                                <tbody>
                                    <tr>
                                        <th class="bg-body-tertiary" style="width: 28%;">ID Paket RUP / No. RPP</th>
                                        <td id="mdPaketRupRpp">-</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-body-tertiary">Dinas / Instansi (SKPD)</th>
                                        <td id="mdPaketSkpd">-</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-body-tertiary">PPK</th>
                                        <td id="mdPaketPpk">-</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-body-tertiary">Jenis Pengadaan & DAK</th>
                                        <td id="mdPaketJenisDak">-</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-body-tertiary">Metode Pemilihan & Sumber Dana</th>
                                        <td id="mdPaketMetodeDana">-</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-body-tertiary">Tanggal Pengajuan & Distribusi</th>
                                        <td id="mdPaketTglProses">-</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-body-tertiary">Pemenang Lelang</th>
                                        <td id="mdPaketPemenang">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 2: Anggota Pokja -->
                    <div class="tab-pane fade" id="tabMonevPaketPokja" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-bordered mb-0 fs-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Nama Personil Pokja</th>
                                        <th>NIP</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody id="mdPaketPokjaBody">
                                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada personil Pokja yang ditugaskan.</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 3: Catatan & Riwayat -->
                    <div class="tab-pane fade" id="tabMonevPaketCatatan" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-bordered mb-0 fs-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 140px;">Tanggal</th>
                                        <th style="width: 180px;">Pengirim</th>
                                        <th>Catatan / Uraian</th>
                                        <th>Tanggapan / Jawaban</th>
                                    </tr>
                                </thead>
                                <tbody id="mdPaketCatatanBody">
                                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada catatan pada paket ini.</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-body-tertiary py-2">
                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function formatRupiahMonev(val) {
        const num = parseFloat(val || 0);
        return 'Rp ' + num.toLocaleString('id-ID', { maximumFractionDigits: 0 });
    }

    function openMonevRupDetail(rupId) {
        fetch('/monev/detail-rup/' + rupId, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.status !== 'success' || !res.data) {
                alert(res.message || 'Gagal memuat detail RUP.');
                return;
            }
            const d = res.data;
            document.getElementById('mdRupCode').textContent = 'RUP #' + (d.rup_code || d.id);
            document.getElementById('mdRupPackageName').textContent = d.package_name || '-';
            document.getElementById('mdRupActivity').textContent = 'Kegiatan: ' + (d.activity || '-');
            document.getElementById('mdRupSkpd').textContent = d.skpd_name || '-';
            document.getElementById('mdRupPpk').textContent = d.ppk_name || '-';
            document.getElementById('mdRupPpkNip').textContent = d.ppk_nip ? ('NIP. ' + d.ppk_nip) : '';
            document.getElementById('mdRupPagu').textContent = formatRupiahMonev(d.budget_ceiling);
            document.getElementById('mdRupJenis').textContent = d.jenis_pengadaan_name || '-';
            document.getElementById('mdRupDak').textContent = d.jenis_dak_name || '-';
            document.getElementById('mdRupMetode').textContent = d.metode_pemilihan_name || '-';
            document.getElementById('mdRupSumberDana').textContent = (d.sumber_dana_name || '-') + (d.sumber_dana_detail ? ' (' + d.sumber_dana_detail + ')' : '');
            document.getElementById('mdRupBelanja').textContent = d.jenis_belanja_name || '-';
            document.getElementById('mdRupLokasiVolume').textContent = (d.location || '-') + ' / Vol: ' + (d.volume || '-');
            document.getElementById('mdRupDurasi').textContent = d.work_duration || '-';
            document.getElementById('mdRupTanggal').textContent = d.submission_date || '-';
            document.getElementById('mdRupDeskripsi').textContent = d.description || d.remarks || '-';

            const modal = new bootstrap.Modal(document.getElementById('monevRupModal'));
            modal.show();
        })
        .catch(() => alert('Gagal memuat detail RUP.'));
    }

    function openMonevPaketDetail(paketId) {
        fetch('/monev/detail-paket/' + paketId, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.status !== 'success' || !res.data) {
                alert(res.message || 'Gagal memuat detail paket.');
                return;
            }
            const d = res.data;
            const pokja = res.pokja || [];
            const catatan = res.catatan || [];

            document.getElementById('mdPaketNo').textContent = 'Paket #' + (d.no_paket || d.id);
            document.getElementById('mdPaketStatus').textContent = d.status_label || '-';
            document.getElementById('mdPaketName').textContent = d.package_name || '-';
            document.getElementById('mdPaketActivity').textContent = 'Kegiatan: ' + (d.activity || '-');

            document.getElementById('mdPaketPagu').textContent = formatRupiahMonev(d.pagu_rup);
            document.getElementById('mdPaketHps').textContent = formatRupiahMonev(d.nilai_hps);
            document.getElementById('mdPaketKontrak').textContent = parseFloat(d.nilai_kontrak || 0) > 0
                ? formatRupiahMonev(d.nilai_kontrak)
                : 'Belum Ditetapkan';

            document.getElementById('mdPaketRupRpp').textContent = 'RUP: ' + (d.rup_code || '-') + ' | No. RPP: ' + (d.no_rpp || '-');
            document.getElementById('mdPaketSkpd').textContent = d.skpd_name || '-';
            document.getElementById('mdPaketPpk').textContent = (d.ppk_name || '-') + (d.ppk_nip ? ' (NIP. ' + d.ppk_nip + ')' : '');
            document.getElementById('mdPaketJenisDak').textContent = (d.jenis_pengadaan_name || '-') + ' / ' + (d.jenis_dak_name || '-');
            document.getElementById('mdPaketMetodeDana').textContent = (d.metode_pemilihan_name || '-') + ' / ' + (d.sumber_dana_name || '-');
            document.getElementById('mdPaketTglProses').textContent =
                'Pengajuan: ' + (d.tgl_pengajuan || '-') +
                ' | Distribusi Pokja: ' + (d.tgl_distribusi || '-') +
                ' | Tayang: ' + (d.tgl_tayang || '-');
            document.getElementById('mdPaketPemenang').textContent = d.nama_pemenang
                ? (d.nama_pemenang + (d.npwp ? ' — NPWP: ' + d.npwp : '') + (d.alamat ? ' — ' + d.alamat : ''))
                : '-';

            // Render Pokja
            document.getElementById('mdPaketPokjaCount').textContent = pokja.length;
            const pokjaBody = document.getElementById('mdPaketPokjaBody');
            if (pokja.length === 0) {
                pokjaBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-3">Belum ada personil Pokja yang ditugaskan.</td></tr>';
            } else {
                pokjaBody.innerHTML = pokja.map((p, idx) => `
                    <tr>
                        <td>${idx + 1}</td>
                        <td class="fw-semibold">${p.full_name || p.username || '-'}</td>
                        <td class="font-monospace">${p.nip || '-'}</td>
                        <td>${p.email || '-'}</td>
                    </tr>
                `).join('');
            }

            // Render Catatan
            document.getElementById('mdPaketCatatanCount').textContent = catatan.length;
            const catatanBody = document.getElementById('mdPaketCatatanBody');
            if (catatan.length === 0) {
                catatanBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-3">Belum ada catatan pada paket ini.</td></tr>';
            } else {
                catatanBody.innerHTML = catatan.map(c => `
                    <tr>
                        <td class="fs-xs text-muted">${c.tgl_catatan || c.created_at || '-'}</td>
                        <td>
                            <div class="fw-semibold">${c.pengirim_name || '-'}</div>
                            <span class="badge bg-secondary-subtle text-secondary fs-nano">${c.pengirim_role || ''}</span>
                        </td>
                        <td>${c.catatan || '-'}</td>
                        <td>${c.jawaban ? `<div class="text-success fw-medium">${c.jawaban}</div><small class="text-muted">${c.penjawab_name || ''}</small>` : '<span class="text-muted">-</span>'}</td>
                    </tr>
                `).join('');
            }

            const modal = new bootstrap.Modal(document.getElementById('monevPaketModal'));
            modal.show();
        })
        .catch(() => alert('Gagal memuat detail paket.'));
    }
</script>
