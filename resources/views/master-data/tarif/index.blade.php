@extends('layouts.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/master-data.css') }}">
@endpush

@section('content')
<div class="content-wrapper">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">Master Data</h4>
                            <p class="card-description">Tarif Tindakan</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <div class="input-group" style="width: 300px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="searchTable" placeholder="Cari berdasarkan kode, instansi, tindakan..." style="border-left: none;">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="clearSearch" title="Clear Search" style="display: none;">
                                            <i class="ti-close"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#addTarifModal">
                                <i class="ti-plus mr-2"></i> Tambah Data Tarif
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="8%">Kode</th>
                                    <th width="15%">Instansi/Pelaksana</th>
                                    <th width="20%">Tindakan</th>
                                    <th width="25%">Detail</th>
                                    <th width="8%">JS</th>
                                    <th width="8%">JP</th>
                                    <th width="10%">Total</th>
                                    <th width="3%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tarifs as $index => $tarif)
                                <tr>
                                    <td>{{ $tarifs->firstItem() + $index }}</td>
                                    <td>{{ $tarif->kode_tarif }}</td>
                                    <td>
                                        <div class="instansi-info">
                                            <div class="font-weight-bold" title="{{ $tarif->instansi }}">{{ Str::limit($tarif->instansi, 50) }}</div>
                                            <small class="text-muted" title="{{ $tarif->instansi_pelaksana }}">{{ Str::limit($tarif->instansi_pelaksana, 50) }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tindakan-info">
                                            <div class="font-weight-bold" title="{{ $tarif->nama_tindakan }}">{{ Str::limit($tarif->nama_tindakan, 50) }}</div>
                                            <small class="text-muted" title="{{ $tarif->kelompok_tindakan }}">{{ Str::limit($tarif->kelompok_tindakan, 50) }}</small>
                                        </div>
                                    </td>
                                    <td title="{{ $tarif->detail_tindakan }}">{{ Str::limit($tarif->detail_tindakan, 50) }}</td>
                                    <td>{{ number_format($tarif->js, 0, ',', '.') }}</td>
                                    <td>{{ number_format($tarif->jp, 0, ',', '.') }}</td>
                                    <td><strong>{{ number_format($tarif->tarif, 0, ',', '.') }}</strong></td>
                                    <td>
                                        <div class="action-buttons d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary btn-sm btn-action mr-1" data-toggle="modal" data-target="#editTarifModal" onclick="editTarif({{ $tarif->id }})" title="Edit Data">
                                                <i class="ti-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm btn-action" onclick="deleteTarif({{ $tarif->id }})" title="Hapus Data">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada data tarif</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $tarifs->firstItem() }} sampai {{ $tarifs->lastItem() }} dari {{ $tarifs->total() }} data tarif
                        </small>
                        <div>
                            {{ $tarifs->links('custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data Tarif -->
<div class="modal fade" id="addTarifModal" tabindex="-1" aria-labelledby="addTarifModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTarifModalLabel">Tambah Data Tarif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addTarifForm" method="POST" action="{{ route('tarif.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode_tarif">Kode Tarif <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode_tarif') is-invalid @enderror" 
                                       id="kode_tarif" name="kode_tarif" value="{{ old('kode_tarif') }}" required>
                                <small class="form-text text-muted">Contoh: TRF001</small>
                                @error('kode_tarif')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode">Kode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror" 
                                       id="kode" name="kode" value="{{ old('kode') }}" required>
                                <small class="form-text text-muted">Contoh: KT44</small>
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="instansi">Instansi <span class="text-danger">*</span></label>
                                <select class="form-control" id="instansi" name="instansi" required>
                                    <option value="">Pilih Instansi</option>
                                    <option value="Gawat Darurat (IGD)">Gawat Darurat (IGD)</option>
                                    <option value="Rawat Jalan">Rawat Jalan</option>
                                    <option value="Rawat Inap">Rawat Inap</option>
                                    <option value="Laboratorium">Laboratorium</option>
                                    <option value="Radiologi">Radiologi</option>
                                    <option value="Farmasi">Farmasi</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="instansi_pelaksana">Instansi Pelaksana <span class="text-danger">*</span></label>
                                <select class="form-control" id="instansi_pelaksana" name="instansi_pelaksana" required>
                                    <option value="">Pilih Instansi Pelaksana</option>
                                    <option value="Kamar Jenazah">Kamar Jenazah</option>
                                    <option value="Poli Umum">Poli Umum</option>
                                    <option value="Poli Spesialis">Poli Spesialis</option>
                                    <option value="ICU">ICU</option>
                                    <option value="VK">VK</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="kelompok_tindakan">Kelompok Tindakan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kelompok_tindakan" name="kelompok_tindakan" required>
                                <small class="form-text text-muted">Contoh: Kamar Jenazah</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama_tindakan">Nama Tindakan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_tindakan" name="nama_tindakan" required>
                                <small class="form-text text-muted">Contoh: Pelayanan Kamar Jenazah</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="detail_tindakan">Detail Tindakan</label>
                                <textarea class="form-control" id="detail_tindakan" name="detail_tindakan" rows="3"></textarea>
                                <small class="form-text text-muted">Deskripsi detail dari tindakan</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="js">JS (Jasa Sarana) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="js" name="js" min="0" step="1000" required>
                                <small class="form-text text-muted">Dalam Rupiah</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jp">JP (Jasa Pelayanan) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="jp" name="jp" min="0" step="1000" required>
                                <small class="form-text text-muted">Dalam Rupiah</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tarif">Total Tarif <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="tarif" name="tarif" min="0" step="1000" readonly>
                                <small class="form-text text-muted">Otomatis dihitung (JS + JP)</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">
                        <i class="ti-close mr-2"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="ti-check mr-2"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Data Tarif -->
<div class="modal fade" id="editTarifModal" tabindex="-1" aria-labelledby="editTarifModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTarifModalLabel">Edit Data Tarif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editTarifForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_kode_tarif">Kode Tarif <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_kode_tarif" name="kode_tarif" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_kode">Kode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_kode" name="kode" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_instansi">Instansi <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_instansi" name="instansi" required>
                                    <option value="">Pilih Instansi</option>
                                    <option value="Gawat Darurat (IGD)">Gawat Darurat (IGD)</option>
                                    <option value="Rawat Jalan">Rawat Jalan</option>
                                    <option value="Rawat Inap">Rawat Inap</option>
                                    <option value="Laboratorium">Laboratorium</option>
                                    <option value="Radiologi">Radiologi</option>
                                    <option value="Farmasi">Farmasi</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_instansi_pelaksana">Instansi Pelaksana <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_instansi_pelaksana" name="instansi_pelaksana" required>
                                    <option value="">Pilih Instansi Pelaksana</option>
                                    <option value="Kamar Jenazah">Kamar Jenazah</option>
                                    <option value="Poli Umum">Poli Umum</option>
                                    <option value="Poli Spesialis">Poli Spesialis</option>
                                    <option value="ICU">ICU</option>
                                    <option value="VK">VK</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_kelompok_tindakan">Kelompok Tindakan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_kelompok_tindakan" name="kelompok_tindakan" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_nama_tindakan">Nama Tindakan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama_tindakan" name="nama_tindakan" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_detail_tindakan">Detail Tindakan</label>
                                <textarea class="form-control" id="edit_detail_tindakan" name="detail_tindakan" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_js">JS (Jasa Sarana) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_js" name="js" min="0" step="1000" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_jp">JP (Jasa Pelayanan) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_jp" name="jp" min="0" step="1000" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_tarif">Total Tarif <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_tarif" name="tarif" min="0" step="1000" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">
                        <i class="ti-close mr-2"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="ti-save mr-2"></i> Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Global functions for onclick handlers
function editTarif(id) {
    console.log('Edit Tarif called with ID:', id);

    // Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        console.warn('jQuery not loaded yet, retrying...');
        setTimeout(() => editTarif(id), 100);
        return;
    }

    // Prevent event bubbling
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }

    // Show loading state
    const editBtn = event ? event.target.closest('button') : null;
    let originalText = '';

    if (editBtn) {
        originalText = editBtn.innerHTML;
        editBtn.innerHTML = '<i class="ti-reload ti-spin"></i>';
        editBtn.disabled = true;
        editBtn.style.pointerEvents = 'none';
    }

    // Fetch data from server
    fetch(`/master-data/tarif/${id}/edit`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Data received:', data);

        // Populate edit form
        document.getElementById('edit_kode_tarif').value = data.kode_tarif || '';
        document.getElementById('edit_kode').value = data.kode || '';
        document.getElementById('edit_instansi').value = data.instansi || '';
        document.getElementById('edit_instansi_pelaksana').value = data.instansi_pelaksana || '';
        document.getElementById('edit_kelompok_tindakan').value = data.kelompok_tindakan || '';
        document.getElementById('edit_nama_tindakan').value = data.nama_tindakan || '';
        document.getElementById('edit_detail_tindakan').value = data.detail_tindakan || '';
        document.getElementById('edit_js').value = data.js || '';
        document.getElementById('edit_jp').value = data.jp || '';
        document.getElementById('edit_tarif').value = data.tarif || '';

        // Set form action URL
        document.getElementById('editTarifForm').action = `/master-data/tarif/${id}`;

        // Restore button state
        if (editBtn) {
            editBtn.innerHTML = originalText;
            editBtn.disabled = false;
            editBtn.style.pointerEvents = 'auto';
        }

        // Show modal manually if needed
        $('#editTarifModal').modal('show');
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        alert('Gagal memuat data tarif. Silakan coba lagi.');

        // Restore button state
        if (editBtn) {
            editBtn.innerHTML = originalText;
            editBtn.disabled = false;
            editBtn.style.pointerEvents = 'auto';
        }
    });
}

function deleteTarif(id) {
    console.log('Delete Tarif called with ID:', id);

    // Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        console.warn('jQuery not loaded yet, retrying...');
        setTimeout(() => deleteTarif(id), 100);
        return;
    }

    // Create custom confirmation modal
    const modalHtml = `
        <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">
                            <i class="ti-alert mr-2"></i> Konfirmasi Hapus
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="ti-trash text-danger" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Hapus Data Tarif?</h4>
                        <p class="text-muted">Data yang sudah dihapus tidak dapat dikembalikan lagi.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">
                            <i class="ti-close mr-2"></i> Batal
                        </button>
                        <button type="button" class="btn btn-danger btn-rounded" id="confirmDeleteBtn" data-id="${id}">
                            <i class="ti-trash mr-2"></i> Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Remove existing modal if any
    const existingModal = document.getElementById('deleteConfirmModal');
    if (existingModal) {
        existingModal.remove();
    }

    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);

    // Show modal
    $('#deleteConfirmModal').modal('show');

    // Remove modal after it's hidden
    $('#deleteConfirmModal').on('hidden.bs.modal', function () {
        this.remove();
    });
}

// Function to confirm delete
function confirmDelete(id) {
    const deleteBtn = document.querySelector('#deleteConfirmModal .btn-danger');
    const originalText = deleteBtn.innerHTML;

    // Show loading state
    deleteBtn.innerHTML = '<i class="ti-reload"></i> Menghapus...';
    deleteBtn.disabled = true;

    // Use fetch API for AJAX delete
    fetch(`/master-data/tarif/${id}`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Delete response:', data);

        if (data.success) {
            // Show success message
            const successAlert = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ${data.message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `;

            // Insert success alert at the top of content
            const contentWrapper = document.querySelector('.content-wrapper');
            contentWrapper.insertAdjacentHTML('afterbegin', successAlert);

            // Hide modal
            $('#deleteConfirmModal').modal('hide');

            // Reload page after short delay to show success message
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Gagal menghapus data');
        }
    })
    .catch(error => {
        console.error('Error deleting data:', error);

        // Show error message
        const errorAlert = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${error.message || 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.'}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;

        // Insert error alert at the top of content
        const contentWrapper = document.querySelector('.content-wrapper');
        contentWrapper.insertAdjacentHTML('afterbegin', errorAlert);

        // Hide modal
        $('#deleteConfirmModal').modal('hide');

        // Restore button state
        deleteBtn.innerHTML = originalText;
        deleteBtn.disabled = false;
    });
}

// Ensure jQuery is available before executing scripts
function ensureJQuery(callback) {
    if (typeof jQuery !== 'undefined' && typeof $ !== 'undefined') {
        callback();
    } else {
        setTimeout(function() {
            ensureJQuery(callback);
        }, 50);
    }
}

// Execute all scripts after jQuery is loaded
ensureJQuery(function() {
    // Reset form when add modal is closed
    $('#addTarifModal').on('hidden.bs.modal', function () {
        document.getElementById('addTarifForm').reset();
        // Remove validation classes
        $('.form-control').removeClass('is-valid is-invalid');
        $('.invalid-feedback').remove();
    });

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input[required], select[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            isValid = false;
            
            // Add error message if not exists
            if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('invalid-feedback')) {
                const errorMsg = document.createElement('div');
                errorMsg.className = 'invalid-feedback';
                errorMsg.textContent = 'Field ini harus diisi';
                input.parentNode.appendChild(errorMsg);
            }
        } else {
            input.classList.add('is-valid');
            input.classList.remove('is-invalid');
            
            // Remove error message
            const errorMsg = input.parentNode.querySelector('.invalid-feedback');
            if (errorMsg) {
                errorMsg.remove();
            }
        }
    });
    
    return isValid;
}

// Add form submit handlers with loading animation
document.getElementById('addTarifForm').addEventListener('submit', function(e) {
    if (!validateForm('addTarifForm')) {
        e.preventDefault();
        return false;
    }
    
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.classList.add('btn-loading');
    submitBtn.disabled = true;
});

document.getElementById('editTarifForm').addEventListener('submit', function(e) {
    if (!validateForm('editTarifForm')) {
        e.preventDefault();
        return false;
    }
    
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.classList.add('btn-loading');
    submitBtn.disabled = true;
});

    // Real-time validation
    document.addEventListener('input', function(e) {
        if (e.target.matches('.form-control[required]')) {
            if (e.target.value.trim()) {
                e.target.classList.add('is-valid');
                e.target.classList.remove('is-invalid');

                const errorMsg = e.target.parentNode.querySelector('.invalid-feedback');
                if (errorMsg) {
                    errorMsg.remove();
                }
            }
        }
    });

    // Add event listener for delete confirmation button
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'confirmDeleteBtn') {
            e.preventDefault();
            const id = e.target.getAttribute('data-id');
            if (id) {
                confirmDelete(id);
            }
        }
    });

    // Alternative event listener for edit buttons
    document.addEventListener('DOMContentLoaded', function() {
        // Add click event listeners to all edit buttons
        document.addEventListener('click', function(e) {
            if (e.target.closest('button[onclick*="editTarif"]')) {
                e.preventDefault();
                e.stopPropagation();

                const button = e.target.closest('button');
                const onclickAttr = button.getAttribute('onclick');
                const idMatch = onclickAttr.match(/editTarif\((\d+)\)/);

                if (idMatch) {
                    const id = idMatch[1];
                    editTarif(id);
                }
            }
        });

        // Ensure buttons are properly initialized
        const editButtons = document.querySelectorAll('button[onclick*="editTarif"]');
        editButtons.forEach(button => {
            button.style.cursor = 'pointer';
            button.style.userSelect = 'none';

            // Add touch-friendly events for mobile
            button.addEventListener('touchstart', function(e) {
                this.style.transform = 'scale(0.95)';
            });

            button.addEventListener('touchend', function(e) {
                this.style.transform = 'scale(1)';
            });
        });
    });
});
</script>
@endsection