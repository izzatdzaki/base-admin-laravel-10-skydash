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
                            <p class="card-description">Porsi CBGs</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#addPorsiCbgsModal">
                                <i class="ti-plus mr-2"></i> Tambah Data Porsi CBGs
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Porsi (%)</th>
                                    <th>Nilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($porsi_cbgs as $index => $item)
                                <tr>
                                    <td>{{ $porsi_cbgs->firstItem() + $index }}</td>
                                    <td>{{ $item->porsi }} %</td>
                                    <td>{{ number_format($item->nilai, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editPorsiCbgsModal" onclick="editPorsiCbgs({{ $item->id }})" title="Edit Data">
                                                <i class="ti-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm ml-1" onclick="deletePorsiCbgs({{ $item->id }})" title="Hapus Data">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data porsi CBGs</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $porsi_cbgs->firstItem() }} sampai {{ $porsi_cbgs->lastItem() }} dari {{ $porsi_cbgs->total() }} data porsi CBGs
                        </small>
                        <div>
                            {{ $porsi_cbgs->links('custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data Porsi CBGs -->
<div class="modal fade" id="addPorsiCbgsModal" tabindex="-1" aria-labelledby="addPorsiCbgsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPorsiCbgsModalLabel">Tambah Data Porsi CBGs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addPorsiCbgsForm" method="POST" action="{{ route('porsi-cbgs.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="porsi">Porsi (%) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('porsi') is-invalid @enderror" 
                                       id="porsi" name="porsi" value="{{ old('porsi') }}" min="0" max="100" step="0.01" required>
                                <small class="form-text text-muted">Contoh: 25.5</small>
                                @error('porsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nilai">Nilai <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('nilai') is-invalid @enderror" 
                                       id="nilai" name="nilai" value="{{ old('nilai') }}" min="0" step="1000" required>
                                <small class="form-text text-muted">Dalam Rupiah</small>
                                @error('nilai')
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

<!-- Modal Edit Data Porsi CBGs -->
<div class="modal fade" id="editPorsiCbgsModal" tabindex="-1" aria-labelledby="editPorsiCbgsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPorsiCbgsModalLabel">Edit Data Porsi CBGs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editPorsiCbgsForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_porsi">Porsi (%) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_porsi" name="porsi" min="0" max="100" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_nilai">Nilai <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_nilai" name="nilai" min="0" step="1000" required>
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
function editPorsiCbgs(id) {
    console.log('Edit Porsi CBGs called with ID:', id);

    // Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        console.warn('jQuery not loaded yet, retrying...');
        setTimeout(() => editPorsiCbgs(id), 100);
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
    fetch(`/master-data/porsi-cbgs/${id}/edit`, {
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
        document.getElementById('edit_porsi').value = data.porsi || '';
        document.getElementById('edit_nilai').value = data.nilai || '';

        // Set form action URL
        document.getElementById('editPorsiCbgsForm').action = `/master-data/porsi-cbgs/${id}`;

        // Restore button state
        if (editBtn) {
            editBtn.innerHTML = originalText;
            editBtn.disabled = false;
            editBtn.style.pointerEvents = 'auto';
        }

        // Show modal manually if needed
        $('#editPorsiCbgsModal').modal('show');
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        alert('Gagal memuat data porsi CBGs. Silakan coba lagi.');

        // Restore button state
        if (editBtn) {
            editBtn.innerHTML = originalText;
            editBtn.disabled = false;
            editBtn.style.pointerEvents = 'auto';
        }
    });
}

function deletePorsiCbgs(id) {
    console.log('Delete Porsi CBGs called with ID:', id);

    // Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        console.warn('jQuery not loaded yet, retrying...');
        setTimeout(() => deletePorsiCbgs(id), 100);
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
                        <h4 class="mt-3">Hapus Data Porsi CBGs?</h4>
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
    console.log('Confirm delete called for ID:', id);

    // Use fetch for AJAX delete request
    fetch(`/master-data/porsi-cbgs/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Delete response status:', response.status);

        // Check if it's a redirect (authentication required)
        if (response.redirected) {
            alert('Sesi Anda telah berakhir. Silakan login kembali.');
            window.location.href = '/login';
            return;
        }

        // Parse JSON response
        return response.json().then(data => {
            if (response.ok && data.success) {
                alert('Data berhasil dihapus!');
                window.location.href = '/master-data/porsi-cbgs';
            } else {
                alert('Gagal menghapus data: ' + (data.message || 'Unknown error'));
            }
        });
    })
    .catch(error => {
        console.error('Delete error:', error);
        alert('Terjadi kesalahan saat menghapus data: ' + error.message);
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
    $('#addPorsiCbgsModal').on('hidden.bs.modal', function () {
        document.getElementById('addPorsiCbgsForm').reset();
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
    document.getElementById('addPorsiCbgsForm').addEventListener('submit', function(e) {
        if (!validateForm('addPorsiCbgsForm')) {
            e.preventDefault();
            return false;
        }

        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.classList.add('btn-loading');
        submitBtn.disabled = true;
    });

    document.getElementById('editPorsiCbgsForm').addEventListener('submit', function(e) {
        if (!validateForm('editPorsiCbgsForm')) {
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
            if (e.target.closest('button[onclick*="editPorsiCbgs"]')) {
                e.preventDefault();
                e.stopPropagation();

                const button = e.target.closest('button');
                const onclickAttr = button.getAttribute('onclick');
                const idMatch = onclickAttr.match(/editPorsiCbgs\((\d+)\)/);

                if (idMatch) {
                    const id = idMatch[1];
                    editPorsiCbgs(id);
                }
            }
        });

        // Ensure buttons are properly initialized
        const editButtons = document.querySelectorAll('button[onclick*="editPorsiCbgs"]');
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
