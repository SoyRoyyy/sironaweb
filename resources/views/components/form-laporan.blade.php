<div id="dataContainer">
    <div class="data-block mt-4">
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Pilih Kegiatan Utama</label>
                <select class="form-select kegiatanUtama">
                    <option value="">-- Pilih Kegiatan Utama --</option>
                    @foreach($kegiatanUtamas as $utama)
                    <option value="{{ $utama->id }}">{{ $utama->uraian }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Pilih Sub Kegiatan & Rekening</label>
                <select class="form-select subKegiatan">
                    <option value="">-- Pilih Sub Kegiatan --</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>Tanggal</th>
                        <th>No Bukti</th>
                        <th>Uraian</th>
                        <th colspan="3">Pengeluaran</th>
                        <th>Jumlah</th>
                    </tr>
                    <tr>
                        <th colspan="3"></th>
                        <th>Belanja LS</th>
                        <th>Belanja TU</th>
                        <th>Belanja UP</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="laporanBody">
                    <tr class="table-secondary">
                        <td></td>
                        <td></td>
                        <td class="text-start fw-semibold">Saldo Bulan Lalu</td>
                        <td colspan="3"></td>
                        <td class="text-end saldo-value">0</td>
                    </tr>
                    <!-- baris awal -->
                    <tr>
                        <td><input type="date" name="tanggal[]" class="form-control"></td>
                        <td><input type="text" name="no_bukti[]" class="form-control"></td>
                        <td><input type="text" name="uraian[]" class="form-control"></td>
                        <td><input type="number" name="belanja_ls[]" class="form-control"></td>
                        <td><input type="number" name="belanja_tu[]" class="form-control"></td>
                        <td><input type="number" name="belanja_up[]" class="form-control"></td>
                        <td class="jumlah-cell text-end"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tombol tambah baris -->
        <button type="button" class="btn btn-sm btn-outline-success addRowBtn mt-2">
            <i class="fas fa-plus"></i> Tambah Baris
        </button>

        <hr>
    </div>
</div>

<!-- Tombol tambah blok -->
<div class="mt-2 d-flex justify-content-between">
    <button type="button" class="btn btn-sm btn-outline-success" id="addBlockBtn">
        <i class="fas fa-plus-circle"></i> Tambah Form
    </button>
    <button type="button" class="btn btn-sm btn-outline-success" id="previewBtn">
        <i class="fas fa-eye"></i> Preview
    </button>
</div>



<script>
    // Dropdown kegiatan utama -> sub kegiatan atas
    document.addEventListener('change', function(e){
        if (e.target.classList.contains('kegiatanUtama')) {
            let kegiatanId = e.target.value;
            let subSelect = e.target.closest('.data-block').querySelector('.subKegiatan');
            subSelect.innerHTML = '<option>Loading...</option>';
            if (kegiatanId) {
                fetch(`/kegiatan-utama/${kegiatanId}/sub-kegiatan`)
                    .then(res => res.json())
                    .then(data => {
                        let options = '<option value="">-- Pilih Sub Kegiatan --</option>';
                        data.forEach(sub => {
                            if (sub.sub_rekening?.length) {
                                sub.sub_rekening.forEach(rek => {
                                    options += `<option value="${rek.id}" data-jumlah="${rek.jumlah}">
                                        ${rek.no_rek} - ${rek.uraian}
                                    </option>`;
                                });
                            } else {
                                options += `<option value="${sub.id}" data-jumlah="${sub.jumlah}">
                                    ${sub.no_rek ?? ''} - ${sub.uraian}
                                </option>`;
                            }
                        });
                        subSelect.innerHTML = options;
                    });
            } else {
                subSelect.innerHTML = '<option value="">-- Pilih Sub Kegiatan --</option>';
            }
        }
    });

  // Set saldo bulan lalu
document.addEventListener('change', function(e){
    if (e.target.classList.contains('subKegiatan')) {
        let selected = e.target.options[e.target.selectedIndex];
        let jumlah = parseFloat(selected.dataset.jumlah || 0);
        e.target.closest('.data-block').querySelector('.saldo-value').innerText =
            jumlah.toLocaleString('id-ID');
    }
});

// Jika subKegiatanRow (baris baru) dipilih -> isi jumlah
document.addEventListener('change', function(e){
    if (e.target.classList.contains('subKegiatanRow')) {
        let jumlah = parseFloat(e.target.options[e.target.selectedIndex].dataset.jumlah || 0);
        e.target.closest('.baris-wrapper').querySelector('.jumlah-cell').innerText =
            jumlah.toLocaleString('id-ID');
    }
});


    // Tambah baris baru (dengan select di atas & tombol hapus)
    document.addEventListener('click', function(e){
        if (e.target.classList.contains('addRowBtn')) {
            let block = e.target.closest('.data-block');
            let kegiatanId = block.querySelector('.kegiatanUtama').value;

            let tbody = block.querySelector('.laporanBody');

            let wrapper = document.createElement('div');
            wrapper.classList.add('baris-wrapper', 'mt-3', 'border', 'rounded', 'p-2', 'bg-light');

            let topControls = document.createElement('div');
            topControls.classList.add('d-flex','justify-content-end','gap-2','mb-2');
            topControls.innerHTML = `
                <select class="form-select form-select-sm subKegiatanRow" style="width:250px;">
                    <option>-- Pilih Sub Kegiatan --</option>
                </select>
                <button type="button" class="btn btn-sm btn-danger removeRowBtn">
                    <i class="fas fa-trash"></i>
                </button>
            `;

            let table = document.createElement('table');
            table.classList.add('table','table-borderless','mb-0');
            let innerTbody = document.createElement('tbody');
            innerTbody.innerHTML = `
                <tr>
                    <td><input type="date" name="tanggal[]" class="form-control"></td>
                    <td><input type="text" name="no_bukti[]" class="form-control"></td>
                    <td><input type="text" name="uraian[]" class="form-control"></td>
                    <td><input type="number" name="belanja_ls[]" class="form-control"></td>
                    <td><input type="number" name="belanja_tu[]" class="form-control"></td>
                    <td><input type="number" name="belanja_up[]" class="form-control"></td>
                    <td class="jumlah-cell text-end"></td>
                </tr>
            `;
            table.appendChild(innerTbody);

            wrapper.appendChild(topControls);
            wrapper.appendChild(table);

            let trContainer = document.createElement('tr');
            let tdContainer = document.createElement('td');
            tdContainer.colSpan = 7;
            tdContainer.appendChild(wrapper);
            trContainer.appendChild(tdContainer);

            tbody.appendChild(trContainer);

            // isi opsi sub kegiatan sesuai kegiatan utama
            if (kegiatanId) {
                fetch(`/kegiatan-utama/${kegiatanId}/sub-kegiatan`)
                    .then(res => res.json())
                    .then(data => {
                        let select = wrapper.querySelector('.subKegiatanRow');
                        let options = '<option value="">-- Pilih Sub Kegiatan --</option>';
                        data.forEach(sub => {
                            if (sub.sub_rekening?.length) {
                                sub.sub_rekening.forEach(rek => {
                                    options += `<option value="${rek.id}" data-jumlah="${rek.jumlah}">
                                        ${rek.no_rek} - ${rek.uraian}
                                    </option>`;
                                });
                            } else {
                                options += `<option value="${sub.id}" data-jumlah="${sub.jumlah}">
                                    ${sub.no_rek ?? ''} - ${sub.uraian}
                                </option>`;
                            }
                        });
                        select.innerHTML = options;
                    });
            }
        }
    });

    // Hapus baris baru
    document.addEventListener('click', function(e){
        if (e.target.closest('.removeRowBtn')) {
            e.target.closest('tr').remove();
        }
    });

    // Tombol tambah blok
    document.getElementById('addBlockBtn').addEventListener('click', function(){
        let container = document.getElementById('dataContainer');
        let firstBlock = container.querySelector('.data-block');
        let clone = firstBlock.cloneNode(true);

        clone.querySelectorAll('input').forEach(i => i.value = '');
        clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
        clone.querySelector('.saldo-value').innerText = '0';
        clone.querySelector('.subKegiatan').innerHTML = '<option value="">-- Pilih Sub Kegiatan --</option>';

        clone.querySelectorAll('tbody.laporanBody tr:not(.table-secondary)').forEach((tr, i) => {
            if (i === 0) return;
            tr.remove();
        });

        container.appendChild(clone);
    });
</script>
