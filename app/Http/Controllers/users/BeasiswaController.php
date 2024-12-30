<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use App\Models\PendaftarBeasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $beasiswa = Beasiswa::findOrFail($id);

        //cek ipk
        if (auth()->user()->ipk < $beasiswa->min_ipk) {
            return redirect()->route('scholarship.show', $beasiswa->id)->with('error', 'IPK anda tidak memenuhi syarat');
        }

        //cek sudah mendaftar atau belum
        $pendaftar = PendaftarBeasiswa::where('user_id', auth()->user()->id)->where('beasiswa_id', $beasiswa->id)->first();
        if ($pendaftar) {
            return redirect()->route('scholarship.show', $beasiswa->id)->with('error', 'Anda sudah mendaftar');
        }

        $notificationCount = PendaftarBeasiswa::where('user_id', auth()->user()->id)
            ->where('status', '!=', 'pending')
            ->where('is_read', 0)
            ->count();

        return view('users.beasiswa.form', compact('beasiswa', 'notificationCount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $beasiswa = Beasiswa::findOrFail($id);

        $request->validate([
            'transkrip_file' => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048',
            'biodata' => 'required|string',
            'email' => 'required|email',
            'penghasilan_orang_tua' => 'required|numeric'
        ]);

        $cekExist = PendaftarBeasiswa::where('user_id',auth()->user()->id)->where
        ('beasiswa_id', $beasiswa->id)->first();


        $validated = $request->all();


        //Name the file
        $transkripName = Str::uuid() . '.' . $request->transkrip_file->extension();

        //Upload
        $request->transkrip_file->move(public_path('files/transkrip'), $transkripName);

        $validated['user_id'] = auth()->user()->id;
        $validated['beasiswa_id'] = $beasiswa->id;
        $validated['transkrip_file'] = $transkripName;
        $validated['status'] = 'pending';

        PendaftarBeasiswa::create($validated);

        return redirect()->route('scholarship.show', $beasiswa->id)->with('success', 'Pendaftaran berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $beasiswa = Beasiswa::findOrFail($id);
        $notificationCount = PendaftarBeasiswa::where('user_id', auth()->user()->id)
            ->where('status', '!=', 'pending')
            ->where('is_read', 0)
            ->count();
        return view('users.beasiswa.index', compact('beasiswa', 'notificationCount'));
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
