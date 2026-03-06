<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\master_pengajuan;

class AppServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        //
    }


    public function boot()
    {
    Paginator::useBootstrapFive();

    $jumlahPengajuan = master_pengajuan::where('status', 'Diajukan')->count();
    View::share('jumlahPengajuan', $jumlahPengajuan);
    }
}
