{{-- start modal --}}
<!-- Button trigger modal -->
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Kepala Keluarga</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        {{-- start field --}}
        <form action="/master_kartukeluarga/masuk" method="POST">
            @csrf
        <div class="col-12">
            <label class="form-label">Nomor Kartu Keluarga</label>
            <input type="text" class="form-control" name="no_kk" placeholder="" required>
        </div>
        <div class="col-12">
            <label class="form-label">NIK</label>
            <input type="text" class="form-control" name="nik" placeholder="" required>
        </div>
        <div class="col-12">
            <label class="form-label">Nama Kepala Keluarga</label>
            <input type="text" class="form-control" name="nama_lengkap" placeholder="" required>
        </div>
        <div class="col-12">
            <label class="form-label">Alamat</label>
            <input type="text" class="form-control" name="alamat" placeholder="Isi Alamat" required>
        </div>
        <div class="col-6">
            <label class="form-label">RT</label>
            <input type="text" class="form-control" name="rt" placeholder="Isi RT" required>
        </div>
        <div class="col-6">
            <label class="form-label">RW</label>
            <input type="text" class="form-control" name="rw" placeholder="Isi RW" required>
        </div>
        <div class="col-12">
            <label class="form-label">Desa</label>
            <input type="text" class="form-control" name="desa" placeholder="Isi Desa" required>
        </div>
        <div class="col-12">
            <label class="form-label">Kecamatan</label>
            <input type="text" class="form-control" name="kecamatan" placeholder="Isi Kecamatan" required>
        </div>
        <div class="col-6">
            <label class="form-label">Kode Pos</label>
            <input type="text" class="form-control" name="kode_pos" placeholder="Isi Kode Pos" required>
        </div>
        <div class="col-6">
            <label class="form-label">Kabupaten</label>
            <input type="text" class="form-control" name="kabupaten" placeholder="Isi Kabupaten" required>
        </div>
        <div class="col-12">
            <label class="form-label">Provinsi</label>
            <input type="text" class="form-control" name="provinsi" placeholder="Isi Provinsi" required>
        </div>
        <div class="col-12">
            <label class="form-label">Tanggal Dibuat</label>
            <input type="date" class="form-control" name="tanggal_dibuat" required>
        </div>
        {{-- end field --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
  </div>
{{-- end modal dan tambah data --}}
