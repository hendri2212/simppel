<?php /* Modal & skrip alur paket: aksi tahapan (termasuk di detail modal), catatan, pokja, dokumen lelang, hasil lelang, LPSE. */ ?>

<!-- MODAL: Catatan untuk aksi tahapan -->
<div class="modal fade" id="wfNoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wfNoteTitle">Aksi Paket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted fs-sm" id="wfNoteDesc"></p>
                <div class="alert alert-danger py-2 d-none" id="wfNoteAlert"></div>
                <label class="form-label fw-semibold" for="wfNoteText">Catatan <span id="wfNoteOpt" class="text-muted fw-normal"></span></label>
                <textarea class="form-control" id="wfNoteText" rows="4" maxlength="2000" placeholder="Tulis alasan pengembalian / catatan koreksi untuk PPK..."></textarea>
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

<!-- MODAL: Kelola paket (catatan, pokja, dokumen lelang, hasil) -->
<div class="modal fade" id="wfManageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="wfManageTitle">Kelola Paket</h5>
                    <div class="fs-xs text-muted" id="wfManageSub"></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="alert d-none py-2" id="wfManageAlert" role="alert"></div>
                <ul class="nav nav-tabs mb-3" id="wfTabs" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#wfTabCatatan" type="button">Catatan</button></li>
                    <li class="nav-item" id="wfNavPokja"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#wfTabPokja" type="button">Pokja</button></li>
                    <li class="nav-item" id="wfNavDokumen"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#wfTabDokumen" type="button">Dokumen Lelang</button></li>
                    <li class="nav-item" id="wfNavHasil"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#wfTabHasil" type="button">Hasil Lelang</button></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="wfTabCatatan"></div>
                    <div class="tab-pane fade" id="wfTabPokja"></div>
                    <div class="tab-pane fade" id="wfTabDokumen"></div>
                    <div class="tab-pane fade" id="wfTabHasil"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'}[c]));
        const $ = id => document.getElementById(id);
        const fmtDate = d => d ? new Date(d.replace(' ', 'T')).toLocaleString('id-ID') : '';

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
        const noteModal = new bootstrap.Modal($('wfNoteModal'));
        let pending = null;
        let currentDetailPaket = null;

        async function runAction(a, extra) {
            const res = await postForm(`/paket/aksi/${a.action}/${a.id}`, extra);
            if (res.ok) {
                window.location.reload();
            } else {
                $('wfNoteAlert').textContent = res.j.message || 'Gagal memproses aksi.';
                $('wfNoteAlert').classList.remove('d-none');
                if (!$('wfNoteModal').classList.contains('show')) {
                    alert(res.j.message || 'Gagal memproses aksi.');
                    if (['kembalikan', 'sarankaji', 'saranadd'].includes(a.action) && $('tab-catatan-link')) {
                        bootstrap.Tab.getOrCreateInstance($('tab-catatan-link')).show();
                    }
                }
            }
            return res;
        }

        function triggerWorkflowAction(a) {
            if (a.note === 'required' || a.action === 'selesai') {
                pending = a;
                $('wfNoteTitle').textContent = a.label;
                $('wfNoteDesc').textContent = a.confirm;
                $('wfNoteText').value = '';
                $('wfNoteOpt').textContent = a.note === 'required' ? '(wajib)' : '(opsional)';
                $('wfGagal').checked = false;
                $('wfGagalWrap').classList.toggle('d-none', a.action !== 'selesai');
                $('wfNoteAlert').classList.add('d-none');
                noteModal.show();
            } else if (['kembalikan', 'sarankaji', 'saranadd'].includes(a.action)) {
                pending = a;
                $('wfNoteTitle').textContent = a.label;
                $('wfNoteDesc').textContent = a.confirm;
                $('wfNoteText').value = '';
                $('wfNoteOpt').textContent = '(kosongkan jika sudah menambah catatan di tab Catatan)';
                $('wfGagal').checked = false;
                $('wfGagalWrap').classList.add('d-none');
                $('wfNoteAlert').classList.add('d-none');
                noteModal.show();
            } else if (confirm(a.confirm)) {
                runAction(a);
            }
        }

        document.querySelectorAll('.btn-wf').forEach(btn => {
            btn.addEventListener('click', function () {
                if (btn.classList.contains('disabled')) return;
                triggerWorkflowAction({
                    id: btn.dataset.id,
                    action: btn.dataset.action,
                    label: btn.dataset.label,
                    note: btn.dataset.note,
                    confirm: btn.dataset.confirm
                });
            });
        });

        $('wfNoteSubmit').addEventListener('click', async function () {
            if (!pending) return;
            const text = $('wfNoteText').value.trim();
            if (pending.note === 'required' && text.length < 3) {
                $('wfNoteAlert').textContent = 'Catatan wajib diisi (minimal 3 karakter).';
                $('wfNoteAlert').classList.remove('d-none');
                return;
            }
            this.disabled = true;
            const extra = {catatan: text};
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
                r.ok ? (al.show('success', r.j.message), renderCatatanInto(paketId, boxEl, alertEl, badgeCountEl)) : al.show('danger', r.j.message);
            }));

            boxEl.querySelectorAll('.wf-catatan-del').forEach(b => b.addEventListener('click', async () => {
                if (!confirm('Hapus catatan ini?')) return;
                const r = await postForm(`/paket/catatan/delete/${b.dataset.id}`);
                r.ok ? (al.show('success', r.j.message), renderCatatanInto(paketId, boxEl, alertEl, badgeCountEl)) : al.show('danger', r.j.message);
            }));

            const addBtn = boxEl.querySelector('.wf-add-catatan-btn');
            if (addBtn) {
                addBtn.addEventListener('click', async () => {
                    const txt = boxEl.querySelector('.wf-new-catatan-text').value;
                    addBtn.disabled = true;
                    const r = await postForm('/paket/catatan/store', {paket_id: paketId, isi_catatan: txt});
                    addBtn.disabled = false;
                    r.ok ? (al.show('success', r.j.message), renderCatatanInto(paketId, boxEl, alertEl, badgeCountEl)) : al.show('danger', r.j.message);
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
                r.ok ? (al.show('success', r.j.message), renderPokjaInto(paketObj, boxEl, alertEl, badgeCountEl)) : al.show('danger', r.j.message);
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
                    r.ok ? (al.show('success', r.j.message), renderPokjaInto(paketObj, boxEl, alertEl, badgeCountEl)) : al.show('danger', r.j.message);
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
                r.ok ? (al.show('success', r.j.message), renderDokumenInto(paketObj, boxEl, alertEl, badgeCountEl)) : al.show('danger', r.j.message);
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
                    r.ok ? (al.show('success', r.j.message), renderDokumenInto(paketObj, boxEl, alertEl, badgeCountEl)) : al.show('danger', r.j.message);
                });
            }
        }

        // ---------- 4. Render Hasil Lelang ----------
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
                        Object.assign(paketObj, data);
                        al.show('success', r.j.message);
                    } else {
                        al.show('danger', r.j.message);
                    }
                });
            }
        }

        // ---------- Integrasi dengan Detail Paket Modal (Semua Role) ----------
        document.addEventListener('paket:detail-opened', function (ev) {
            const p = ev.detail;
            if (!p) return;
            currentDetailPaket = p;

            const st = parseInt(p.status_paket || 0, 10);

            // Reset alert di masing-masing tab
            ['detailCatatanAlert', 'detailPokjaAlert', 'detailDokumenAlert', 'detailHasilAlert'].forEach(id => {
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

            // Render tombol aksi di footer modal detail:
            // - Aksi transisi status (Pilih Paket, Verifikasi, Terima, Saran Distribusi, Distribusi, Saran Kaji, Tayangkan Paket, dll.)
            // - Tombol khusus Admin Agency: "Sudah di Proses" (Room LPSE) & "Surat Tugas"
            const btnWrap = $('modalWorkflowActionButtons');
            if (btnWrap) {
                btnWrap.innerHTML = '';
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
                            confirm: wa.confirm || ''
                        });
                    });
                    btnWrap.appendChild(b);
                });

                // Langkah 3A: Tombol "Sudah di Proses" untuk Admin Agency (buat Room LPSE)
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
        });

        // ---------- Modal kelola (tetap didukung dari tombol Kelola pada baris tabel) ----------
        const manageModal = new bootstrap.Modal($('wfManageModal'));
        let P = null;

        document.querySelectorAll('.btn-wf-manage').forEach(btn => {
            btn.addEventListener('click', function () {
                P = JSON.parse(btn.dataset.paket);
                const st = parseInt(P.status_paket);
                $('wfManageTitle').textContent = P.package_name || ('Paket #' + P.id);
                $('wfManageSub').textContent = (P.no_paket ? 'No. ' + P.no_paket + ' · ' : '') + (P.status_label || '');
                $('wfNavPokja').classList.toggle('d-none', st < 4);
                $('wfNavDokumen').classList.toggle('d-none', st < 6);
                $('wfNavHasil').classList.toggle('d-none', st < 9);
                $('wfManageAlert').classList.add('d-none');
                bootstrap.Tab.getOrCreateInstance(document.querySelector('#wfTabs .nav-link')).show();
                renderCatatanInto(P.id, $('wfTabCatatan'), $('wfManageAlert'), null);
                renderPokjaInto(P, $('wfTabPokja'), $('wfManageAlert'), null);
                renderDokumenInto(P, $('wfTabDokumen'), $('wfManageAlert'), null);
                renderHasilInto(P, $('wfTabHasil'), $('wfManageAlert'));
                manageModal.show();
            });
        });

        $('wfManageModal').addEventListener('hidden.bs.modal', function () {
            if (P && $('wfManageAlert').classList.contains('alert-success')) window.location.reload();
        });
    });
</script>
