@extends('admin.layout.main')
@section('title', 'Tambah Berita')
@section('konten')

<!-- START FORM -->
 <form action='{{ url('admin/berita') }}' method='post' enctype="multipart/form-data">
    @csrf
    <div class="my-3 p-3 bg-body rounded shadow-sm">
         {{-- tombol kembali start--}}
         <a  href="{{ url('admin/berita') }}" class="btn btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
              </svg> Kembali 
         </a>
         {{-- tombol kembali end--}}

        <div class="mb-3 row mt-5">
            <label for="id_berita" class="col-sm-2 col-form-label">ID Berita</label>
            <div class="col-sm-10">
                <input type="text" name="id_berita" value="{{ $idBerita }}" readonly class="form-control">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="judul" class="col-sm-2 col-form-label">Judul Berita</label>
            <div class="col-sm-10"> 
                <input type="text" class="form-control" name='judul' id="judul" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
            <div class="col-sm-10">
                {{-- <input type="text" class="form-control" name='deskripsi' id="deskripsi" required> --}}
                <textarea rows="8" type="text" class="form-control" name='deskripsi' id="deskripsi" required ></textarea>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="image" class="col-sm-2 col-form-label">Gambar</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" name="image" id="image" required>
                <img src="" id="showImage" class="img-fluid" width="200px">
            </div>
        </div>
                <div class="mb-3 row">
                    <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name='tanggal' id="tanggal" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="submit" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button></div>
                </div>
            </div>
            @include('sweetalert::alert')
        </form>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#image').change(function(e){
                        var reader = new FileReader();
                        reader.onload = function(e){
                            $('#showImage').attr('src', e.target.result).show();
                        }
                        reader.readAsDataURL(e.target.files[0]);
                    });
                });

                document.getElementById('tanggal').addEventListener('focus', function(e) {
                    this.showPicker && this.showPicker(); // Untuk browser yang support showPicker()
                });
                </script>
            @endsection

