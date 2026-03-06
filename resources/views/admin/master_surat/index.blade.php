@extends('admin.layout.main')
@section('konten')
@section('title', 'Master Surat')
    
<!doctype html>
<html lang="en">

<body class="bg-light">
<div class="container-scroller">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="text-start mb-4">Master Surat</h2>
            </div>

            <div class="pb-3">
              <form id="searchForm" class="d-flex" action="{{ route('mastersurat.index') }}" method="get">
                  <input class="form-control me-1" type="search" name="katakunci"
                    id="searchInput"
                    value="{{ Request::get('katakunci') }}"
                    placeholder="Cari" aria-label="Search"
                    autocomplete="off">
                <button class="btn btn-outline-primary" type="submit">Cari</button>
                </form>
            </div>

            <div class="pb-3" style="text-align:right;">
                <a href="#" class="btn btn-primary" id="btnTambahSurat" data-id_surat="{{ $id_surat }}">+ Tambah Data</a>

            </div>

            {{-- Tabel Data --}}
            <div class="table-responsive">
                <table class="display expandable-table dataTable no-footer" style="width: 100%">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>ID Surat</th>
                            <th>Nama Surat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($datasurat as $item)
                            @if (!is_null($item->nama_surat))
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $item->id_surat }}</td>
                                <td>{{ $item->nama_surat}}</td> 
                                {{-- <td>
                                    <img src="{{ asset('storage/surat/' . $item->image) }}" width="100">
                                </td> --}}

                    <td>
                        <button type="button" class="btn btn-warning btn-sm btnEditSurat"
                            data-action="{{ route('mastersurat.update', $item->id_surat) }}"
                            data-id="{{ $item->id_surat }}"
                            data-nama="{{ $item->nama_surat }}"\>
                            <i class="bi bi-pencil-square"></i>
                        </button>


                        <form method="POST" action="{{ route('mastersurat.destroy', $item->id_surat) }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btnDeleteSurat"
                                data-nama="{{ $item->nama_surat }}">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>

                    </td>
                </tr>
                @endif
            @endforeach

            </tbody>
                </table>
                {{ $datasurat->withQueryString()->links() }}
            </div>

            {{-- Modal Tambah/Edit --}}
            <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modalTitle">Tambah Surat</h4>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formSurat" method="POST" enctype="multipart/form-data" data-store-url="{{ route('mastersurat.store') }}" action="{{ route('mastersurat.store') }}">

                                @csrf
                                <input type="hidden" name="_method" id="formMethod" value="POST">
                               <div class="mb-3">
                                    <label for="inputIdSurat" class="form-label">ID Surat</label>
                                    <input type="text" class="form-control" id="inputIdSurat" name="id_surat" value="{{ old('id_surat') }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="inputNamaSurat" class="form-label">Nama Surat</label>
                                    <input type="text" class="form-control" id="inputNamaSurat" name="nama_surat" required>
                                </div>
                                <div class="mb-3">
                                    <label for="inputImage" class="form-label">Gambar</label>
                                    <input type="file" class="form-control" id="inputImage" name="image" accept="image/*">
                                        @if (isset($surat) && $surat->image)
                                            <div class="mt-2">
                                                <label>Gambar Lama:</label>
                                                <br>
                                               <img id="gambarLama" src="" width="100" alt="Image Surat">
                                            </div>
                                        @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

{{-- JS Form Handler --}}
<script src="{{ asset('js/mastersurat.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');

    let timeout = null;
    searchInput.addEventListener('input', function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            searchForm.submit();
        }, 500); // Delay 500ms agar tidak submit terlalu sering
    });
});
</script>
</body>
@endsection