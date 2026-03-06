@extends('admin.layout.main')
@section('title', 'Master Pengaduan')
@section('konten')

<div class="container-scroller">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <div class="p-4 rounded shadow bg-white">
        <h2 class="text-start mb-4">Master Pengaduan</h2>

        <!-- FORM PENCARIAN -->
        <div class="pb-3">
            <form class="d-flex" action="{{ route('master-pengaduan.index') }}" method="get" id="searchForm">
                <input class="form-control me-1" type="search" name="katakunci" placeholder="Cari..." value="{{ Request::get('katakunci') }}">
                <button class="btn btn-outline-primary" type="submit">Cari</button>
            </form>
        </div>

        <!-- TABEL PENGADUAN -->
        <div class="p-2 bg-body">
            <table class="display expandable-table dataTable no-footer" style="width: 100%">
                <thead class="table-primary">
                    <tr>
                        <th class="text-center">No</th>
                        <th>NIK</th>
                        <th>Nama Pengadu</th>
                        <th class="text-center">Kategori</th>
                        <th style="max-width: 170px">Ulasan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduan as $i => $item)
                        <tr>
                            <td class="text-center align-top">{{ $pengaduan->firstItem() + $i }}</td>
                            <td class="align-top">{{ $item->nik }}</td>
                            <td class="align-top">{{ $item->penduduk->nama_lengkap ?? '-' }}</td>
                            <td class="text-center align-top">{{ $item->kategori ?? '-' }}</td>
                            <td class="align-top text-justify" style="max-width: 170px">
                                <p>
                                    {{ \Illuminate\Support\Str::words(strip_tags($item->ulasan), 50, '...') }}
                                </p>
                            </td>
                            <td class="text-center align-top">
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Tombol Lihat -->
                                    <button class="btn btn-success rounded-circle d-flex align-items-center justify-content-center action-btn" data-bs-toggle="modal" data-bs-target="#lihatModal{{ $item->id }}" title="Lihat Detail">
                                        <i class="bi bi-eye text-white"></i>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('master-pengaduan.destroy', $item->id) }}" method="POST" class="d-inline" id="formHapus{{ $item->id }}">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger rounded-circle d-flex align-items-center justify-content-center action-btn btnHapus" data-id="{{ $item->id }}" data-nama="{{ $item->nik }}" title="Hapus">
                                            <i class="bi bi-trash text-white"></i>
                                        </button>
                                    </form>

                                    <!-- Tombol Feedback -->
                                    <button class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center action-btn" data-bs-toggle="modal" data-bs-target="#feedbackModal{{ $item->id }}" title="Kirim Feedback">
                                        <i class="bi bi-chat-dots text-white"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- MODAL LIHAT -->
                        <div class="modal fade" id="lihatModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content p-4">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">📝 Detail Pengaduan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">NIK</label>
                                                <input type="text" class="form-control" value="{{ $item->nik }}" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Nama</label>
                                                <input type="text" class="form-control" value="{{ $item->penduduk->nama_lengkap ?? '-' }}" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Kategori</label>
                                                <input type="text" class="form-control" value="{{ $item->kategori ?? '-' }}" readonly>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-bold">Ulasan</label>
                                                <textarea class="form-control" rows="3" readonly>{{ $item->ulasan }}</textarea>
                                            </div>
                                            <div class="col-12 text-center">
                                                <label class="form-label fw-bold">Foto Pengaduan</label><br>
                                                @if($item->foto1 && file_exists(storage_path('app/public/' . $item->foto1)))
                                                    <img src="{{ asset('storage/' . $item->foto1) }}" class="img-fluid rounded shadow-sm" style="max-height: 300px;" alt="Foto Pengaduan">
                                                @else
                                                    <div class="text-muted fst-italic">Tidak ada foto yang dilampirkan.</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL FEEDBACK --}}
                        <div class="modal fade" id="feedbackModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('pengaduan.feedback', $item->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-content p-3">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Kirim Feedback</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <textarea name="feedback" class="form-control" rows="4" placeholder="Tulis feedback...">{{ old('feedback', $item->feedback ?? '') }}</textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Kirim</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pengaduan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $pengaduan->links() }}
        </div>
    </div>
</div>

<!-- SWEETALERT DELETE -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hapusButtons = document.querySelectorAll('.btnHapus');

        hapusButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const nama = this.dataset.nama;

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: `Data pengaduan ini akan dihapus secara permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('formHapus' + id).submit();
                    }
                });
            });
        });
    });
</script>

<!-- AUTOSUBMIT PENCARIAN -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.querySelector('input[name="katakunci"]');
        const searchForm = document.getElementById('searchForm');

        let timeout = null;
        searchInput.addEventListener('input', function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                searchForm.submit();
            }, 500);
        });
    });
</script>

<style>
    .action-btn {
        width: 40px;
        height: 40px;
        font-size: 1.1rem;
        padding: 0;
    }

    /* Optional: efek hover lembut */
    .action-btn:hover {
        filter: brightness(0.9);
        transition: 0.2s;
    }

    .modal-body .form-control[readonly],
    .modal-body textarea[readonly] {
        background-color: #f1f3f5;
        border: none;
        font-weight: 500;
        color: #333;
    }
</style>

@endsection