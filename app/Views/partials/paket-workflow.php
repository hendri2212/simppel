<?php /* Modal & skrip alur paket: aksi tahapan, catatan, pokja, dokumen lelang, hasil lelang, LPSE. */ ?>

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
                <textarea class="form-control" id="wfNoteText" rows="4" maxlength="2000"></textarea>
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

        async function runAction(a, extra) {
            const res = await postForm(`/paket/aksi/${a.action}/${a.id}`, extra);
            if (res.ok) {
                window.location.reload();
            } else {
                $('wfNoteAlert').textContent = res.j.message || 'Gagal memproses aksi.';
                $('wfNoteAlert').classList.remove('d-none');
                if (!$('wfNoteModal').classList.contains('show')) alert(res.j.message || 'Gagal memproses aksi.');
            }
            return res;
        }

        document.querySelectorAll('.btn-wf').forEach(btn => {
            btn.addEventListener('click', function () {
                if (btn.classList.contains('disabled')) return;
                const a = {id: btn.dataset.id, action: btn.dataset.action, label: btn.dataset.label, note: btn.dataset.note, confirm: btn.dataset.confirm};
                if (a.note || a.action === 'selesai') {
                    pending = a;
                    $('wfNoteTitle').textContent = a.label;
                    $('wfNoteDesc').textContent = a.confirm;
                    $('wfNoteText').value = '';
                    $('wfNoteOpt').textContent = a.note === 'required' ? '(wajib)' : '(opsional)';
                    $('wfGagal').checked = false;
                    $('wfGagalWrap').classList.toggle('d-none', a.action !== 'selesai');
                    $('wfNoteAlert').classList.add('d-none');
                    noteModal.show();
                } else if (confirm(a.confirm)) {
                    runAction(a);
                }
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

        // ---------- Modal kelola ----------
        const manageModal = new bootstrap.Modal($('wfManageModal'));
        let P = null; // paket aktif

        function flash(type, msg) {
            const el = $('wfManageAlert');
            el.className = 'alert py-2 alert-' + type;
            el.textContent = msg;
        }
        const clearFlash = () => $('wfManageAlert').classList.add('d-none');

        document.querySelectorAll('.btn-wf-manage').forEach(btn => {
            btn.addEventListener('click', function () {
                P = JSON.parse(btn.dataset.paket);
                const st = parseInt(P.status_paket);
                $('wfManageTitle').textContent = P.package_name || ('Paket #' + P.id);
                $('wfManageSub').textContent = (P.no_paket ? 'No. ' + P.no_paket + ' · ' : '') + (P.status_label || '');
                $('wfNavPokja').classList.toggle('d-none', st < 4);
                $('wfNavDokumen').classList.toggle('d-none', st < 6);
                $('wfNavHasil').classList.toggle('d-none', st < 9);
                clearFlash();
                bootstrap.Tab.getOrCreateInstance(document.querySelector('#wfTabs .nav-link')).show();
                loadCatatan(); loadPokja(); loadDokumen(); renderHasil();
                manageModal.show();
            });
        });

        // Catatan
        async function loadCatatan() {
            const box = $('wfTabCatatan');
            box.innerHTML = '<div class="text-muted">Memuat...</div>';
            const res = await api(`/paket/catatan/${P.id}`);
            if (!res.ok) { box.innerHTML = `<div class="text-danger">${esc(res.j.message)}</div>`; return; }
            const names = res.j.statuses || {};
            let html = '';
            if (!res.j.data.length) html += '<div class="text-muted mb-3">Belum ada catatan.</div>';
            res.j.data.forEach(c => {
                html += `<div class="border rounded p-2 mb-2">
                    <div class="fs-xs text-muted">${esc(c.user_name)} (${esc(c.role_name)}) · tahap ${esc(names[c.status_paket] ?? c.status_paket)} · ${esc(fmtDate(c.created_at))}</div>
                    <div class="mt-1" style="white-space:pre-wrap">${esc(c.isi_catatan)}</div>`;
                if (c.isi_jawaban) {
                    html += `<div class="border-start border-3 border-success ps-2 mt-2"><div class="fs-xs text-muted">Jawaban: ${esc(c.jawab_name)} (${esc(c.jawab_role_name)})</div><div style="white-space:pre-wrap">${esc(c.isi_jawaban)}</div></div>`;
                } else if (res.j.can_add) {
                    html += `<div class="input-group input-group-sm mt-2"><input type="text" class="form-control wf-jawab-input" placeholder="Tulis jawaban..."><button class="btn btn-outline-primary wf-jawab-btn" data-id="${c.id}" type="button">Jawab</button></div>`;
                }
                html += '</div>';
            });
            if (res.j.can_add) {
                html += `<div class="mt-3"><label class="form-label fw-semibold">Tambah catatan</label>
                    <textarea class="form-control" id="wfNewCatatan" rows="3"></textarea>
                    <button class="btn btn-primary btn-sm mt-2" id="wfAddCatatan" type="button">Kirim Catatan</button></div>`;
            }
            box.innerHTML = html;
            box.querySelectorAll('.wf-jawab-btn').forEach(b => b.addEventListener('click', async () => {
                const v = b.parentElement.querySelector('.wf-jawab-input').value.trim();
                const r = await postForm(`/paket/catatan/jawab/${b.dataset.id}`, {isi_jawaban: v});
                r.ok ? (clearFlash(), loadCatatan()) : flash('danger', r.j.message);
            }));
            const add = $('wfAddCatatan');
            if (add) add.addEventListener('click', async () => {
                const r = await postForm('/paket/catatan/store', {paket_id: P.id, isi_catatan: $('wfNewCatatan').value});
                r.ok ? (clearFlash(), loadCatatan()) : flash('danger', r.j.message);
            });
        }

        // Pokja
        async function loadPokja() {
            const box = $('wfTabPokja');
            if (parseInt(P.status_paket) < 4) { box.innerHTML = ''; return; }
            const res = await api(`/paket/pokja/${P.id}`);
            if (!res.ok) { box.innerHTML = `<div class="text-danger">${esc(res.j.message)}</div>`; return; }
            const n = res.j.members.length;
            const okSize = res.j.sizes.includes(n);
            let html = `<div class="mb-2 fs-sm">Anggota terpilih: <strong>${n}</strong> <span class="badge ${okSize ? 'bg-success' : 'bg-warning text-dark'}">${okSize ? 'Jumlah sesuai' : 'Harus ' + res.j.sizes.join(' / ') + ' orang'}</span></div>`;
            html += '<ul class="list-group mb-3">';
            if (!n) html += '<li class="list-group-item text-muted">Belum ada anggota.</li>';
            res.j.members.forEach(m => {
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">${esc(m.full_name || m.username)}
                    ${res.j.can_edit ? `<button class="btn btn-sm btn-outline-danger wf-pokja-del" data-id="${m.id}" type="button">Hapus</button>` : ''}</li>`;
            });
            html += '</ul>';
            if (res.j.can_edit) {
                html += `<div class="input-group"><select class="form-select" id="wfPokjaSelect"><option value="">— Pilih personil Pokja —</option>
                    ${res.j.candidates.map(c => `<option value="${c.id}">${esc(c.full_name)}${c.nip ? ' (' + esc(c.nip) + ')' : ''}</option>`).join('')}</select>
                    <button class="btn btn-primary" id="wfPokjaAdd" type="button">Tambah</button></div>`;
            }
            box.innerHTML = html;
            box.querySelectorAll('.wf-pokja-del').forEach(b => b.addEventListener('click', async () => {
                const r = await postForm(`/paket/pokja/delete/${b.dataset.id}`);
                r.ok ? (clearFlash(), loadPokja()) : flash('danger', r.j.message);
            }));
            const add = $('wfPokjaAdd');
            if (add) add.addEventListener('click', async () => {
                const r = await postForm('/paket/pokja/store', {paket_id: P.id, user_id: $('wfPokjaSelect').value});
                r.ok ? (clearFlash(), loadPokja()) : flash('danger', r.j.message);
            });
        }

        // Dokumen lelang
        async function loadDokumen() {
            const box = $('wfTabDokumen');
            if (parseInt(P.status_paket) < 6) { box.innerHTML = ''; return; }
            const res = await api(`/paket/dokumen/${P.id}`);
            if (!res.ok) { box.innerHTML = `<div class="text-danger">${esc(res.j.message)}</div>`; return; }
            let html = '<ul class="list-group mb-3">';
            if (!res.j.data.length) html += '<li class="list-group-item text-muted">Belum ada dokumen lelang.</li>';
            res.j.data.forEach(d => {
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="${esc(d.file_url)}">${esc(d.nama_dokumen)}</a>
                    <span>${parseInt(d.selesai) === 1 ? '<span class="badge bg-secondary">Terkunci</span>' : (res.j.can_edit ? `<button class="btn btn-sm btn-outline-danger wf-dok-del" data-id="${d.id}" type="button">Hapus</button>` : '')}</span></li>`;
            });
            html += '</ul>';
            if (res.j.can_edit) {
                html += `<div class="row g-2"><div class="col-md-5"><input class="form-control" id="wfDokNama" placeholder="Nama dokumen" maxlength="150"></div>
                    <div class="col-md-5"><input class="form-control" type="file" id="wfDokFile"></div>
                    <div class="col-md-2"><button class="btn btn-primary w-100" id="wfDokAdd" type="button">Unggah</button></div></div>`;
            }
            box.innerHTML = html;
            box.querySelectorAll('.wf-dok-del').forEach(b => b.addEventListener('click', async () => {
                if (!confirm('Hapus dokumen ini?')) return;
                const r = await postForm(`/paket/dokumen/delete/${b.dataset.id}`);
                r.ok ? (clearFlash(), loadDokumen()) : flash('danger', r.j.message);
            }));
            const add = $('wfDokAdd');
            if (add) add.addEventListener('click', async () => {
                const f = $('wfDokFile').files[0];
                if (!f) { flash('danger', 'Pilih file terlebih dahulu.'); return; }
                const fd = new FormData();
                fd.append('paket_id', P.id); fd.append('nama_dokumen', $('wfDokNama').value); fd.append('file', f);
                add.disabled = true;
                const r = await api('/paket/dokumen/upload', {method: 'POST', body: fd});
                add.disabled = false;
                r.ok ? (flash('success', r.j.message), loadDokumen()) : flash('danger', r.j.message);
            });
        }

        // Hasil lelang & LPSE
        function renderHasil() {
            const box = $('wfTabHasil');
            if (parseInt(P.status_paket) < 9) { box.innerHTML = ''; return; }
            const ro = !(P.wf && P.wf.hasil);
            const f = (name, label, type = 'text', col = 6) => `<div class="col-md-${col}"><label class="form-label fs-xs">${label}</label>
                <input class="form-control form-control-sm" name="${name}" type="${type}" value="${esc(P[name] ?? '')}" ${ro ? 'disabled' : ''}></div>`;
            let html = `<form id="wfHasilForm" class="row g-2">
                ${f('nama_pemenang', 'Nama Pemenang')}${f('npwp', 'NPWP')}
                <div class="col-12"><label class="form-label fs-xs">Alamat</label><input class="form-control form-control-sm" name="alamat" value="${esc(P.alamat ?? '')}" ${ro ? 'disabled' : ''}></div>
                ${f('nama_penanggung', 'Penanggung Jawab')}${f('nilai_kontrak', 'Nilai Kontrak (Rp)')}
                ${f('tgl_penetapan', 'Tgl Penetapan', 'date')}${f('no_surat', 'No. Surat')}${f('tgl_surat', 'Tgl Surat', 'date')}
            </form>`;
            html += '<div class="mt-3 d-flex gap-2">';
            if (!ro) html += '<button class="btn btn-primary btn-sm" id="wfHasilSave" type="button">Simpan Data Hasil</button>';
            if (P.wf && P.wf.lpse) html += '<button class="btn btn-outline-secondary btn-sm" id="wfLpse" type="button">Tandai Room LPSE Dibuat</button>';
            html += `<span class="ms-auto fs-xs text-muted align-self-center">Room LPSE: ${parseInt(P.is_lpse) === 1 ? 'sudah dibuat' : 'belum'}</span></div>`;
            box.innerHTML = html;

            const save = $('wfHasilSave');
            if (save) save.addEventListener('click', async () => {
                const data = Object.fromEntries(new FormData($('wfHasilForm')).entries());
                const r = await postForm(`/paket/hasil/${P.id}`, data);
                if (r.ok) { Object.assign(P, data); flash('success', r.j.message); } else flash('danger', r.j.message);
            });
            const lp = $('wfLpse');
            if (lp) lp.addEventListener('click', async () => {
                const r = await postForm(`/paket/lpse/${P.id}`);
                r.ok ? window.location.reload() : flash('danger', r.j.message);
            });
        }

        $('wfManageModal').addEventListener('hidden.bs.modal', function () {
            // Muat ulang agar tabel mencerminkan data terbaru (hasil lelang, LPSE, catatan)
            if (P && $('wfManageAlert').classList.contains('alert-success')) window.location.reload();
        });
    });
</script>
