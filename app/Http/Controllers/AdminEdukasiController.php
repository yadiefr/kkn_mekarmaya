<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edukasi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminEdukasiController extends Controller
{
    /**
     * Display the Kelola Edukasi view.
     */
    public function index()
    {
        $edukasis = Edukasi::latest()->get();
        return view('admin.edukasi', compact('edukasis'));
    }

    /**
     * Store a new educational content.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            
            $dir = public_path('uploads/edukasi');
            if (!file_exists($dir)) @mkdir($dir, 0777, true);
            
            $cpanelDir = base_path('../public_html/uploads/edukasi');
            if (!file_exists($cpanelDir) && file_exists(base_path('../public_html'))) {
                @mkdir($cpanelDir, 0777, true);
            }

            $image->move($dir, $imageName);
            
            if (file_exists(base_path('../public_html')) && file_exists($dir . '/' . $imageName)) {
                @copy($dir . '/' . $imageName, $cpanelDir . '/' . $imageName);
            }

            $imagePath = 'uploads/edukasi/' . $imageName;
        }

        Edukasi::create([
            'title' => $request->title,
            'category' => $request->category,
            'content' => $request->content,
            'image_path' => $imagePath,
            'icon' => $this->getIconForCategory($request->category),
        ]);

        return redirect()->route('admin.edukasi')->with('success', 'Konten edukasi berhasil ditambahkan!');
    }

    /**
     * Update existing educational content.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $edukasi = Edukasi::findOrFail($id);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($edukasi->image_path && file_exists(public_path($edukasi->image_path))) {
                unlink(public_path($edukasi->image_path));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/edukasi'), $imageName);
            $edukasi->image_path = 'uploads/edukasi/' . $imageName;
        }

        $edukasi->title = $request->title;
        $edukasi->category = $request->category;
        $edukasi->content = $request->content;
        $edukasi->icon = $this->getIconForCategory($request->category);
        $edukasi->save();

        return redirect()->route('admin.edukasi')->with('success', 'Konten edukasi berhasil diperbarui!');
    }

    /**
     * Remove the specified educational content.
     */
    public function destroy($id)
    {
        $edukasi = Edukasi::findOrFail($id);
        
        // Hapus gambar terkait jika ada
        if ($edukasi->image_path && file_exists(public_path($edukasi->image_path))) {
            unlink(public_path($edukasi->image_path));
        }

        $edukasi->delete();

        return redirect()->route('admin.edukasi')->with('success', 'Konten edukasi berhasil dihapus!');
    }

    /**
     * Helper to get FontAwesome icon based on category.
     */
    private function getIconForCategory($category)
    {
        $category = Str::lower($category);
        if (Str::contains($category, 'daur ulang') || Str::contains($category, 'plastik')) return 'fa-recycle';
        if (Str::contains($category, 'berita') || Str::contains($category, 'desa')) return 'fa-newspaper';
        if (Str::contains($category, 'kompos') || Str::contains($category, 'organik')) return 'fa-mortar-pestle';
        if (Str::contains($category, 'energi')) return 'fa-lightbulb';
        if (Str::contains($category, 'alam') || Str::contains($category, 'pohon')) return 'fa-tree';
        if (Str::contains($category, 'air')) return 'fa-droplet';
        return 'fa-book';
    }
}
