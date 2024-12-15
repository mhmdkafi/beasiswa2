<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use App\Models\PendaftarBeasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listBeasiswa = Beasiswa::all();
        return view('admin.beasiswa.index', compact('listBeasiswa'));
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
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'instansi' => 'required|string|max:255',
            'min_ipk' => 'required|numeric',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo_instansi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated = $request->all();

        //Name the file
        $thumbnailName = Str::uuid() . '.' . $request->thumbnail->extension();
        $bannerName = Str::uuid() . '.' . $request->banner->extension();
        $logoInstansiName = Str::uuid() . '.' . $request->logo_instansi->extension();

        //Upload
        $request->thumbnail->move(public_path('img/beasiswa'), $thumbnailName);
        $request->banner->move(public_path('img/beasiswa'), $bannerName);
        $request->logo_instansi->move(public_path('img/kampus'), $logoInstansiName);

        $validated['thumbnail'] = $thumbnailName;
        $validated['banner'] = $bannerName;
        $validated['logo_instansi'] = $logoInstansiName;

        Beasiswa::create($validated);

        return redirect()->back()->with('success', 'Beasiswa created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $beasiswa = Beasiswa::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'instansi' => 'required|string|max:255',
            'min_ipk' => 'required|numeric',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo_instansi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated = $request->except(['thumbnail', 'banner', 'logo_instansi']);

        if ($request->thumbnail) {
            if (file_exists(public_path('img/beasiswa/' . $beasiswa->thumbnail))) {
                unlink(public_path('img/beasiswa/' . $beasiswa->thumbnail));
            }
            $thumbnailName = Str::uuid() . '.' . $request->thumbnail->extension();
            $request->thumbnail->move(public_path('img/beasiswa'), $thumbnailName);
            $validated['thumbnail'] = $thumbnailName;
        }

        if ($request->banner) {
            if (file_exists(public_path('img/beasiswa/' . $beasiswa->banner))) {
                unlink(public_path('img/beasiswa/' . $beasiswa->banner));
            }
            $bannerName = Str::uuid() . '.' . $request->banner->extension();
            $request->banner->move(public_path('img/beasiswa'), $bannerName);
            $validated['banner'] = $bannerName;
        }

        if ($request->logo_instansi) {
            if (file_exists(public_path('img/kampus/' . $beasiswa->logo_instansi))) {
                unlink(public_path('img/kampus/' . $beasiswa->logo_instansi));
            }
            $logoInstansiName = Str::uuid() . '.' . $request->logo_instansi->extension();
            $request->logo_instansi->move(public_path('img/kampus'), $logoInstansiName);
            $validated['logo_instansi'] = $logoInstansiName;
        }

        $beasiswa->update($validated);

        return redirect()->back()->with('success', 'Beasiswa updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $beasiswa = Beasiswa::findOrFail($id);

        // Delete the associated images
        if (file_exists(public_path('img/beasiswa/' . $beasiswa->thumbnail))) {
            unlink(public_path('img/beasiswa/' . $beasiswa->thumbnail));
        }
        if (file_exists(public_path('img/beasiswa/' . $beasiswa->banner))) {
            unlink(public_path('img/beasiswa/' . $beasiswa->banner));
        }
        if (file_exists(public_path('img/kampus/' . $beasiswa->logo_instansi))) {
            unlink(public_path('img/kampus/' . $beasiswa->logo_instansi));
        }

        $beasiswa->delete();

        return redirect()->back()->with('success', 'Beasiswa deleted successfully');
    }

    public function listPendaftar($id)
    {
        //cek beasiswanya ada atau engga
        $beasiswa = Beasiswa::findOrFail($id);

        $listPendaftar = PendaftarBeasiswa::where('beasiswa_id', $id)->get();
        return view('admin.beasiswa.listPendaftar', compact(
            'beasiswa',
            'listPendaftar'
        ));
    }

    public function updateStatusPendaftar(Request $request, $id, $pendaftarId)
    {
        $beasiswa = Beasiswa::findOrFail($id);
        $pendaftar = PendaftarBeasiswa::where('beasiswa_id', $id)->where('user_id', $pendaftarId)->firstOrFail();
        // dd($pendaftar);
        $pendaftar->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status updated successfully');
    }

}
