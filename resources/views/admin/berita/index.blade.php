@extends('admin.layout.main')
@section('title', 'Berita')
@section('konten')

<div class="container-scroller">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Border Box -->
    <div class="container-scroller">
        <div class="p-4 rounded shadow bg-white">

            <h2 class="text-start mb-4">Berita</h2>
            <h4 class="text-start mb-4">Sediakan Berita Lokal Untuk Masyarakat</h4>

            <!-- FORM PENCARIAN -->
            <div class="pb-3">
                <form class="d-flex" action="{{ url('admin/berita') }}" method="get">
                    <input class="form-control me-1" type="search" name="katakunci" value="{{ Request::get('katakunci') }}" placeholder="Cari" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                </form>
            </div>

            <!-- TOMBOL TAMBAH DATA -->
            <div class="d-flex justify-content-end pb-3">
                <a href="{{ url('admin/berita/create') }}" class="btn btn-primary">+ Tambah Data</a>
            </div>

            <!-- Tabel Berita -->
            <div class="p-2 bg-body ">
                <table class="display expandable-table dataTable no-footer" style="width: 100%">
                    <thead class="table-primary">
                        <tr>
                            <th class="col-md-1 text-center">No</th>
                            <th class="col-md-2">Judul</th>
                            <th class="col-md-2 text-center">Gambar</th>
                            <th class="col-md-3">Deskripsi</th>
                            <th class="col-md-1">Tanggal</th>
                            <th class="col-md-1 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- untuk nomor agar langsung otomatis array --}}
                        <?php $i = $databerita->firstItem() ?>
                        {{-- foreach mengulagi databerita --}}
                        @forelse ($databerita as $item)
                        <tr>
                            <td style="vertical-align: top;" class="text-center">{{ $i }}</td>

                            <td style="vertical-align: top;" class="judul">
                                <p>{{ $item->judul }}</p>
                            </td>

                            <td style="vertical-align: top;" class="text-center">
                                {{-- memanggil juga gambar yg terletak didirectoru storage --}}
                                <img src="{{ asset('storage/imageberita/'.$item->image) }}" class="border" style="width: 200px; height: auto; border-radius: 0;">
                            </td>

                            <td class="deskripsi text-justify align-top">
                                <p>
                                    @php
                                        $words = explode(' ', strip_tags($item->deskripsi)); // Pecah deskripsi jadi array kata
                                    @endphp

                                    @if (count($words) > 50)
                                        {{ implode(' ', array_slice($words, 0, 50)) }}... 
                                    @else
                                        {{ $item->deskripsi }}
                                    @endif
                                </p>
                            </td>


                            <td style="vertical-align: top;" >{{ $item->tanggal }}</td>

                            {{-- untuk edit--}}
                            <td style="vertical-align: top;" class="text-center">
                                <a href="{{ url('admin/berita/'.$item->id_berita.'/edit') }}" class="btn btn-warning btn-sm me-2">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                {{-- button hapus --}}
                                <form id="formHapus{{ $item->id_berita }}" class="d-inline" action="{{ url('admin/berita/'.$item->id_berita) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="btn btn-danger btn-sm btnHapus"
                                            data-id="{{ $item->id_berita }}"
                                            data-nama="{{ $item->judul }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php $i++ ?>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <style>
                    table {
                     table-layout: fixed;
                     width: 100%;
                 }

                  td.judul, td.deskripsi {
                     white-space: normal;
                     word-wrap: break-word;
                     max-width: 400px;
                     text-align: justify;
                 }
                 </style>
                {{ $databerita->links() }}
            </div>

        </div>
    </div>


</div>
<!-- js notif deletet -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hapusButtons = document.querySelectorAll('.btnHapus');

        hapusButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: `Data berita dengan judul "${nama}" akan dihapus!`,
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

@endsection
