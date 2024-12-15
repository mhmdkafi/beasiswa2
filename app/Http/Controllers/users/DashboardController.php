<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use App\Models\PendaftarBeasiswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        $query = Beasiswa::query();

        // Handle search
        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Handle filter
        if ($request->has('tingkat_pendidikan') && $request->tingkat_pendidikan != '') {
            $query->where('tingkat_pendidikan', $request->tingkat_pendidikan);
        }

        $notificationCount = PendaftarBeasiswa::where('user_id', auth()->user()->id)
            ->where('status', '!=', 'pending')
            ->where('is_read', 0)
            ->count();

        $listBeasiswa = $query->latest()->get();

        return view('users.dashboard', [
            'listBeasiswa' => $listBeasiswa,
            'search' => $request->search,
            'filter' => $request->tingkat_pendidikan,
            'notificationCount' => $notificationCount
        ]);
    }
}
