<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\PendaftarBeasiswa;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PendaftarBeasiswa::where('user_id', auth()->user()->id)->latest()->get();

        //map the data based on month
        $listPengumuman = $data->mapToGroups(function ($item, $key) {
            return [$item->updated_at->format('F Y') => $item];
        });

        // dd($listPengumuman);
        return view('users.announcement.index', compact('listPengumuman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pendaftar = PendaftarBeasiswa::findOrFail($id);
        if ($pendaftar->status == 'pending') {
            return redirect()->route('announcement.index');
        }

        if ($pendaftar->is_read == 0) {
            $pendaftar->update(['is_read' => 1]);
        }

        return view('users.announcement.detail', compact('pendaftar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
