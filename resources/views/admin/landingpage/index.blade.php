@extends('admin.layout.main')
@section('title', 'Edit Landingpage')
@section('konten')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body, input, textarea, button, .form-control, .col-form-label, h1, h2, h3, h4, h5, h6, p {
        font-family: 'Poppins', sans-serif !important;
    }
    
</style>

<!-- START FORM -->

<form action="{{ route('homepage.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="my-3 p-3 bg-body rounded shadow-sm">

        <h4 class="text-start mb-4 fw-bold">Edit Landingpage</h4>
        <div class="mb-3 row mt-5">
            <label class="col-sm-2 col-form-label">Judul</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="title" value="{{ $data->judul }}" required>
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Deskripsi</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="description" rows="6" required>{{ $data->deskripsi1 }}</textarea>
            </div>
        </div>
        

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Subjudul</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="subtittle">{{ $data->subtittle }}</textarea>
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Deskripsi Subjudul</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="section_text" rows="6" >{{ $data->section_text }}</textarea>
            </div>
        </div>

         {{-- Gambar Deskripsi 1 --}}
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Image Deskripsi 1</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" name="image_description1" id="image_description1">
                @if($data->image_description1)
                    <img src="{{ asset('storage/' . $data->image_description1) }}" class="img-fluid mt-2" width="200px" id="previewDesc1">
                @endif
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Subjudul 2</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="subtitle_2">{{ $data->subtitle_2 }}</textarea>
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Deskripsi Subjudul 2</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="section_second" rows="6" >{{ $data->section_second }}</textarea>
            </div>
        </div>

        {{-- Gambar Deskripsi 2 --}}
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Image Deskripsi 2</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" name="image_description2" id="image_description2">
                @if($data->image_description2)
                    <img src="{{ asset('storage/' . $data->image_description2) }}" class="img-fluid mt-2" width="200px" id="previewDesc2">
                @endif
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Visi</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="visi" rows="6" >{{ $data->visi }}</textarea>
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Misi</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="misi" rows="6" >{{ $data->misi }}</textarea>
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Tentang Kami</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="about_content" rows="6" >{{ $data->about_us }}</textarea>
            </div>
        </div>

        

        <div class="mb-3 row">
            <div class="col-sm-10 offset-sm-2 text-end">
                <button type="submit" class="btn btn-primary">SIMPAN</button>
            </div>
        </div>
    </div>
</form>

<!-- END FORM -->

<script>
    // Preview gambar langsung
    document.getElementById('hero_image')?.addEventListener('change', function(e){
        if (e.target.files[0]) {
            document.getElementById('previewHero').src = URL.createObjectURL(e.target.files[0]);
        }
    });

    document.getElementById('image_description1')?.addEventListener('change', function(e){
        if (e.target.files[0]) {
            document.getElementById('previewDesc1').src = URL.createObjectURL(e.target.files[0]);
        }
    });

    document.getElementById('image_description2')?.addEventListener('change', function(e){
        if (e.target.files[0]) {
            document.getElementById('previewDesc2').src = URL.createObjectURL(e.target.files[0]);
        }
    });
</script>

@endsection