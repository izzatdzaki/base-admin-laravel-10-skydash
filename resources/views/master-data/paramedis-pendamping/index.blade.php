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

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
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
                            <p class="card-description">Paramedis Pendamping</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#addParamedisPendampingModal">
                                <i class="ti-plus mr-2"></i> Tambah Data Paramedis Pendamping
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Tarif</th>
                                    <th>Nama Pendamping</th>
                                    <th>Ruang / Unit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paramedis_pendamping as $index => $item)
                                <tr>
                                    <td>{{ $paramedis_pendamping->firstItem() + $index }}</td>
                                    <td>{{ $item->kode_tarif }}</td>
                                    <td>{{ $item->nama_pendamping }}</td>
                                    <td>{{ $item->ruang_unit }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editParamedisPendampingModal" onclick="editParamedisPendamping({{ $item->id }})" title="Edit Data">
                                                <i class="ti-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm ml-1" onclick="deleteParamedisPendamping({{ $item->id }})" title="Hapus Data">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data paramedis pendamping</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $paramedis_pendamping->firstItem() }} sampai {{ $paramedis_pendamping->lastItem() }} dari {{ $paramedis_pendamping->total() }} data paramedis pendamping
                        </small>
                        <div>
                            {{ $paramedis_pendamping->links('custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data Paramedis Pendamping -->
<div class="modal fade" id="addParamedisPendampingModal" tabindex="-1" aria-labelledby="addParamedisPendampingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addParamedisPendampingModalLabel">Tambah Data Paramedis Pendamping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addParamedisPendampingForm" method="POST" action="{{ route('paramedis-pendamping.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode_tarif">Kode Tarif <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode_tarif') is-invalid @enderror"
                                       id="kode_tarif" name="kode_tarif" value="{{ old('kode_tarif') }}" maxlength="20" required>
                                <small class="form-text text-muted">Contoh: TRF001</small>
                                @error('kode_tarif')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_pendamping">Nama Pendamping <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_pendamping') is-invalid @enderror"
                                       id="nama_pendamping" name="nama_pendamping" value="{{ old('nama_pendamping') }}" maxlength="100" required>
                                @error('nama_pendamping')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ruang_unit">Ruang / Unit <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('ruang_unit') is-invalid @enderror"
                                       id="ruang_unit" name="ruang_unit" value="{{ old('ruang_unit') }}" maxlength="100" required>
                                <small class="form-text text-muted">Contoh: Poli Umum, IGD, dll.</small>
                                @error('ruang_unit')
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

<!-- Modal Edit Data Paramedis Pendamping -->
<div class="modal fade" id="editParamedisPendampingModal" tabindex="-1" aria-labelledby="editParamedisPendampingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editParamedisPendampingModalLabel">Edit Data Paramedis Pendamping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editParamedisPendampingForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_kode_tarif">Kode Tarif <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_kode_tarif" name="kode_tarif" maxlength="20" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_nama_pendamping">Nama Pendamping <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama_pendamping" name="nama_pendamping" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_ruang_unit">Ruang / Unit <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_ruang_unit" name="ruang_unit" maxlength="100" required>
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
function editParamedisPendamping(id) {
    console.log('Edit Paramedis Pendamping called with ID:', id);

    // Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        console.warn('jQuery not loaded yet, retrying...');
        setTimeout(() => editParamedisPendamping(id), 100);
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
    fetch(`/master-data/paramedis-pendamping/${id}/edit`, {
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
        document.getElementById('edit_nama_pendamping').value = data.nama_pendamping || '';
        document.getElementById('edit_ruang_unit').value = data.ruang_unit || '';

        // Set form action URL
        document.getElementById('editParamedisPendampingForm').action = `/master-data/paramedis-pendamping/${id}`;

        // Restore button state
        if (editBtn) {
            editBtn.innerHTML = originalText;
            editBtn.disabled = false;
            editBtn.style.pointerEvents = 'auto';
        }

        // Show modal manually if needed
        $('#editParamedisPendampingModal').modal('show');
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        alert('Gagal memuat data paramedis pendamping. Silakan coba lagi.');

        // Restore button state
        if (editBtn) {
            editBtn.innerHTML = originalText;
            editBtn.disabled = false;
            editBtn.style.pointerEvents = 'auto';
        }
    });
}

function deleteParamedisPendamping(id) {
    console.log('Delete Paramedis Pendamping called with ID:', id);

    // Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        console.warn('jQuery not loaded yet, retrying...');
        setTimeout(() => deleteParamedisPendamping(id), 100);
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
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="ti-trash text-danger" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Hapus Data Paramedis Pendamping?</h4>
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
    fetch(`/master-data/paramedis-pendamping/${id}`, {
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
    $('#addParamedisPendampingModal').on('hidden.bs.modal', function () {
        document.getElementById('addParamedisPendampingForm').reset();
        // Remove validation classes
        $('.form-control').removeClass('is-valid is-invalid');
        $('.invalid-feedback').remove();
    });

    // Add event listener for confirm delete button
    document.addEventListener('click', function(e) {
        if (e.target.matches('#confirmDeleteBtn') || e.target.closest('#confirmDeleteBtn')) {
            const button = e.target.closest('#confirmDeleteBtn');
            const id = button.getAttribute('data-id');
            if (id) {
                confirmDelete(id);
            }
        }
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
    document.getElementById('addParamedisPendampingForm').addEventListener('submit', function(e) {
        if (!validateForm('addParamedisPendampingForm')) {
            e.preventDefault();
            return false;
        }

        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.classList.add('btn-loading');
        submitBtn.disabled = true;
    });

    document.getElementById('editParamedisPendampingForm').addEventListener('submit', function(e) {
        if (!validateForm('editParamedisPendampingForm')) {
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
            if (e.target.closest('button[onclick*="editParamedisPendamping"]')) {
                e.preventDefault();
                e.stopPropagation();

                const button = e.target.closest('button');
                const onclickAttr = button.getAttribute('onclick');
                const idMatch = onclickAttr.match(/editParamedisPendamping\((\d+)\)/);

                if (idMatch) {
                    const id = idMatch[1];
                    editParamedisPendamping(id);
                }
            }
        });

        // Ensure buttons are properly initialized
        const editButtons = document.querySelectorAll('button[onclick*="editParamedisPendamping"]');
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
