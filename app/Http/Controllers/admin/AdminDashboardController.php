<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use App\Models\PendaftarBeasiswa;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userCount = User::count();
        $beasiswaCount = Beasiswa::count();
        $pendaftarBeasiswaCount = PendaftarBeasiswa::count();
        return view('admin.dashboard', compact('userCount', 'beasiswaCount', 'pendaftarBeasiswaCount'));
    }
}
