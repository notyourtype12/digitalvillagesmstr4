<nav class="sidebar sidebar-offcanvas sidebar-fixed" id="sidebar" style="background-color: #10243c">
    <style>
        .sidebar .menu-title, .sidebar span {
            color: white !important;
            font-weight: bold;
        }

        .sidebar .nav-item a.nav-link {
            color: white !important; /* Warna teks putih */
        }

        .sidebar .nav-item a.nav-link:hover {
            color: #ffcc00 !important; /* Warna hover jika diperlukan */
        }

        .sidebar .nav-item .sidebar-dropdown .nav-item a.nav-link {
            color: white !important; /* Warna teks putih */
        }

        /* Hover effect untuk submenu Akun RW dan RT */
        .sidebar .nav-item .sidebar-dropdown .nav-item a.nav-link:hover {
            color: white !important; /* Warna hover tetap putih */
        }
    </style>

    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/dashboard') }}">
                <i class="bi bi-house-fill me-3"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/master_kartukeluarga') }}" >
                <i class="bi bi-people-fill me-3"></i>
                <span class="menu-title">Kartu Keluarga</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link position-relative" data-bs-toggle="collapse" data-bs-target="#master-pengajuan" aria-expanded="false" aria-controls="master-pengajuan" id="toggle-master-pengajuan">
                <i class="bi bi-envelope-check-fill me-3 position-relative">
                    @if($jumlahPengajuan > 0)
                        <span class="position-absolute badge rounded-pill bg-danger" id="pengajuan-count"
                            style="top: 0; left: 140px; font-size: 10px; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; transform: translateY(-50%);">
                            {{ $jumlahPengajuan }}
                        </span>
                    @endif
                </i>
                <span class="menu-title">Pengajuan Surat</span>
                <i class="menu-arrow"></i>
            </a>


            <ul id="master-pengajuan" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="nav-item">
                    <a href="{{ url('admin/suratmasuk') }}" class="nav-link">Surat Masuk</a>
                </li>
                 <li class="nav-item">
                     <a href="{{ route('suratselesai.index') }}" class="nav-link">Surat Selesai</a>
                 </li>

                <li class="nav-item">
                    <a href="{{ url('admin/suratditolak') }}" class="nav-link">Surat Ditolak</a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#master-akun" aria-expanded="false" aria-controls="master-akun" id="toggle-master-akun">
                 <i class="bi bi-person-fill me-3"></i>
                <span class="menu-title">Master Akun</span>
                   <i class="menu-arrow"></i>
            </a>
            <ul id="master-akun" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="nav-item">
                    <a href="{{ url('admin/akunrw') }}" class="nav-link">Akun RW</a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/akunrt') }}" class="nav-link">Akun RT</a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/mastersurat') }}">
                <i class="bi bi-envelope-fill me-3"></i>
                <span class="menu-title">Master Surat</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/berita') }}">
                <i class="bi bi-newspaper me-3"></i>
                <span class="menu-title">Berita</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/pengaduan') }}">
                <i class="bi bi-megaphone me-3"></i>
                <span class="menu-title">Pengaduan Masyarakat</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/landingpage') }}">
                <i class="bi bi-globe-americas me-3"></i>
                <span class="menu-title">Website</span>
            </a>
        </li>
        
    </ul>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    // Hide Master Akun dropdown when Master Surat is clicked
    $('#toggle-master-pengajuan').click(function() {
        $('#master-akun').collapse('hide'); // Hide Master Akun
    });

    // Hide Pengajuan Surat dropdown when Master Akun is clicked
    $('#toggle-master-akun').click(function() {
        $('#master-pengajuan').collapse('hide'); // Hide Pengajuan Surat
    });
});

$(document).ready(function() {
    function loadPengajuanCount() {
        $.ajax({
            url: "{{ url('admin/count-pengajuan') }}",
            type: "GET",
            success: function(data) {
                if(data.count > 0) {
                    $('#pengajuan-count').text(data.count).show();
                } else {
                    $('#pengajuan-count').hide();
                }
            }
        });
    }

    // Load pertama
    loadPengajuanCount();

    // Refresh tiap 15 detik
    setInterval(loadPengajuanCount, 15000);
});



</script>

