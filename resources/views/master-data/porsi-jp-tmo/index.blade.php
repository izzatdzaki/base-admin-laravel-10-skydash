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
                            <p class="card-description">Porsi JP TMO</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#addPorsiJpTmoModal">
                                <i class="ti-plus mr-2"></i> Tambah Data Porsi JP TMO
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Jenis TMO</th>
                                    <th>Penerima JP</th>
                                    <th>Porsi JP (%)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($porsi_jp_tmo as $index => $item)
                                <tr>
                                    <td>{{ $porsi_jp_tmo->firstItem() + $index }}</td>
                                    <td>{{ $item->kode }}</td>
                                    <td>{{ $item->jenis_tmo }}</td>
                                    <td>{{ $item->penerima_jp }}</td>
                                    <td>{{ $item->porsi_jp }} %</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editPorsiJpTmoModal" onclick="editPorsiJpTmo({{ $item->id }})" title="Edit Data">
                                                <i class="ti-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm ml-1" onclick="deletePorsiJpTmo({{ $item->id }})" title="Hapus Data">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data porsi JP TMO</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $porsi_jp_tmo->firstItem() }} sampai {{ $porsi_jp_tmo->lastItem() }} dari {{ $porsi_jp_tmo->total() }} data porsi JP TMO
                        </small>
                        <div>
                            {{ $porsi_jp_tmo->links('custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data Porsi JP TMO -->
<div class="modal fade" id="addPorsiJpTmoModal" tabindex="-1" aria-labelledby="addPorsiJpTmoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPorsiJpTmoModalLabel">Tambah Data Porsi JP TMO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addPorsiJpTmoForm" method="POST" action="{{ route('porsi-jp-tmo.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode">Kode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                       id="kode" name="kode" value="{{ old('kode') }}" maxlength="20" required>
                                <small class="form-text text-muted">Contoh: TMO001</small>
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_tmo">Jenis TMO <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('jenis_tmo') is-invalid @enderror"
                                       id="jenis_tmo" name="jenis_tmo" value="{{ old('jenis_tmo') }}" maxlength="100" required>
                                @error('jenis_tmo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="penerima_jp">Penerima JP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('penerima_jp') is-invalid @enderror"
                                       id="penerima_jp" name="penerima_jp" value="{{ old('penerima_jp') }}" maxlength="100" required>
                                @error('penerima_jp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="porsi_jp">Porsi JP (%) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('porsi_jp') is-invalid @enderror"
                                       id="porsi_jp" name="porsi_jp" value="{{ old('porsi_jp') }}" min="0" max="100" step="0.01" required>
                                <small class="form-text text-muted">Persentase (0-100)</small>
                                @error('porsi_jp')
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

<!-- Modal Edit Data Porsi JP TMO -->
<div class="modal fade" id="editPorsiJpTmoModal" tabindex="-1" aria-labelledby="editPorsiJpTmoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPorsiJpTmoModalLabel">Edit Data Porsi JP TMO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editPorsiJpTmoForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_kode">Kode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_kode" name="kode" maxlength="20" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_jenis_tmo">Jenis TMO <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_jenis_tmo" name="jenis_tmo" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_penerima_jp">Penerima JP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_penerima_jp" name="penerima_jp" maxlength="100" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_porsi_jp">Porsi JP (%) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_porsi_jp" name="porsi_jp" min="0" max="100" step="0.01" required>
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
function editPorsiJpTmo(id) {
    console.log('Edit Porsi JP TMO called with ID:', id);

    // Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        console.warn('jQuery not loaded yet, retrying...');
        setTimeout(() => editPorsiJpTmo(id), 100);
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
    fetch(`/master-data/porsi-jp-tmo/${id}/edit`, {
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
        document.getElementById('edit_kode').value = data.kode || '';
        document.getElementById('edit_jenis_tmo').value = data.jenis_tmo || '';
        document.getElementById('edit_penerima_jp').value = data.penerima_jp || '';
        document.getElementById('edit_porsi_jp').value = data.porsi_jp || '';

        // Set form action URL
        document.getElementById('editPorsiJpTmoForm').action = `/master-data/porsi-jp-tmo/${id}`;

        // Restore button state
        if (editBtn) {
            editBtn.innerHTML = originalText;
            editBtn.disabled = false;
            editBtn.style.pointerEvents = 'auto';
        }

        // Show modal manually if needed
        $('#editPorsiJpTmoModal').modal('show');
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        alert('Gagal memuat data porsi JP TMO. Silakan coba lagi.');

        // Restore button state
        if (editBtn) {
            editBtn.innerHTML = originalText;
            editBtn.disabled = false;
            editBtn.style.pointerEvents = 'auto';
        }
    });
}

function deletePorsiJpTmo(id) {
    console.log('Delete Porsi JP TMO called with ID:', id);

    // Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        console.warn('jQuery not loaded yet, retrying...');
        setTimeout(() => deletePorsiJpTmo(id), 100);
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
                        <h4 class="mt-3">Hapus Data Porsi JP TMO?</h4>
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
    fetch(`/master-data/porsi-jp-tmo/${id}`, {
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
    $('#addPorsiJpTmoModal').on('hidden.bs.modal', function () {
        document.getElementById('addPorsiJpTmoForm').reset();
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
    document.getElementById('addPorsiJpTmoForm').addEventListener('submit', function(e) {
        if (!validateForm('addPorsiJpTmoForm')) {
            e.preventDefault();
            return false;
        }

        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.classList.add('btn-loading');
        submitBtn.disabled = true;
    });

    document.getElementById('editPorsiJpTmoForm').addEventListener('submit', function(e) {
        if (!validateForm('editPorsiJpTmoForm')) {
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
            if (e.target.closest('button[onclick*="editPorsiJpTmo"]')) {
                e.preventDefault();
                e.stopPropagation();

                const button = e.target.closest('button');
                const onclickAttr = button.getAttribute('onclick');
                const idMatch = onclickAttr.match(/editPorsiJpTmo\((\d+)\)/);

                if (idMatch) {
                    const id = idMatch[1];
                    editPorsiJpTmo(id);
                }
            }
        });

        // Ensure buttons are properly initialized
        const editButtons = document.querySelectorAll('button[onclick*="editPorsiJpTmo"]');
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
