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
                            <p class="card-description">Kelompok Tindakan</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <input type="text" class="form-control form-control-sm" id="searchTable" placeholder="Cari data..." style="width: 250px;">
                            </div>
                            <button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#addTarifModal">
                                <i class="ti-plus mr-2"></i> Tambah Data Kelompok Tindakan
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="8%">Kode Tindakan</th>
                                    <th width="15%">Kode</th>
                                    <th width="20%">Instalasi Induk</th>
                                    <th width="25%">Instalasi Pelaksana</th>
                                    <th width="8%">Unit</th>
                                    <th width="8%">Kelompok Tindakan</th>
                                    <th width="10%">Detail Tindakan</th>
                                    <th width="10%">Rencana Tindakan</th>
                                    <th width="3%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kelompok_tindakan as $index => $item)
                                <tr>
                                    <td>{{ $kelompok_tindakan->firstItem() + $index }}</td>
                                    <td>{{ $item->kode_tindakan }}</td>
                                    <td>{{ $item->kode_tarif }}</td>
                                    <td>{{ $item->instalasi_induk }}</td>
                                    <td>{{ $item->instansi_pelaksana }}</td>
                                    <td>{{ $item->unit }}</td>
                                    <td>{{ $item->kelompok_tindakan }}</td>
                                    <td>{{ $item->detail_tindakan }}</td>
                                    <td>{{ $item->rincian_tindakan }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editTarifModal" onclick="editKelompokTindakan({{ $item->id }})" title="Edit Data">
                                                <i class="ti-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm ml-1" onclick="deleteKelompokTindakan({{ $item->id }})" title="Hapus Data">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">Belum ada data kelompok tindakan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $kelompok_tindakan->firstItem() }} sampai {{ $kelompok_tindakan->lastItem() }} dari {{ $kelompok_tindakan->total() }} data kelompok tindakan
                        </small>
                        <div>
                            {{ $kelompok_tindakan->links('custom-pagination') }}
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
                <h5 class="modal-title" id="addTarifModalLabel">Tambah Data Kelompok Tindakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addTarifForm" method="POST" action="{{ route('kelompok-tindakan.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode_tindakan">Kode Tindakan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode_tindakan') is-invalid @enderror" 
                                       id="kode_tindakan" name="kode_tindakan" value="{{ old('kode_tindakan') }}" required>
                                <small class="form-text text-muted">Contoh: KT001</small>
                                @error('kode_tindakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="instalasi_induk">Instalasi Induk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('instalasi_induk') is-invalid @enderror" 
                                       id="instalasi_induk" name="instalasi_induk" value="{{ old('instalasi_induk') }}" required>
                                <small class="form-text text-muted">Contoh: Rawat Jalan</small>
                                @error('instalasi_induk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="instansi_pelaksana">Instansi Pelaksana <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('instansi_pelaksana') is-invalid @enderror" 
                                       id="instansi_pelaksana" name="instansi_pelaksana" value="{{ old('instansi_pelaksana') }}" required>
                                <small class="form-text text-muted">Contoh: Poli Umum</small>
                                @error('instansi_pelaksana')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unit">Unit <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('unit') is-invalid @enderror" 
                                       id="unit" name="unit" value="{{ old('unit') }}" required>
                                <small class="form-text text-muted">Contoh: Unit 1</small>
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kelompok_tindakan">Kelompok Tindakan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kelompok_tindakan') is-invalid @enderror" 
                                       id="kelompok_tindakan" name="kelompok_tindakan" value="{{ old('kelompok_tindakan') }}" required>
                                <small class="form-text text-muted">Contoh: Konsultasi</small>
                                @error('kelompok_tindakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="detail_tindakan">Detail Tindakan</label>
                                <input type="text" class="form-control @error('detail_tindakan') is-invalid @enderror" 
                                       id="detail_tindakan" name="detail_tindakan" value="{{ old('detail_tindakan') }}">
                                <small class="form-text text-muted">Deskripsi detail dari tindakan</small>
                                @error('detail_tindakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rincian_tindakan">Rincian Tindakan</label>
                                <input type="text" class="form-control @error('rincian_tindakan') is-invalid @enderror" 
                                       id="rincian_tindakan" name="rincian_tindakan" value="{{ old('rincian_tindakan') }}">
                                <small class="form-text text-muted">Rincian tambahan tindakan</small>
                                @error('rincian_tindakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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

<!-- Modal Edit Data Kelompok Tindakan -->
<div class="modal fade" id="editTarifModal" tabindex="-1" aria-labelledby="editTarifModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTarifModalLabel">Edit Data Kelompok Tindakan</h5>
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
                                <label for="edit_kode_tindakan">Kode Tindakan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_kode_tindakan" name="kode_tindakan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_kode_tarif">Kode Tarif <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_kode_tarif" name="kode_tarif" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_instalasi_induk">Instalasi Induk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_instalasi_induk" name="instalasi_induk" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_instansi_pelaksana">Instansi Pelaksana <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_instansi_pelaksana" name="instansi_pelaksana" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_unit">Unit <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_unit" name="unit" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_kelompok_tindakan">Kelompok Tindakan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_kelompok_tindakan" name="kelompok_tindakan" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_detail_tindakan">Detail Tindakan</label>
                                <input type="text" class="form-control" id="edit_detail_tindakan" name="detail_tindakan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_rincian_tindakan">Rincian Tindakan</label>
                                <input type="text" class="form-control" id="edit_rincian_tindakan" name="rincian_tindakan">
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
function editKelompokTindakan(id) {
    console.log('Edit Kelompok Tindakan called with ID:', id);

    // Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        console.warn('jQuery not loaded yet, retrying...');
        setTimeout(() => editKelompokTindakan(id), 100);
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
    fetch(`/master-data/kelompok-tindakan/${id}/edit`, {
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
        document.getElementById('edit_kode_tindakan').value = data.kode_tindakan || '';
        document.getElementById('edit_kode_tarif').value = data.kode_tarif || '';
        document.getElementById('edit_instalasi_induk').value = data.instalasi_induk || '';
        document.getElementById('edit_instansi_pelaksana').value = data.instansi_pelaksana || '';
        document.getElementById('edit_unit').value = data.unit || '';
        document.getElementById('edit_kelompok_tindakan').value = data.kelompok_tindakan || '';
        document.getElementById('edit_detail_tindakan').value = data.detail_tindakan || '';
        document.getElementById('edit_rincian_tindakan').value = data.rincian_tindakan || '';

        // Set form action URL
        document.getElementById('editTarifForm').action = `/master-data/kelompok-tindakan/${id}`;

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
        alert('Gagal memuat data kelompok tindakan. Silakan coba lagi.');

        // Restore button state
        if (editBtn) {
            editBtn.innerHTML = originalText;
            editBtn.disabled = false;
            editBtn.style.pointerEvents = 'auto';
        }
    });
}

function deleteKelompokTindakan(id) {
    console.log('Delete Kelompok Tindakan called with ID:', id);

    // Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        console.warn('jQuery not loaded yet, retrying...');
        setTimeout(() => deleteKelompokTindakan(id), 100);
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
                        <h4 class="mt-3">Hapus Data Kelompok Tindakan?</h4>
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
    fetch(`/master-data/kelompok-tindakan/${id}`, {
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

    // Alternative event listener for edit buttons
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listeners to all edit buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('button[onclick*="editKelompokTindakan"]')) {
            e.preventDefault();
            e.stopPropagation();

            const button = e.target.closest('button');
            const onclickAttr = button.getAttribute('onclick');
            const idMatch = onclickAttr.match(/editKelompokTindakan\((\d+)\)/);

            if (idMatch) {
                const id = idMatch[1];
                editKelompokTindakan(id);
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

    // Ensure buttons are properly initialized
    const editButtons = document.querySelectorAll('button[onclick*="editKelompokTindakan"]');
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
</script>
@endsection
