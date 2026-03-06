<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Data Anggota Keluarga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.5rem;
            color: #dc3545;
            cursor: pointer;
        }
        .close-btn:hover {
            color: #b02a37;
        }
        @media (max-width: 576px) {
            .card {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card shadow-sm position-relative">
            <i class="bi bi-x-circle close-btn" onclick="goBack()"></i>
            <h4 class="text-primary mb-4 text-center">Edit Data Anggota Keluarga</h4>
            <form action="/master_penduduk/{{$master_penduduk->nik}}" method="post">
                @csrf
                @method('put')
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Nomor KK</label>
                        <input type="text" class="form-control" name="no_kk" value="{{ $master_penduduk->no_kk }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nik" value="{{ $master_penduduk->nik }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap" value="{{ $master_penduduk->nama_lengkap }}" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Jenis Kelamin</label>
                        <select class="form-select" name="jenis_kelamin" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" value="{{ $master_penduduk->tanggal_lahir }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" value="{{ $master_penduduk->tempat_lahir }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Agama</label>
                        <select class="form-select" name="agama" required>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katholik">Katholik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pendidikan</label>
                        <select class="form-select" name="pendidikan" required>
                            <option value="Tidak Sekolah">Tidak / Belum Sekolah</option>
                            <option value="SD">Tamat SD</option>
                            <option value="SMP">SLTP / Sederajat</option>
                            <option value="SMA">SLTA / Sederajat</option>
                            <option value="D1-D3">Diploma I/II/III</option>
                            <option value="S1">Strata I</option>
                            <option value="S2">Strata II</option>
                            <option value="S3">Strata III</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" name="pekerjaan" value="{{ $master_penduduk->pekerjaan }}" required>
                    </div>
    
                    <div class="col-md-6">
                        <label class="form-label">Golongan Darah</label>
                        <select class="form-select" name="golongan_darah" required>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                    <label class="form-label">kewarganegaraan</label>
                   
                    <select class="form-select" name="kewarganegaraan" id="kewarganegaraan" value="{{ $master_penduduk->kewarganegaraan }}" required>>
                        <option value="WNA">WNA</option>
                        <option value="WNI">WNI</option>
                       
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="no_kitab">No kitap</label>
                    <input type="text" class="form-control" name="no_kitap" id="no_kitap" value="{{ $master_penduduk->no_kitap }}" >

                    <div class="col-md-6">
                        <label class="form-label" for="no_kitab">No kitap</label>
                        <input type="text" class="form-control" name="no_kitap" id="no_kitap" value="{{ $master_penduduk->no_kitap }}" >
                    </div>
                </div>
                    <div class="col-md-6">
                        <label class="form-label">No Paspor</label>
                        <input type="text" class="form-control" name="no_paspor" value="{{ $master_penduduk->no_paspor }}" required>
                    </div>
                    
                                        <div class="col-md-6">
                        <label class="form-label">Status Perkawinan</label>
                        <select class="form-select" name="status_perkawinan" required>
                            <option value="Belum Kawin">Belum Kawin</option>
                            <option value="Kawin">Kawin</option>
                            <option value="Cerai Hidup">Cerai Hidup</option>
                            <option value="Cerai Mati">Cerai Mati</option>
                        </select>
                    </div>
    
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Perkawinan</label>
                        <input type="date" class="form-control" name="tanggal_perkawinan" value="{{ $master_penduduk->tanggal_perkawinan }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Hubungan Keluarga</label>
                        <select class="form-select" name="status_keluarga" required>
                            <option value="Kepala Keluarga">Kepala Keluarga</option>
                            <option value="Suami">Suami</option>
                            <option value="Istri">Istri</option>
                            <option value="Anak">Anak</option>
                            <option value="Orang Tua">Orang Tua</option>
                            <option value="Mertua">Mertua</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Ayah</label>
                        <input type="text" class="form-control" name="nama_ayah" value="{{ $master_penduduk->nama_ayah }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Ibu</label>
                        <input type="text" class="form-control" name="nama_ibu" value="{{ $master_penduduk->nama_ibu }}" required>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const kewarganegaraanSelect = document.getElementById('kewarganegaraan');
        const nokitapInput = document.getElementById('no_kitap');

        function toggleNokitap() {
            if (kewarganegaraanSelect.value === 'WNA') {

            if (kewarganegaraanSelect.value === 'WNI') {
                nokitapInput.value = ''; // Kosongkan input
                nokitapInput.disabled = true; // Nonaktifkan input
            } else {
                nokitapInput.disabled = false; // Aktifkan input
            }
        }

        // Panggil fungsi saat halaman dimuat
        toggleNokitap();

        // Tambahkan event listener untuk perubahan pada dropdown
        kewarganegaraanSelect.addEventListener('change', toggleNokitap);
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
