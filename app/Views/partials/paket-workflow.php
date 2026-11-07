<?php /* Modal & skrip alur paket: aksi tahapan, catatan, pokja, dokumen lelang, hasil lelang, dan LPSE terintegrasi pada Detail Paket Modal. */ ?>

<!-- MODAL: Catatan untuk aksi tahapan -->
<div class="modal fade" id="wfNoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="wfNoteTitle">Aksi Paket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted fs-sm" id="wfNoteDesc"></p>
                <div class="alert alert-danger py-2 d-none" id="wfNoteAlert"></div>

                <!-- Input SK Pokja (khusus aksi distribusi) -->
                <div class="d-none mb-3" id="wfDistribusiWrap">
                    <div class="row g-2">
                        <div class="col-7">
                            <label class="form-label fs-xs fw-semibold" for="wfNoSkPokja">Nomor SK Pokja <span class="text-muted">(opsional)</span></label>
                            <input type="text" class="form-control form-control-sm" id="wfNoSkPokja" placeholder="Contoh: 027/01/SK-POKJA/2026" maxlength="100">
                        </div>
                        <div class="col-5">
                            <label class="form-label fs-xs fw-semibold" for="wfTglSkPokja">Tanggal SK Pokja</label>
                            <input type="date" class="form-control form-control-sm" id="wfTglSkPokja">
                        </div>
                    </div>
                </div>

                <!-- Input Upload Surat Penolakan Resmi (khusus aksi batal_tolak) -->
                <div class="d-none mb-3" id="wfBatalTolakWrap">
                    <label class="form-label fs-xs fw-semibold text-danger" for="wfSuratPenolakan">Surat Resmi Penolakan / Pembatalan <span class="text-danger">*</span></label>
                    <input type="file" class="form-control form-control-sm" id="wfSuratPenolakan" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted fs-nano">Wajib unggah surat dinas penolakan/pembatalan resmi (.pdf, .jpg, .png max 20MB).</small>
                </div>

                <label class="form-label fw-semibold" for="wfNoteText">Catatan / Alasan <span id="wfNoteOpt" class="text-muted fw-normal"></span></label>
                <textarea class="form-control" id="wfNoteText" rows="4" maxlength="2000" placeholder="Tulis alasan pengembalian / catatan koreksi..."></textarea>
                <div class="form-check mt-3 d-none" id="wfGagalWrap">
                    <input class="form-check-input" type="checkbox" id="wfGagal">
                    <label class="form-check-label" for="wfGagal">Nyatakan pengadaan gagal (tanpa pemenang)</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="wfNoteSubmit">Proses</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: Konfirmasi Aksi Alur Paket (Pilih Paket, dsb) -->
<div class="modal fade" id="wfConfirmActionModal" tabindex="-1" aria-labelledby="wfConfirmActionModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg overflow-hidden">
            <!-- Strip Aksen Gradien -->
            <div id="wfConfirmTopStrip" style="height: 5px; background: linear-gradient(90deg, #2563eb 0%, #3b82f6 50%, #60a5fa 100%);"></div>

            <!-- STATE 1: KONFIRMASI -->
            <div class="modal-body p-4 text-center" id="wfConfirmBody">
                <div class="modal-ajukan-icon-wrap mb-3" id="wfConfirmIconWrap">
                    <svg class="sa-icon text-primary" style="width: 34px; height: 34px;" id="wfConfirmIcon">
                        <use href="/icons/sprite.svg#check-square"></use>
                    </svg>
                </div>

                <div class="mb-2">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 fs-nano fw-semibold d-inline-flex align-items-center gap-1" id="wfConfirmActionBadge">
                        <svg class="sa-icon text-primary" style="width: 12px; height: 12px;">
                            <use href="/icons/sprite.svg#shield"></use>
                        </svg>
                        <span id="wfConfirmActionBadgeText">Penugasan Verifikator ULP</span>
                    </span>
                </div>

                <h5 class="modal-title fw-bold text-body-emphasis mb-1" id="wfConfirmActionModalLabel">
                    Pilih Paket untuk Diverifikasi?
                </h5>
                <p class="text-secondary fs-sm mb-3 px-1" id="wfConfirmActionDesc">
                    Anda akan mengambil alih paket ini untuk diverifikasi berkas persyaratannya.
                </p>

                <!-- Ringkasan Paket yang Dipilih -->
                <div class="card border bg-body-tertiary bg-opacity-50 rounded-3 mb-3 text-start shadow-2xs">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="fs-nano text-uppercase text-muted fw-bold">Rincian Paket</span>
                            <span class="badge bg-primary font-monospace fs-nano" id="wfConfirmPaketNo">0001</span>
                        </div>
                        <div class="fw-bold text-body-emphasis fs-sm mb-1" id="wfConfirmPaketName">-</div>
                        <div class="text-muted fs-xs mb-2 d-flex align-items-center gap-1" id="wfConfirmPaketActivityWrap">
                            <svg class="sa-icon text-muted" style="width: 12px; height: 12px;"><use href="/icons/sprite.svg#layers"></use></svg>
                            <span id="wfConfirmPaketActivity">-</span>
                        </div>
                        <div class="row g-2 pt-2 border-top">
                            <div class="col-7">
                                <div class="fs-nano text-uppercase text-muted fw-semibold">SKPD / Satuan Kerja</div>
                                <div class="fs-xs fw-semibold text-body-emphasis text-truncate" id="wfConfirmPaketSkpd">-</div>
                            </div>
                            <div class="col-5 text-end">
                                <div class="fs-nano text-uppercase text-muted fw-semibold">Nilai HPS</div>
                                <div class="font-monospace fs-xs fw-bold text-primary" id="wfConfirmPaketHps">Rp 0</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Poin-Poin Konsekuensi / Informasi -->
                <div class="card border border-primary-subtle bg-primary-subtle bg-opacity-10 rounded-3 mb-0 text-start overflow-hidden" id="wfConfirmInfoCard">
                    <div class="card-header bg-primary-subtle bg-opacity-25 border-primary-subtle py-2 px-3 d-flex align-items-center gap-2">
                        <svg class="sa-icon text-primary" style="width: 14px; height: 14px;">
                            <use href="/icons/sprite.svg#info"></use>
                        </svg>
                        <span class="fs-xs fw-bold text-primary-emphasis text-uppercase" id="wfConfirmInfoTitle">Alur Setelah Memilih Paket</span>
                    </div>
                    <div class="card-body p-3" id="wfConfirmInfoList">
                        <div class="d-flex align-items-start gap-2 mb-2">
                            <span class="ajukan-step-badge bg-primary text-white">1</span>
                            <div class="fs-xs text-body">
                                <strong>Antrean Kerja:</strong> Paket akan dialihkan ke tab kerja <strong>"Paket Saya"</strong> untuk proses verifikasi.
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-2 mb-2">
                            <span class="ajukan-step-badge bg-primary text-white">2</span>
                            <div class="fs-xs text-body">
                                <strong>Pemeriksaan Berkas:</strong> Anda dapat meninjau kelengkapan dokumen persyaratan dan memberikan catatan revisi jika diperlukan.
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-2">
                            <span class="ajukan-step-badge bg-primary text-white">3</span>
                            <div class="fs-xs text-body">
                                <strong>Eksklusivitas Penugasan:</strong> Paket terikat pada akun Anda sehingga verifikator ULP lain tidak akan memproses ganda.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Error (jika gagal) -->
                <div class="alert alert-danger d-none py-2 px-3 mt-3 mb-0 fs-xs text-start" id="wfConfirmAlertError"></div>
            </div>

            <!-- STATE 2: NOTIFIKASI SUKSES -->
            <div class="modal-body p-4 text-center d-none" id="wfConfirmSuccessBody">
                <div class="modal-ajukan-success-icon-wrap mb-3">
                    <svg class="sa-icon text-success" style="width: 38px; height: 38px;">
                        <use href="/icons/sprite.svg#check"></use>
                    </svg>
                </div>
                <h5 class="modal-title fw-bold text-body-emphasis mb-1" id="wfConfirmSuccessTitle">
                    Paket Berhasil Dipilih!
                </h5>
                <p class="text-secondary fs-sm mb-3 px-1" id="wfConfirmSuccessDesc">
                    Paket telah masuk ke antrean kerja verifikasi Anda. Memuat ulang data...
                </p>
                <div class="p-3 bg-success bg-opacity-10 border border-success-subtle rounded-3 mb-2">
                    <div class="fs-xs text-success-emphasis fw-semibold">
                        Paket siap diverifikasi pada tab <strong>Paket Saya</strong>.
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-body-tertiary border-top py-2 px-4 d-flex justify-content-between align-items-center" id="wfConfirmFooter">
                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal" id="btnWfConfirmCancel">
                    Batal
                </button>
                <button type="button" class="btn btn-primary btn-sm px-4 d-inline-flex align-items-center gap-2 shadow-xs" id="btnWfConfirmSubmit">
                    <svg class="sa-icon" style="width: 14px; height: 14px;">
                        <use href="/icons/sprite.svg#check-square"></use>
                    </svg>
                    <span id="btnWfConfirmSubmitText">Ya, Pilih Paket Ini</span>
                </button>
            </div>

            <div class="modal-footer bg-body-tertiary border-top py-2 px-4 d-none justify-content-center" id="wfConfirmSuccessFooter">
                <button type="button" class="btn btn-success btn-sm px-4 d-inline-flex align-items-center gap-2" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span>Memuat Ulang...</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'}[c]));
        const $ = id => document.getElementById(id);
        const fmtDate = d => d ? new Date(d.replace(' ', 'T')).toLocaleString('id-ID') : '';
        const fmtShortDate = str => {
            if (!str || str === '0000-00-00') return '-';
            const parts = String(str).split('-');
            return parts.length === 3 ? `${parts[2]}/${parts[1]}/${parts[0]}` : str;
        };
        const fmtRupiah = amount => 'Rp ' + Number(amount || 0).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 2 });

        async function api(url, opts) {
            try {
                const r = await fetch(url, Object.assign({headers: {'X-Requested-With': 'XMLHttpRequest'}}, opts || {}));
                const j = await r.json();
                return {ok: r.ok && j.status === 'success', j};
            } catch (e) {
                return {ok: false, j: {message: 'Terjadi kesalahan jaringan atau server.'}};
            }
        }
        const postForm = (url, obj) => {
            const fd = new FormData();
            Object.entries(obj || {}).forEach(([k, v]) => fd.append(k, v));
            return api(url, {method: 'POST', body: fd});
        };

        // ---------- Aksi tahapan ----------
        const wfNoteModalEl = $('wfNoteModal');
        const noteModal = new bootstrap.Modal(wfNoteModalEl);
        const wfConfirmModalEl = $('wfConfirmActionModal');
        const wfConfirmModal = wfConfirmModalEl ? new bootstrap.Modal(wfConfirmModalEl) : null;
        let pending = null;
        let pendingConfirmAction = null;
        let currentDetailPaket = null;
        let detailDirty = false;

        if (wfNoteModalEl) {
            wfNoteModalEl.addEventListener('show.bs.modal', function () {
                wfNoteModalEl.style.zIndex = '1065';
                setTimeout(() => {
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    if (backdrops.length > 1) {
                        backdrops[backdrops.length - 1].style.zIndex = '1060';
                    }
                }, 10);
            });
            wfNoteModalEl.addEventListener('hidden.bs.modal', function () {
                const detailModal = $('detailPaketModal');
                if (detailModal && detailModal.classList.contains('show')) {
                    document.body.classList.add('modal-open');
                }
            });
        }

        if (wfConfirmModalEl) {
            wfConfirmModalEl.addEventListener('show.bs.modal', function () {
                wfConfirmModalEl.style.zIndex = '1065';
                setTimeout(() => {
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    if (backdrops.length > 1) {
                        backdrops[backdrops.length - 1].style.zIndex = '1060';
                    }
                }, 10);
            });
            wfConfirmModalEl.addEventListener('hidden.bs.modal', function () {
                const detailModal = $('detailPaketModal');
                if (detailModal && detailModal.classList.contains('show')) {
                    document.body.classList.add('modal-open');
                }
            });
        }

        async function runAction(a, extra) {
            let res;
            if (extra instanceof FormData) {
                res = await api(`/paket/aksi/${a.action}/${a.id}`, {method: 'POST', body: extra});
            } else {
                res = await postForm(`/paket/aksi/${a.action}/${a.id}`, extra);
            }
            if (res.ok) {
                window.location.reload();
            } else {
                $('wfNoteAlert').textContent = res.j.message || 'Gagal memproses aksi.';
                $('wfNoteAlert').classList.remove('d-none');
                if (!$('wfNoteModal').classList.contains('show')) {
                    if (['kembalikan', 'sarankaji', 'saranadd'].includes(a.action) && $('tab-catatan-link')) {
                        bootstrap.Tab.getOrCreateInstance($('tab-catatan-link')).show();
                    }
                }
            }
            return res;
        }

        function openWfConfirmModal(a) {
            if (!wfConfirmModal) {
                runAction(a);
                return;
            }

            pendingConfirmAction = a;
            const p = a.paket || currentDetailPaket || {};

            // Reset tampilan State 1 (Confirm) dan State 2 (Success)
            $('wfConfirmBody').classList.remove('d-none');
            $('wfConfirmFooter').classList.remove('d-none');
            $('wfConfirmFooter').classList.add('d-flex');
            $('wfConfirmSuccessBody').classList.add('d-none');
            $('wfConfirmSuccessFooter').classList.add('d-none');
            $('wfConfirmSuccessFooter').classList.remove('d-flex');

            const alertError = $('wfConfirmAlertError');
            if (alertError) {
                alertError.classList.add('d-none');
                alertError.textContent = '';
            }

            const btnSubmit = $('btnWfConfirmSubmit');
            if (btnSubmit) {
                btnSubmit.disabled = false;
            }
            const btnCancel = $('btnWfConfirmCancel');
            if (btnCancel) {
                btnCancel.disabled = false;
            }

            // Isi Data Paket
            const noPaket = p.no_paket && String(p.no_paket).trim() !== '' ? p.no_paket : (a.id ? ('ID #' + a.id) : '-');
            $('wfConfirmPaketNo').textContent = noPaket;
            $('wfConfirmPaketName').textContent = p.package_name || a.label || 'Paket Pengadaan';

            const actWrap = $('wfConfirmPaketActivityWrap');
            const actSpan = $('wfConfirmPaketActivity');
            const activityText = (p.activity || '').trim();
            const packageNameText = (p.package_name || '').trim();
            if (actWrap && actSpan) {
                if (activityText && activityText !== '-' && activityText.toLowerCase() !== packageNameText.toLowerCase()) {
                    actSpan.textContent = activityText;
                    actWrap.classList.remove('d-none');
                } else {
                    actWrap.classList.add('d-none');
                }
            }

            const skpdName = p.skpd_name || p.skpd_abbreviation || '-';
            $('wfConfirmPaketSkpd').textContent = skpdName;
            const hpsVal = parseFloat(p.nilai_hps || 0);
            $('wfConfirmPaketHps').textContent = hpsVal > 0 ? fmtRupiah(hpsVal) : '-';

            // Kustomisasi khusus jika aksi adalah "pilih" (Admin ULP)
            if (a.action === 'pilih') {
                $('wfConfirmTopStrip').style.background = 'linear-gradient(90deg, #2563eb 0%, #3b82f6 50%, #60a5fa 100%)';
                $('wfConfirmActionBadgeText').textContent = 'Penugasan Verifikator ULP';
                $('wfConfirmActionModalLabel').textContent = 'Pilih Paket untuk Diverifikasi?';
                $('wfConfirmActionDesc').textContent = 'Anda akan mengambil alih paket ini sebagai verifikator penanggung jawab kelengkapan berkas.';
                $('btnWfConfirmSubmitText').textContent = 'Ya, Pilih Paket Ini';
                $('wfConfirmInfoCard').classList.remove('d-none');
            } else {
                $('wfConfirmTopStrip').style.background = 'linear-gradient(90deg, #10b981 0%, #059669 100%)';
                $('wfConfirmActionBadgeText').textContent = 'Konfirmasi Aksi: ' + a.label;
                $('wfConfirmActionModalLabel').textContent = a.label + '?';
                $('wfConfirmActionDesc').textContent = a.confirm || 'Apakah Anda yakin ingin memproses tahapan pengadaan ini?';
                $('btnWfConfirmSubmitText').textContent = 'Ya, ' + a.label;
                $('wfConfirmInfoCard').classList.add('d-none');
            }

            wfConfirmModal.show();
        }

        const btnWfConfirmSubmit = $('btnWfConfirmSubmit');
        if (btnWfConfirmSubmit) {
            btnWfConfirmSubmit.addEventListener('click', async function () {
                if (!pendingConfirmAction) return;

                const btnSubmit = this;
                const btnCancel = $('btnWfConfirmCancel');
                const alertError = $('wfConfirmAlertError');

                btnSubmit.disabled = true;
                if (btnCancel) btnCancel.disabled = true;
                btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memproses...';

                if (alertError) alertError.classList.add('d-none');

                const a = pendingConfirmAction;
                const res = await postForm(`/paket/aksi/${a.action}/${a.id}`);

                if (res.ok) {
                    // Transisi State 2 (Success)
                    $('wfConfirmBody').classList.add('d-none');
                    $('wfConfirmFooter').classList.add('d-none');
                    $('wfConfirmFooter').classList.remove('d-flex');

                    if (a.action === 'pilih') {
                        $('wfConfirmSuccessTitle').textContent = 'Paket Berhasil Dipilih!';
                        $('wfConfirmSuccessDesc').textContent = 'Paket telah masuk ke antrean kerja verifikasi Anda. Memuat ulang data...';
                    } else {
                        $('wfConfirmSuccessTitle').textContent = 'Aksi Berhasil Diproses!';
                        $('wfConfirmSuccessDesc').textContent = (res.j && res.j.message) ? res.j.message : 'Tahapan paket telah berhasil diperbarui.';
                    }

                    $('wfConfirmSuccessBody').classList.remove('d-none');
                    $('wfConfirmSuccessFooter').classList.remove('d-none');
                    $('wfConfirmSuccessFooter').classList.add('d-flex');

                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                } else {
                    btnSubmit.disabled = false;
                    if (btnCancel) btnCancel.disabled = false;
                    btnSubmit.innerHTML = `<svg class="sa-icon" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#check-square"></use></svg> <span>${$('btnWfConfirmSubmitText').textContent}</span>`;

                    if (alertError) {
                        alertError.textContent = (res.j && res.j.message) ? res.j.message : 'Gagal memproses aksi. Silakan coba lagi.';
                        alertError.classList.remove('d-none');
                    }
                }
            });
        }

        function triggerWorkflowAction(a) {
            if ($('wfDistribusiWrap')) $('wfDistribusiWrap').classList.add('d-none');
            if ($('wfBatalTolakWrap')) $('wfBatalTolakWrap').classList.add('d-none');
            if ($('wfGagalWrap')) $('wfGagalWrap').classList.add('d-none');
            if ($('wfNoteAlert')) $('wfNoteAlert').classList.add('d-none');
            if ($('wfNoteText')) $('wfNoteText').value = '';

            if (a.action === 'batal_tolak') {
                pending = a;
                $('wfNoteTitle').textContent = a.label;
                $('wfNoteDesc').textContent = a.confirm || 'Anda akan menolak hasil pemilihan penyedia dan membatalkan paket ini (Status Gagal). Masukkan alasan resmi dan unggah surat dinas penolakan/pembatalan.';
                $('wfNoteOpt').textContent = '(wajib alasan & surat resmi)';
                $('wfBatalTolakWrap').classList.remove('d-none');
                if ($('wfSuratPenolakan')) $('wfSuratPenolakan').value = '';
                noteModal.show();
            } else if (a.action === 'distribusi') {
                pending = a;
                $('wfNoteTitle').textContent = a.label;
                $('wfNoteDesc').textContent = a.confirm || 'Terbitkan SK Penugasan Pokja dan distribusikan paket ini ke personil Pokja terpilih.';
                $('wfNoteOpt').textContent = '(opsional)';
                $('wfDistribusiWrap').classList.remove('d-none');
                if ($('wfNoSkPokja')) $('wfNoSkPokja').value = (a.paket && a.paket.no_sk_pokja) || '';
                if ($('wfTglSkPokja')) $('wfTglSkPokja').value = (a.paket && a.paket.tgl_sk_pokja) || new Date().toISOString().split('T')[0];
                noteModal.show();
            } else if (a.note === 'required' || a.action === 'selesai' || a.action === 'ulang') {
                pending = a;
                $('wfNoteTitle').textContent = a.label;
                $('wfNoteDesc').textContent = a.confirm;
                $('wfNoteOpt').textContent = (a.note === 'required' || a.action === 'ulang') ? '(wajib)' : '(opsional)';
                $('wfGagal').checked = false;
                $('wfGagalWrap').classList.toggle('d-none', a.action !== 'selesai');
                noteModal.show();
            } else if (['kembalikan', 'sarankaji', 'saranadd'].includes(a.action)) {
                pending = a;
                $('wfNoteTitle').textContent = a.label;
                $('wfNoteDesc').textContent = a.confirm;
                $('wfNoteOpt').textContent = '(kosongkan jika sudah mencatat di tab BA Review / Catatan)';
                $('wfGagal').checked = false;
                noteModal.show();
            } else {
                openWfConfirmModal(a);
            }
        }

        document.querySelectorAll('.btn-wf').forEach(btn => {
            btn.addEventListener('click', function () {
                if (btn.classList.contains('disabled')) return;
                let pkt = null;
                if (btn.dataset.paket) {
                    try { pkt = JSON.parse(btn.dataset.paket); } catch (e) {}
                }
                triggerWorkflowAction({
                    id: btn.dataset.id,
                    action: btn.dataset.action,
                    label: btn.dataset.label,
                    note: btn.dataset.note,
                    confirm: btn.dataset.confirm,
                    paket: pkt
                });
            });
        });

        $('wfNoteSubmit').addEventListener('click', async function () {
            if (!pending) return;
            const text = $('wfNoteText').value.trim();

            if (pending.action === 'batal_tolak') {
                if (text.length < 3) {
                    $('wfNoteAlert').textContent = 'Alasan penolakan / pembatalan wajib diisi (minimal 3 karakter).';
                    $('wfNoteAlert').classList.remove('d-none');
                    return;
                }
                const fileInput = $('wfSuratPenolakan');
                if (!fileInput || !fileInput.files || !fileInput.files[0]) {
                    $('wfNoteAlert').textContent = 'Surat dinas resmi penolakan/pembatalan wajib diunggah (.pdf, .jpg, .png).';
                    $('wfNoteAlert').classList.remove('d-none');
                    return;
                }
                this.disabled = true;
                const fd = new FormData();
                fd.append('catatan', text);
                fd.append('surat_penolakan', fileInput.files[0]);
                await runAction(pending, fd);
                this.disabled = false;
                return;
            }

            if (pending.action === 'ulang') {
                if (text.length < 3) {
                    $('wfNoteAlert').textContent = 'Alasan pelaksanaan tender ulang wajib diisi (minimal 3 karakter).';
                    $('wfNoteAlert').classList.remove('d-none');
                    return;
                }
            }

            if (pending.note === 'required' && text.length < 3) {
                $('wfNoteAlert').textContent = 'Catatan wajib diisi (minimal 3 karakter).';
                $('wfNoteAlert').classList.remove('d-none');
                return;
            }

            this.disabled = true;
            const extra = {catatan: text};
            if (pending.action === 'distribusi') {
                if ($('wfNoSkPokja')) extra.no_sk_pokja = $('wfNoSkPokja').value.trim();
                if ($('wfTglSkPokja')) extra.tgl_sk_pokja = $('wfTglSkPokja').value;
            }
            if (pending.action === 'selesai' && $('wfGagal').checked) extra.gagal = 1;
            await runAction(pending, extra);
            this.disabled = false;
        });

        function makeAlertHelpers(alertEl) {
            return {
                show: (type, msg) => {
                    if (!alertEl) return;
                    alertEl.className = 'alert py-2 px-3 mb-3 fs-xs alert-' + type;
                    alertEl.textContent = msg;
                },
                hide: () => { if (alertEl) alertEl.classList.add('d-none'); }
            };
        }

        // ---------- 1. Render Catatan ----------
        async function renderCatatanInto(paketId, boxEl, alertEl, badgeCountEl) {
            if (!boxEl) return;
            boxEl.innerHTML = '<div class="text-muted">Memuat catatan...</div>';
            const al = makeAlertHelpers(alertEl);

            const res = await api(`/paket/catatan/${paketId}`);
            if (!res.ok) {
                boxEl.innerHTML = `<div class="text-danger">${esc(res.j.message)}</div>`;
                return;
            }
            const list = res.j.data || [];
            const names = res.j.statuses || {};

            if (badgeCountEl) {
                if (list.length > 0) {
                    badgeCountEl.textContent = list.length;
                    badgeCountEl.classList.remove('d-none');
                } else {
                    badgeCountEl.classList.add('d-none');
                }
            }

            const verifNoteEl = $('modalPaketCatatanVerif');
            if (verifNoteEl) {
                verifNoteEl.textContent = list.length > 0 ? list[list.length - 1].isi_catatan : 'Tidak ada catatan khusus.';
            }

            let html = '';
            if (!list.length) {
                html += '<div class="text-muted mb-3 fst-italic">Belum ada catatan pada paket ini.</div>';
            }
            list.forEach(c => {
                html += `<div class="border rounded p-3 mb-2 bg-body">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div class="fs-xs text-muted">
                            <strong class="text-body">${esc(c.user_name)}</strong> (${esc(c.role_name)}) &bull;
                            Tahap <span class="badge bg-warning-subtle text-warning-emphasis border">${esc(names[c.status_paket] ?? c.status_paket)}</span> &bull;
                            ${esc(fmtDate(c.created_at))}
                        </div>
                        ${c.can_delete ? `<button class="btn btn-xs btn-outline-danger wf-catatan-del" data-id="${c.id}" type="button" title="Hapus Catatan">Hapus</button>` : ''}
                    </div>
                    <div class="mt-2" style="white-space:pre-wrap">${esc(c.isi_catatan)}</div>`;
                if (c.isi_jawaban) {
                    html += `<div class="border-start border-3 border-success ps-3 mt-2 bg-success bg-opacity-10 py-2 rounded-end">
                        <div class="fs-xs text-muted">Jawaban PPK: <strong>${esc(c.jawab_name)}</strong> (${esc(c.jawab_role_name)})</div>
                        <div class="mt-1" style="white-space:pre-wrap">${esc(c.isi_jawaban)}</div>
                    </div>`;
                } else if (c.can_jawab) {
                    html += `<div class="input-group input-group-sm mt-2">
                        <input type="text" class="form-control wf-jawab-input" placeholder="Tulis jawaban tindak lanjut PPK...">
                        <button class="btn btn-primary wf-jawab-btn" data-id="${c.id}" type="button">Simpan Jawaban</button>
                    </div>`;
                } else {
                    html += `<div class="fs-nano text-muted fst-italic mt-2">Belum dijawab oleh PPK</div>`;
                }
                html += '</div>';
            });

            if (res.j.can_add) {
                html += `<div class="mt-3 p-3 bg-body-tertiary rounded border">
                    <label class="form-label fw-semibold fs-xs text-uppercase mb-1">Tambah Catatan / Alasan Pengembalian</label>
                    <textarea class="form-control form-control-sm wf-new-catatan-text" rows="3" placeholder="Ketik catatan pemeriksaan berkas atau saran kaji ulang di sini..."></textarea>
                    <div class="mt-2 d-flex justify-content-end">
                        <button class="btn btn-primary btn-sm wf-add-catatan-btn" type="button">Simpan Catatan</button>
                    </div>
                </div>`;
            }
            boxEl.innerHTML = html;

            boxEl.querySelectorAll('.wf-jawab-btn').forEach(b => b.addEventListener('click', async () => {
                const v = b.parentElement.querySelector('.wf-jawab-input').value.trim();
                const r = await postForm(`/paket/catatan/jawab/${b.dataset.id}`, {isi_jawaban: v});
                r.ok ? (detailDirty = true, al.show('success', r.j.message), renderCatatanInto(paketId, boxEl, alertEl, badgeCountEl)) : al.show('danger', r.j.message);
            }));

            boxEl.querySelectorAll('.wf-catatan-del').forEach(b => b.addEventListener('click', async () => {
                if (!confirm('Hapus catatan ini?')) return;
                const r = await postForm(`/paket/catatan/delete/${b.dataset.id}`);
                r.ok ? (detailDirty = true, al.show('success', r.j.message), renderCatatanInto(paketId, boxEl, alertEl, badgeCountEl)) : al.show('danger', r.j.message);
            }));

            const addBtn = boxEl.querySelector('.wf-add-catatan-btn');
            if (addBtn) {
                addBtn.addEventListener('click', async () => {
                    const txt = boxEl.querySelector('.wf-new-catatan-text').value;
                    addBtn.disabled = true;
                    const r = await postForm('/paket/catatan/store', {paket_id: paketId, isi_catatan: txt});
                    addBtn.disabled = false;
                    r.ok ? (detailDirty = true, al.show('success', r.j.message), renderCatatanInto(paketId, boxEl, alertEl, badgeCountEl)) : al.show('danger', r.j.message);
                });
            }
        }

        // ---------- 2. Render Pokja (Jabatan + Personil, validasi 3/5/7) ----------
        async function renderPokjaInto(paketObj, boxEl, alertEl, badgeCountEl) {
            if (!boxEl) return;
            if (parseInt(paketObj.status_paket) < 4) { boxEl.innerHTML = ''; return; }
            boxEl.innerHTML = '<div class="text-muted">Memuat susunan Pokja...</div>';
            const al = makeAlertHelpers(alertEl);

            const res = await api(`/paket/pokja/${paketObj.id}`);
            if (!res.ok) {
                boxEl.innerHTML = `<div class="text-danger">${esc(res.j.message)}</div>`;
                return;
            }
            const members = res.j.members || [];
            const n = members.length;
            const sizes = res.j.sizes || [3, 5, 7];
            const roles = res.j.roles || ['Ketua', 'Sekretaris', 'Anggota'];
            const okSize = sizes.includes(n);

            if (badgeCountEl) {
                badgeCountEl.textContent = n;
                badgeCountEl.className = `badge rounded-pill fs-nano ms-1 ${okSize ? 'bg-success' : 'bg-warning text-dark'}`;
            }

            // Sinkronkan status tombol Saran Distribusi / Distribusi di footer modal detail
            document.querySelectorAll(`#modalWorkflowActionButtons button[data-action="saran"], #modalWorkflowActionButtons button[data-action="distribusi"]`).forEach(btn => {
                btn.disabled = !okSize;
                btn.title = okSize ? '' : `Jumlah anggota Pokja harus ${sizes.join(', ')} orang (saat ini ${n}).`;
            });

            let html = `<div class="mb-2 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>Anggota terpilih: <strong>${n} orang</strong></div>
                <span class="badge ${okSize ? 'bg-success' : 'bg-warning text-dark'}">${okSize ? 'Jumlah gasal sesuai (3/5/7)' : 'Jumlah pokja harus gasal: ' + sizes.join(' / ') + ' orang'}</span>
            </div>`;

            html += `<div class="table-responsive border rounded mb-3"><table class="table table-sm table-hover align-middle mb-0">
                <thead class="table-light fs-xs text-uppercase"><tr><th style="width:45px" class="text-center">No</th><th style="width:150px">Jabatan</th><th>Nama Personil Pokja</th><th style="width:100px" class="text-end">Aksi</th></tr></thead><tbody>`;
            if (!n) {
                html += `<tr><td colspan="4" class="text-center py-3 text-muted fst-italic">Belum ada personil Pokja yang dipilih.</td></tr>`;
            }
            members.forEach((m, idx) => {
                const roleBadge = m.role === 'Ketua' ? 'bg-primary text-white' : (m.role === 'Sekretaris' ? 'bg-info text-white' : 'bg-secondary-subtle text-secondary border');
                html += `<tr>
                    <td class="text-center text-muted fw-semibold">${idx + 1}</td>
                    <td><span class="badge ${roleBadge}">${esc(m.role || 'Anggota')}</span></td>
                    <td class="fw-semibold">${esc(m.full_name || m.username)}</td>
                    <td class="text-end">${res.j.can_edit ? `<button class="btn btn-xs btn-outline-danger wf-pokja-del" data-id="${m.id}" type="button">Hapus</button>` : '<span class="fs-nano text-muted">-</span>'}</td>
                </tr>`;
            });
            html += `</tbody></table></div>`;

            if (res.j.can_edit) {
                html += `<div class="p-3 bg-body-tertiary rounded border">
                    <label class="form-label fw-semibold fs-xs text-uppercase mb-2">Tambah Personil Pokja</label>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <select class="form-select form-select-sm wf-pokja-role">
                                ${roles.map(r => `<option value="${esc(r)}" ${r === 'Anggota' ? 'selected' : ''}>Jabatan: ${esc(r)}</option>`).join('')}
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select form-select-sm wf-pokja-user">
                                <option value="">— Pilih Personil Pokja —</option>
                                ${(res.j.candidates || []).map(c => `<option value="${c.id}">${esc(c.full_name)}${c.nip ? ' (NIP: ' + esc(c.nip) + ')' : ''}</option>`).join('')}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-sm w-100 wf-pokja-add" type="button">Save</button>
                        </div>
                    </div>
                </div>`;
            }
            boxEl.innerHTML = html;

            boxEl.querySelectorAll('.wf-pokja-del').forEach(b => b.addEventListener('click', async () => {
                if (!confirm('Hapus personil ini dari Pokja paket?')) return;
                const r = await postForm(`/paket/pokja/delete/${b.dataset.id}`);
                if (r.ok) {
                    detailDirty = true;
                    al.show('success', r.j.message);
                    const updatedActions = r.j.workflow_actions || (r.j.data && r.j.data.workflow_actions);
                    if (updatedActions) {
                        paketObj.workflow_actions = updatedActions;
                        if (typeof currentDetailPaket !== 'undefined' && currentDetailPaket) {
                            currentDetailPaket.workflow_actions = updatedActions;
                        }
                        renderWorkflowButtons(paketObj);
                        updateTableRowWorkflowActions(paketObj.id, updatedActions);
                    }
                    renderPokjaInto(paketObj, boxEl, alertEl, badgeCountEl);
                } else {
                    al.show('danger', r.j.message);
                }
            }));

            const add = boxEl.querySelector('.wf-pokja-add');
            if (add) {
                add.addEventListener('click', async () => {
                    const userId = boxEl.querySelector('.wf-pokja-user').value;
                    const roleVal = boxEl.querySelector('.wf-pokja-role').value;
                    if (!userId) { al.show('danger', 'Pilih personil Pokja terlebih dahulu.'); return; }
                    add.disabled = true;
                    const r = await postForm('/paket/pokja/store', {paket_id: paketObj.id, user_id: userId, role: roleVal});
                    add.disabled = false;
                    if (r.ok) {
                        detailDirty = true;
                        al.show('success', r.j.message);
                        const updatedActions = r.j.workflow_actions || (r.j.data && r.j.data.workflow_actions);
                        if (updatedActions) {
                            paketObj.workflow_actions = updatedActions;
                            if (typeof currentDetailPaket !== 'undefined' && currentDetailPaket) {
                                currentDetailPaket.workflow_actions = updatedActions;
                            }
                            renderWorkflowButtons(paketObj);
                            updateTableRowWorkflowActions(paketObj.id, updatedActions);
                        }
                        renderPokjaInto(paketObj, boxEl, alertEl, badgeCountEl);
                    } else {
                        al.show('danger', r.j.message);
                    }
                });
            }
        }

        // ---------- 3. Render Dokumen Lelang ----------
        async function renderDokumenInto(paketObj, boxEl, alertEl, badgeCountEl) {
            if (!boxEl) return;
            if (parseInt(paketObj.status_paket) < 6) { boxEl.innerHTML = ''; return; }
            boxEl.innerHTML = '<div class="text-muted">Memuat dokumen lelang...</div>';
            const al = makeAlertHelpers(alertEl);

            const res = await api(`/paket/dokumen/${paketObj.id}`);
            if (!res.ok) {
                boxEl.innerHTML = `<div class="text-danger">${esc(res.j.message)}</div>`;
                return;
            }
            const list = res.j.data || [];
            if (badgeCountEl) {
                if (list.length > 0) {
                    badgeCountEl.textContent = list.length;
                    badgeCountEl.classList.remove('d-none');
                } else {
                    badgeCountEl.classList.add('d-none');
                }
            }

            let html = '<ul class="list-group mb-3">';
            if (!list.length) html += '<li class="list-group-item text-muted fst-italic">Belum ada dokumen lelang yang diunggah.</li>';
            list.forEach(d => {
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="${esc(d.file_url)}" target="_blank" class="fw-semibold text-decoration-none">${esc(d.nama_dokumen)}</a>
                    <div class="d-flex align-items-center gap-2">
                        <a href="${esc(d.file_url)}" target="_blank" class="btn btn-xs btn-outline-primary">Unduh</a>
                        ${parseInt(d.selesai) === 1
                            ? '<span class="badge bg-secondary">Terkunci</span>'
                            : (res.j.can_edit ? `<button class="btn btn-xs btn-outline-danger wf-dok-del" data-id="${d.id}" type="button">Hapus</button>` : '')}
                    </div>
                </li>`;
            });
            html += '</ul>';

            if (res.j.can_edit) {
                html += `<div class="p-3 bg-body-tertiary rounded border">
                    <label class="form-label fw-semibold fs-xs text-uppercase mb-2">Unggah Dokumen Lelang Baru</label>
                    <div class="row g-2">
                        <div class="col-md-5"><input class="form-control form-control-sm wf-dok-nama" placeholder="Nama dokumen lelang..." maxlength="150"></div>
                        <div class="col-md-5"><input class="form-control form-control-sm wf-dok-file" type="file"></div>
                        <div class="col-md-2"><button class="btn btn-primary btn-sm w-100 wf-dok-add" type="button">Unggah</button></div>
                    </div>
                </div>`;
            }
            boxEl.innerHTML = html;

            boxEl.querySelectorAll('.wf-dok-del').forEach(b => b.addEventListener('click', async () => {
                if (!confirm('Hapus dokumen lelang ini?')) return;
                const r = await postForm(`/paket/dokumen/delete/${b.dataset.id}`);
                r.ok ? (detailDirty = true, al.show('success', r.j.message), renderDokumenInto(paketObj, boxEl, alertEl, badgeCountEl)) : al.show('danger', r.j.message);
            }));

            const add = boxEl.querySelector('.wf-dok-add');
            if (add) {
                add.addEventListener('click', async () => {
                    const fileInput = boxEl.querySelector('.wf-dok-file');
                    const nameInput = boxEl.querySelector('.wf-dok-nama');
                    const f = fileInput.files[0];
                    if (!f) { al.show('danger', 'Pilih file dokumen terlebih dahulu.'); return; }
                    const fd = new FormData();
                    fd.append('paket_id', paketObj.id);
                    fd.append('nama_dokumen', nameInput.value);
                    fd.append('file', f);
                    add.disabled = true;
                    const r = await api('/paket/dokumen/upload', {method: 'POST', body: fd});
                    add.disabled = false;
                    r.ok ? (detailDirty = true, al.show('success', r.j.message), renderDokumenInto(paketObj, boxEl, alertEl, badgeCountEl)) : al.show('danger', r.j.message);
                });
            }
        }

        // ---------- 4. Render Hasil Lelang ----------
        function syncWinnerSection(p) {
            const winnerSec = $('modalWinnerSection');
            if (!winnerSec) return;
            if (p.nama_pemenang && String(p.nama_pemenang).trim() !== '') {
                winnerSec.style.display = '';
                if ($('modalWinnerName')) $('modalWinnerName').textContent = p.nama_pemenang;
                if ($('modalWinnerNpwp')) $('modalWinnerNpwp').textContent = p.npwp || '-';
                if ($('modalWinnerAddress')) $('modalWinnerAddress').textContent = p.alamat || '-';
                if ($('modalWinnerLeader')) $('modalWinnerLeader').textContent = p.nama_penanggung || '-';
                const rawContract = String(p.nilai_kontrak || 0).replace(/[^0-9.,]/g, '').replace(/\./g, '').replace(',', '.');
                if ($('modalWinnerContract')) $('modalWinnerContract').textContent = fmtRupiah(parseFloat(rawContract) || 0);
                if ($('modalWinnerLetterNo')) $('modalWinnerLetterNo').textContent = p.no_surat || '-';
                if ($('modalWinnerDate')) $('modalWinnerDate').textContent = fmtShortDate(p.tgl_penetapan || p.tgl_surat);
            } else {
                winnerSec.style.display = 'none';
            }
        }

        // ---------- 3b. Render Berita Acara Review (BA Review) ----------
        async function renderBaReviewInto(paketObj, boxEl, alertEl, badgeCountEl) {
            if (!boxEl) return;
            if (parseInt(paketObj.status_paket) < 6) { boxEl.innerHTML = ''; return; }
            boxEl.innerHTML = '<div class="text-muted"><span class="spinner-border spinner-border-sm me-1" role="status"></span>Memuat Berita Acara Review...</div>';
            const al = makeAlertHelpers(alertEl);

            const res = await api(`/paket/ba-review/${paketObj.id}`);
            if (!res.ok) {
                boxEl.innerHTML = `<div class="text-danger">${esc(res.j.message)}</div>`;
                return;
            }

            const list = res.j.data || [];
            const canAdd = !!res.j.can_add;
            const isDirect = !!res.j.is_direct;

            if (badgeCountEl) {
                if (list.length > 0) {
                    badgeCountEl.textContent = list.length;
                    badgeCountEl.classList.remove('d-none');
                } else {
                    badgeCountEl.classList.add('d-none');
                }
            }

            let html = '';
            if (list.length === 0) {
                html += `<div class="alert alert-warning py-2 px-3 mb-3 fs-xs d-flex align-items-center gap-2">
                    <svg class="sa-icon text-warning flex-shrink-0" style="width: 16px; height: 16px;"><use href="/icons/sprite.svg#alert-circle"></use></svg>
                    <div>Belum ada Berita Acara Review untuk paket ini. Pokja Pemilihan / Pejabat Pengadaan wajib melakukan penelaahan dokumen dan menerbitkan BA Review sebelum paket dapat dilanjutkan ke pemilihan penyedia atau dikembalikan ke PPK.</div>
                </div>`;
            } else {
                html += '<div class="d-flex flex-column gap-3 mb-3">';
                list.forEach(ba => {
                    const isPerlu = parseInt(ba.perlu_perbaikan) === 1;
                    const badgeClass = isPerlu ? 'bg-warning-subtle text-warning-emphasis border border-warning-subtle' : 'bg-success-subtle text-success-emphasis border border-success-subtle';
                    const iconName = isPerlu ? 'alert-triangle' : 'check-circle';
                    const statusText = isPerlu ? 'Perlu Perbaikan Dokumen (Dikembalikan)' : 'Dokumen Sesuai (Lolos Review)';

                    html += `<div class="card border shadow-2xs">
                        <div class="card-header bg-body-tertiary py-2 px-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary fs-nano fw-bold">Putaran #${esc(ba.putaran)}</span>
                                <span class="fw-semibold fs-xs text-body-emphasis">${ba.nomor_ba ? ('No. BA: ' + esc(ba.nomor_ba)) : 'Berita Acara Review'}</span>
                                <span class="text-muted fs-nano">• ${fmtShortDate(ba.tgl_ba)}</span>
                            </div>
                            <span class="badge ${badgeClass} fs-nano d-inline-flex align-items-center gap-1">
                                <svg class="sa-icon" style="width: 12px; height: 12px;"><use href="/icons/sprite.svg#${iconName}"></use></svg>
                                <span>${statusText}</span>
                            </span>
                        </div>
                        <div class="card-body p-3">
                            <div class="mb-2">
                                <label class="fs-nano text-uppercase text-muted fw-bold d-block mb-1">Hasil Pemeriksaan / Telaah Dokumen:</label>
                                <div class="fs-xs text-body bg-light p-2 rounded border" style="white-space: pre-wrap;">${esc(ba.hasil_pemeriksaan)}</div>
                            </div>`;

                    if (ba.catatan_perbaikan) {
                        html += `<div class="mb-2">
                            <label class="fs-nano text-uppercase text-danger fw-bold d-block mb-1">Catatan Perbaikan Dokumen untuk PPK:</label>
                            <div class="fs-xs text-danger-emphasis bg-danger-subtle bg-opacity-25 p-2 rounded border border-danger-subtle" style="white-space: pre-wrap;">${esc(ba.catatan_perbaikan)}</div>
                        </div>`;
                    }

                    html += `<div class="d-flex align-items-center justify-content-between pt-2 border-top fs-nano text-muted">
                            <div>Reviewer: <strong>${esc(ba.reviewer_name || 'Pokja/Pejabat Pengadaan')}</strong></div>
                            <div>Dicatat: ${fmtDate(ba.created_at)}</div>
                        </div>
                    </div></div>`;
                });
                html += '</div>';
            }

            if (canAdd) {
                const nextRound = list.length + 1;
                const reviewerRole = isDirect ? 'Pejabat Pengadaan' : 'Pokja Pemilihan';
                html += `<div class="p-3 bg-body-tertiary rounded border">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label fw-bold fs-xs text-uppercase mb-0 text-primary">
                            Input Berita Acara Review Dokumen (Putaran #${nextRound})
                        </label>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-nano">${reviewerRole}</span>
                    </div>
                    <form class="wf-ba-form">
                        <div class="row g-2 mb-2">
                            <div class="col-md-7">
                                <label class="form-label fs-xs mb-1">Nomor BA Review <span class="text-muted">(opsional)</span></label>
                                <input type="text" class="form-control form-control-sm wf-ba-nomor" placeholder="Contoh: BA.01/POKJA-ULP/2026" maxlength="100">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fs-xs mb-1">Tanggal BA <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm wf-ba-tgl" value="${new Date().toISOString().split('T')[0]}">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label fs-xs fw-semibold mb-1">Kesimpulan Hasil Review <span class="text-danger">*</span></label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input wf-ba-status" type="radio" name="perlu_perbaikan_${paketObj.id}" id="baStatusSesuai_${paketObj.id}" value="0" checked>
                                    <label class="form-check-label fs-xs fw-medium text-success" for="baStatusSesuai_${paketObj.id}">
                                        <strong>Dokumen Sesuai</strong> (Lolos Review)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input wf-ba-status" type="radio" name="perlu_perbaikan_${paketObj.id}" id="baStatusRevisi_${paketObj.id}" value="1">
                                    <label class="form-check-label fs-xs fw-medium text-warning-emphasis" for="baStatusRevisi_${paketObj.id}">
                                        <strong>Perlu Perbaikan Dokumen</strong> (Dikembalikan ke PPK)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label fs-xs fw-semibold mb-1">Hasil Pemeriksaan / Telaah Dokumen <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm wf-ba-hasil" rows="3" placeholder="Uraikan poin-poin hasil pemeriksaan berkas persyaratan pengadaan..."></textarea>
                        </div>

                        <div class="mb-3 wf-ba-catatan-wrap d-none">
                            <label class="form-label fs-xs fw-semibold mb-1 text-danger">Catatan Perbaikan untuk PPK <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm wf-ba-catatan" rows="3" placeholder="Uraikan secara spesifik dokumen apa saja yang harus diperbaiki oleh PPK..."></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-primary btn-sm wf-ba-save d-inline-flex align-items-center gap-1" type="button">
                                <svg class="sa-icon" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#save"></use></svg>
                                <span>Simpan Berita Acara Review</span>
                            </button>
                        </div>
                    </form>
                </div>`;
            }

            boxEl.innerHTML = html;

            if (canAdd) {
                const radioSesuai = boxEl.querySelector(`#baStatusSesuai_${paketObj.id}`);
                const radioRevisi = boxEl.querySelector(`#baStatusRevisi_${paketObj.id}`);
                const catatanWrap = boxEl.querySelector('.wf-ba-catatan-wrap');
                const btnSave = boxEl.querySelector('.wf-ba-save');

                const syncCatatanWrap = () => {
                    if (radioRevisi && radioRevisi.checked) {
                        catatanWrap.classList.remove('d-none');
                    } else {
                        catatanWrap.classList.add('d-none');
                    }
                };

                if (radioSesuai) radioSesuai.addEventListener('change', syncCatatanWrap);
                if (radioRevisi) radioRevisi.addEventListener('change', syncCatatanWrap);

                if (btnSave) {
                    btnSave.addEventListener('click', async () => {
                        const nomorBa = boxEl.querySelector('.wf-ba-nomor').value.trim();
                        const tglBa = boxEl.querySelector('.wf-ba-tgl').value;
                        const hasilPemeriksaan = boxEl.querySelector('.wf-ba-hasil').value.trim();
                        const catatanPerbaikan = boxEl.querySelector('.wf-ba-catatan').value.trim();
                        const perluPerbaikan = radioRevisi && radioRevisi.checked ? 1 : 0;

                        if (hasilPemeriksaan.length < 5) {
                            al.show('danger', 'Hasil pemeriksaan wajib diisi (minimal 5 karakter).');
                            return;
                        }
                        if (perluPerbaikan === 1 && catatanPerbaikan.length < 3) {
                            al.show('danger', 'Catatan perbaikan wajib diisi jika dokumen memerlukan perbaikan dari PPK.');
                            return;
                        }

                        btnSave.disabled = true;
                        btnSave.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menyimpan...';

                        const r = await postForm('/paket/ba-review/store', {
                            paket_id: paketObj.id,
                            nomor_ba: nomorBa,
                            tgl_ba: tglBa,
                            hasil_pemeriksaan: hasilPemeriksaan,
                            catatan_perbaikan: catatanPerbaikan,
                            perlu_perbaikan: perluPerbaikan
                        });

                        btnSave.disabled = false;
                        btnSave.innerHTML = '<svg class="sa-icon" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#save"></use></svg> <span>Simpan Berita Acara Review</span>';

                        if (r.ok) {
                            detailDirty = true;
                            al.show('success', r.j.message);
                            const updatedActions = r.j.workflow_actions || (r.j.data && r.j.data.workflow_actions);
                            if (updatedActions) {
                                paketObj.workflow_actions = updatedActions;
                                if (typeof currentDetailPaket !== 'undefined' && currentDetailPaket) {
                                    currentDetailPaket.workflow_actions = updatedActions;
                                }
                                renderWorkflowButtons(paketObj);
                                updateTableRowWorkflowActions(paketObj.id, updatedActions);
                            }
                            renderBaReviewInto(paketObj, boxEl, alertEl, badgeCountEl);
                        } else {
                            al.show('danger', r.j.message);
                        }
                    });
                }
            }
        }

        function renderHasilInto(paketObj, boxEl, alertEl) {
            if (!boxEl) return;
            if (parseInt(paketObj.status_paket) < 9) { boxEl.innerHTML = ''; return; }
            const al = makeAlertHelpers(alertEl);
            const ro = !(paketObj.wf && paketObj.wf.hasil);
            const f = (name, label, type = 'text', col = 6) => `<div class="col-md-${col}"><label class="form-label fs-xs">${label}</label>
                <input class="form-control form-control-sm" name="${name}" type="${type}" value="${esc(paketObj[name] ?? '')}" ${ro ? 'disabled' : ''}></div>`;
            let html = `<form class="row g-2 wf-hasil-form">
                ${f('nama_pemenang', 'Nama Pemenang')}${f('npwp', 'NPWP')}
                <div class="col-12"><label class="form-label fs-xs">Alamat</label><input class="form-control form-control-sm" name="alamat" value="${esc(paketObj.alamat ?? '')}" ${ro ? 'disabled' : ''}></div>
                ${f('nama_penanggung', 'Penanggung Jawab')}${f('nilai_kontrak', 'Nilai Kontrak (Rp)')}
                ${f('tgl_penetapan', 'Tgl Penetapan', 'date')}${f('no_surat', 'No. Surat')}${f('tgl_surat', 'Tgl Surat', 'date')}
            </form>`;
            html += '<div class="mt-3 d-flex gap-2 align-items-center">';
            if (!ro) html += '<button class="btn btn-primary btn-sm wf-hasil-save" type="button">Simpan Data Hasil</button>';
            html += `<span class="ms-auto fs-xs text-muted">Status Room LPSE: <strong>${parseInt(paketObj.is_lpse) === 1 ? 'Sudah di Proses' : 'Belum'}</strong></span></div>`;
            boxEl.innerHTML = html;

            const save = boxEl.querySelector('.wf-hasil-save');
            if (save) {
                save.addEventListener('click', async () => {
                    const formEl = boxEl.querySelector('.wf-hasil-form');
                    const data = Object.fromEntries(new FormData(formEl).entries());
                    save.disabled = true;
                    const r = await postForm(`/paket/hasil/${paketObj.id}`, data);
                    save.disabled = false;
                    if (r.ok) {
                        detailDirty = true;
                        Object.assign(paketObj, data);
                        syncWinnerSection(paketObj);
                        al.show('success', r.j.message);
                    } else {
                        al.show('danger', r.j.message);
                    }
                });
            }
        }

        // Sinkronisasi state disabled & tooltip tombol aksi di baris tabel
        function updateTableRowWorkflowActions(paketId, updatedActions) {
            if (!paketId || !Array.isArray(updatedActions)) return;

            const rowLinks = document.querySelectorAll(`.btn-wf[data-id="${paketId}"]`);
            rowLinks.forEach(link => {
                const actionKey = link.dataset.action;
                const wa = updatedActions.find(x => x.key === actionKey);
                if (wa) {
                    if (wa.blocked) {
                        link.classList.add('disabled');
                        link.title = wa.blocked;
                    } else {
                        link.classList.remove('disabled');
                        link.removeAttribute('title');
                    }
                }
            });

            const viewBtns = document.querySelectorAll('.btn-view-paket');
            viewBtns.forEach(btn => {
                try {
                    const parsed = JSON.parse(btn.dataset.paket || '{}');
                    if (parseInt(parsed.id, 10) === parseInt(paketId, 10)) {
                        parsed.workflow_actions = updatedActions;
                        btn.dataset.paket = JSON.stringify(parsed);
                    }
                } catch (e) {}
            });
        }

        // ---------- 4b. Render Tombol Aksi di Modal Footer ----------
        function renderWorkflowButtons(p) {
            const btnWrap = $('modalWorkflowActionButtons');
            if (!btnWrap) return;
            btnWrap.innerHTML = '';
            const st = parseInt(p.status_paket || 0, 10);

            (p.workflow_actions || []).forEach(wa => {
                const b = document.createElement('button');
                b.type = 'button';
                b.dataset.action = wa.key;
                b.className = `btn btn-sm btn-${wa.variant || 'primary'} d-inline-flex align-items-center gap-1`;
                if (wa.blocked) {
                    b.disabled = true;
                    b.title = wa.blocked;
                }
                b.textContent = wa.label;
                b.addEventListener('click', () => {
                    triggerWorkflowAction({
                        id: p.id,
                        action: wa.key,
                        label: wa.label,
                        note: wa.note || '',
                        confirm: wa.confirm || '',
                        paket: p
                    });
                });
                btnWrap.appendChild(b);
            });

            // Tombol khusus Admin Agency: "Sudah di Proses" (Room LPSE)
            if (p.wf && p.wf.lpse) {
                const btnLpse = document.createElement('button');
                btnLpse.type = 'button';
                btnLpse.className = 'btn btn-sm btn-danger d-inline-flex align-items-center gap-1';
                btnLpse.textContent = 'Sudah di Proses (Room LPSE)';
                btnLpse.addEventListener('click', async () => {
                    if (!confirm('Tandai bahwa paket ini sudah dibuatkan Room di LPSE?')) return;
                    btnLpse.disabled = true;
                    const r = await postForm(`/paket/lpse/${p.id}`);
                    if (r.ok) {
                        window.location.reload();
                    } else {
                        btnLpse.disabled = false;
                        alert(r.j.message || 'Gagal memproses Room LPSE.');
                    }
                });
                btnWrap.appendChild(btnLpse);
            }

            // Jika sudah diproses LPSE (is_lpse == 1) dan status >= 6, tampilkan tombol Cetak Surat Tugas Pokja
            if (parseInt(p.is_lpse || 0, 10) === 1 && st >= 6) {
                const btnSt = document.createElement('button');
                btnSt.type = 'button';
                btnSt.className = 'btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1';
                btnSt.textContent = 'Surat Tugas Pokja';
                btnSt.addEventListener('click', () => {
                    window.print();
                });
                btnWrap.appendChild(btnSt);
            }
        }

        // ---------- Integrasi dengan Detail Paket Modal (Semua Role) ----------
        document.addEventListener('paket:detail-opened', function (ev) {
            const p = ev.detail;
            if (!p) return;
            currentDetailPaket = p;
            detailDirty = false;

            const st = parseInt(p.status_paket || 0, 10);

            // Reset alert di masing-masing tab
            ['detailCatatanAlert', 'detailPokjaAlert', 'detailBaReviewAlert', 'detailDokumenAlert', 'detailHasilAlert'].forEach(id => {
                const el = $(id);
                if (el) el.classList.add('d-none');
            });

            // Tab Catatan (tampil saat status >= 2)
            const navCatatan = $('navItemCatatanDetail');
            if (navCatatan) {
                if (st >= 2) {
                    navCatatan.classList.remove('d-none');
                    renderCatatanInto(p.id, $('detailCatatanBox'), $('detailCatatanAlert'), $('badgeCatatanCount'));
                } else {
                    navCatatan.classList.add('d-none');
                }
            }

            // Tab Pokja (tampil saat status >= 4: Admin Distribusi, Kepala ULP, Pokja, Admin Agency, PPK)
            const navPokja = $('navItemPokjaDetail');
            if (navPokja) {
                if (st >= 4) {
                    navPokja.classList.remove('d-none');
                    renderPokjaInto(p, $('detailPokjaBox'), $('detailPokjaAlert'), $('badgePokjaCount'));
                } else {
                    navPokja.classList.add('d-none');
                }
            }

            // Tab BA Review (tampil saat status >= 6)
            const navBaReview = $('navItemBaReviewDetail');
            if (navBaReview) {
                if (st >= 6) {
                    navBaReview.classList.remove('d-none');
                    renderBaReviewInto(p, $('detailBaReviewBox'), $('detailBaReviewAlert'), $('badgeBaReviewCount'));
                } else {
                    navBaReview.classList.add('d-none');
                }
            }

            // Tab Dokumen Lelang (tampil saat status >= 6: terdistribusi ke Pokja)
            const navDokumen = $('navItemDokumenDetail');
            if (navDokumen) {
                if (st >= 6) {
                    navDokumen.classList.remove('d-none');
                    renderDokumenInto(p, $('detailDokumenBox'), $('detailDokumenAlert'), $('badgeDokumenCount'));
                } else {
                    navDokumen.classList.add('d-none');
                }
            }

            // Tab Hasil Lelang (tampil saat status >= 9)
            const navHasil = $('navItemHasilDetail');
            if (navHasil) {
                if (st >= 9) {
                    navHasil.classList.remove('d-none');
                    renderHasilInto(p, $('detailHasilBox'), $('detailHasilAlert'));
                } else {
                    navHasil.classList.add('d-none');
                }
            }

            // Render tombol aksi di footer modal detail
            renderWorkflowButtons(p);
        });

        const detailModalEl = $('detailPaketModal');
        if (detailModalEl) {
            detailModalEl.addEventListener('hidden.bs.modal', function () {
                if (detailDirty) {
                    window.location.reload();
                }
            });
        }
    });
</script>
