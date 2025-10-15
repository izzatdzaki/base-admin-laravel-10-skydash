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
                            <p class="card-description">Porsi JP</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#addPorsiJpModal">
                                <i class="ti-plus mr-2"></i> Tambah Data Porsi JP
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Tarif</th>
                                    <th>Instalasi Induk</th>
                                    <th>Instansi Pelaksana</th>
                                    <th>Kelompok Tindakan</th>
                                    <th>JLP</th>
                                    <th>JLA</th>
                                    <th>JTL ST</th>
                                    <th>JTL P</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($porsi_jp as $index => $item)
                                <tr>
                                    <td>{{ $porsi_jp->firstItem() + $index }}</td>
                                    <td>{{ $item->kode_tarif }}</td>
                                    <td>{{ $item->instalasi_induk }}</td>
                                    <td>{{ $item->instansi_pelaksana }}</td>
                                    <td>{{ $item->kelompok_tindakan }}</td>
                                    <td>{{ number_format($item->jlp, 0, ',', '.') }}</td>
                                    <td>{{ number_format($item->jla, 0, ',', '.') }}</td>
                                    <td>{{ number_format($item->jtl_st, 0, ',', '.') }}</td>
                                    <td>{{ number_format($item->jtl_p, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editPorsiJpModal" onclick="editPorsiJp({{ $item->id }})" title="Edit Data">
                                                <i class="ti-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm ml-1" onclick="deletePorsiJp({{ $item->id }})" title="Hapus Data">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">Belum ada data porsi JP</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $porsi_jp->firstItem() }} sampai {{ $porsi_jp->lastItem() }} dari {{ $porsi_jp->total() }} data porsi JP
                        </small>
                        <div>
                            {{ $porsi_jp->links('custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data Porsi JP -->
<div class="modal fade" id="addPorsiJpModal" tabindex="-1" aria-labelledby="addPorsiJpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPorsiJpModalLabel">Tambah Data Porsi JP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addPorsiJpForm" method="POST" action="{{ route('porsi-jp.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode_tarif">Kode Tarif <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode_tarif') is-invalid @enderror"
                                       id="kode_tarif" name="kode_tarif" value="{{ old('kode_tarif') }}" maxlength="20" required>
                                <small class="form-text text-muted">Contoh: JP001</small>
                                @error('kode_tarif')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="instalasi_induk">Instalasi Induk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('instalasi_induk') is-invalid @enderror"
                                       id="instalasi_induk" name="instalasi_induk" value="{{ old('instalasi_induk') }}" maxlength="100" required>
                                @error('instalasi_induk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="instansi_pelaksana">Instansi Pelaksana <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('instansi_pelaksana') is-invalid @enderror"
                                       id="instansi_pelaksana" name="instansi_pelaksana" value="{{ old('instansi_pelaksana') }}" maxlength="100" required>
                                @error('instansi_pelaksana')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kelompok_tindakan">Kelompok Tindakan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kelompok_tindakan') is-invalid @enderror"
                                       id="kelompok_tindakan" name="kelompok_tindakan" value="{{ old('kelompok_tindakan') }}" maxlength="100" required>
                                @error('kelompok_tindakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jlp">JLP <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('jlp') is-invalid @enderror"
                                       id="jlp" name="jlp" value="{{ old('jlp') }}" min="0" required>
                                <small class="form-text text-muted">Jasa Lainnya Pelayanan</small>
                                @error('jlp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jla">JLA <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('jla') is-invalid @enderror"
                                       id="jla" name="jla" value="{{ old('jla') }}" min="0" required>
                                <small class="form-text text-muted">Jasa Lainnya Administrasi</small>
                                @error('jla')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jtl_st">JTL ST <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('jtl_st') is-invalid @enderror"
                                       id="jtl_st" name="jtl_st" value="{{ old('jtl_st') }}" min="0" required>
                                <small class="form-text text-muted">Jasa Tambahan Lainnya - ST</small>
                                @error('jtl_st')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jtl_p">JTL P <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('jtl_p') is-invalid @enderror"
                                       id="jtl_p" name="jtl_p" value="{{ old('jtl_p') }}" min="0" required>
                                <small class="form-text text-muted">Jasa Tambahan Lainnya - P</small>
                                @error('jtl_p')
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

<!-- Modal Edit Data Porsi JP -->
<div class="modal fade" id="editPorsiJpModal" tabindex="-1" aria-labelledby="editPorsiJpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPorsiJpModalLabel">Edit Data Porsi JP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editPorsiJpForm" method="POST">
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
                                <label for="edit_instalasi_induk">Instalasi Induk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_instalasi_induk" name="instalasi_induk" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_instansi_pelaksana">Instansi Pelaksana <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_instansi_pelaksana" name="instansi_pelaksana" maxlength="100" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_kelompok_tindakan">Kelompok Tindakan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_kelompok_tindakan" name="kelompok_tindakan" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_jlp">JLP <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_jlp" name="jlp" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_jla">JLA <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_jla" name="jla" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_jtl_st">JTL ST <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_jtl_st" name="jtl_st" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_jtl_p">JTL P <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_jtl_p" name="jtl_p" min="0" required>
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
function editPorsiJp(id) {
    console.log('Edit Porsi JP called with ID:', id);

    // Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        console.warn('jQuery not loaded yet, retrying...');
        setTimeout(() => editPorsiJp(id), 100);
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
    fetch(`/master-data/porsi-jp/${id}/edit`, {
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
        document.getElementById('edit_instalasi_induk').value = data.instalasi_induk || '';
        document.getElementById('edit_instansi_pelaksana').value = data.instansi_pelaksana || '';
        document.getElementById('edit_kelompok_tindakan').value = data.kelompok_tindakan || '';
        document.getElementById('edit_jlp').value = data.jlp || '';
        document.getElementById('edit_jla').value = data.jla || '';
        document.getElementById('edit_jtl_st').value = data.jtl_st || '';
        document.getElementById('edit_jtl_p').value = data.jtl_p || '';

        // Set form action URL
        document.getElementById('editPorsiJpForm').action = `/master-data/porsi-jp/${id}`;

        // Restore button state
        if (editBtn) {
            editBtn.innerHTML = originalText;
            editBtn.disabled = false;
            editBtn.style.pointerEvents = 'auto';
        }

        // Show modal manually if needed
        $('#editPorsiJpModal').modal('show');
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        alert('Gagal memuat data porsi JP. Silakan coba lagi.');

        // Restore button state
        if (editBtn) {
            editBtn.innerHTML = originalText;
            editBtn.disabled = false;
            editBtn.style.pointerEvents = 'auto';
        }
    });
}

function deletePorsiJp(id) {
    console.log('Delete Porsi JP called with ID:', id);

    // Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        console.warn('jQuery not loaded yet, retrying...');
        setTimeout(() => deletePorsiJp(id), 100);
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
                        <h4 class="mt-3">Hapus Data Porsi JP?</h4>
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
    fetch(`/master-data/porsi-jp/${id}`, {
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
    $('#addPorsiJpModal').on('hidden.bs.modal', function () {
        document.getElementById('addPorsiJpForm').reset();
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
    document.getElementById('addPorsiJpForm').addEventListener('submit', function(e) {
        if (!validateForm('addPorsiJpForm')) {
            e.preventDefault();
            return false;
        }

        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.classList.add('btn-loading');
        submitBtn.disabled = true;
    });

    document.getElementById('editPorsiJpForm').addEventListener('submit', function(e) {
        if (!validateForm('editPorsiJpForm')) {
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
            if (e.target.closest('button[onclick*="editPorsiJp"]')) {
                e.preventDefault();
                e.stopPropagation();

                const button = e.target.closest('button');
                const onclickAttr = button.getAttribute('onclick');
                const idMatch = onclickAttr.match(/editPorsiJp\((\d+)\)/);

                if (idMatch) {
                    const id = idMatch[1];
                    editPorsiJp(id);
                }
            }
        });

        // Ensure buttons are properly initialized
        const editButtons = document.querySelectorAll('button[onclick*="editPorsiJp"]');
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
