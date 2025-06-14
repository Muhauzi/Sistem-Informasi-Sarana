<?php

namespace App\Http\Controllers;

// Model Uses
use App\Models\M_Item_Categories;
// Laravel Uses
use Illuminate\Http\Response;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new M_Item_Categories();
    }

    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = $this->categoryModel->newQuery();
        // Optional search
        if (request()->has('search') && request()->search !== null) {
            $query->where('name', 'like', '%' . request()->search . '%');
        }
        $categories = $query->orderBy('created_at', 'desc')
            ->paginate(10) // Default to 10 items per page
            ->withQueryString();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:item_categories,code',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'code.max' => 'Kode maksimal 50 karakter.',
            'code.unique' => 'Kode sudah digunakan.',
        ]);

        $data = [
            'name' => $request->input('name'),
            'code' => $request->input('code', null),
        ];

        $category = $this->categoryModel->createCategory($data);

        if (!$category) {
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan kategori.']);
        }

        return redirect()->route('kategori-sarana.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->route('kategori-sarana.index')->withErrors(['error' => 'Kategori tidak ditemukan.']);
        }

        return view('categories.edit', compact('category'));
    }
    /**
     * Update the specified category in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:item_categories,code,' . $id,
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'code.max' => 'Kode maksimal 50 karakter.',
            'code.unique' => 'Kode sudah digunakan.',
        ]);

        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->route('kategori-sarana.index')->withErrors(['error' => 'Kategori tidak ditemukan.']);
        }

        $category->name = $request->input('name');
        $category->code = $request->input('code', null);
        $category->save();

        return redirect()->route('kategori-sarana.index')->with('success', 'Kategori berhasil diperbarui.');
    }
    /**
     * Remove the specified category from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->route('kategori-sarana.index')->withErrors(['error' => 'Kategori tidak ditemukan.']);
        }

        // Check if the category has associated items
        if ($category->items()->count() > 0) {
            return redirect()->route('kategori-sarana.index')->withErrors(['error' => 'Kategori tidak dapat dihapus karena masih memiliki item terkait.']);
        }

        $category->delete();

        return redirect()->route('kategori-sarana.index')->with('success', 'Kategori berhasil dihapus.');
    }
}