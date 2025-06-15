<?php

namespace App\Http\Controllers;

// Model Uses
use App\Models\M_Items;
use App\Models\M_Item_Categories;
use App\Models\M_Item_Histories;
use App\Models\M_Distributions;
use App\Models\User;

// Laravel Uses
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;





class ItemController extends Controller
{
    protected $itemModel,
        $itemCategoryModel,
        $itemHistoryModel,
        $distributionModel,
        $userModel;
    public function __construct()
    {
        $this->itemModel = new M_Items();
        $this->itemCategoryModel = new M_Item_Categories();
        $this->itemHistoryModel = new M_Item_Histories();
        $this->distributionModel = new M_Distributions();
        $this->userModel = new User();
    }

    /**
     * Display a listing of the items.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $categories = $this->itemCategoryModel->all();

        $query = $this->itemModel->newQuery();

        // Filter by division if user is pegawai
        $user = Auth::user();
        if ($user && $user->role === 'pegawai') {
            $query->where('division_id', $user->division_id);
        }

        $perPage = request()->input('per_page', 10); // Default to 10
        $items = $query->with(['category'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('items.index', compact('items', 'categories'));
    }

    /**
     * Show Items By ID
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = $this->itemModel->getItemsById($id);
        if (!$item) {
            return back()->with('error', 'Item not found.'); // Redirect back with error message
        }
        $histories = $this->itemHistoryModel->getHistoriesByItemId($id);
        $distributions = $this->distributionModel->getDistributionsByItemId($id);

        return view('items.show', compact('item', 'histories', 'distributions'));
    }

    /**
     * Show the form for creating a new item.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->itemCategoryModel->all();
        return view('items.create', compact('categories'));
    }

    /**
     * Store a newly created item in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'item_category_id' => 'required|exists:item_categories,id',
            'condition' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'purchase_year' => 'required|integer|min:1900|max:' . date('Y'),
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request->input('quantity');
        $getCategoryCode = $this->itemCategoryModel->find($request->item_category_id);

        // Handle file upload if exists
        $filename = null;
        if ($request->hasFile('photo_path')) {
            $file = $request->file('photo_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/items', $filename, 'public');
        }

        for ($i = 0; $i < $quantity; $i++) {
            // Generate unique ID for each item
            // Generate unique ID and ensure it's not already used
            do {
                if ($getCategoryCode) {
                    $id = $getCategoryCode->code . '-' . rand(1000, 9999);
                } else {
                    $id = 'ITEM-' . rand(1000, 9999);
                }
                $exists = $this->itemModel->where('id', $id)->exists();
            } while ($exists);

            $data = [
                'id' => $id,
                'name' => $request->name,
                'item_category_id' => $request->item_category_id,
                'condition' => $request->condition,
                'purchase_year' => $request->purchase_year,
                'photo_path' => $filename,
            ];

            // generate qr
            $qrCode = QrCode::size(200)->generate($id);
            // Save QR code as an image
            $path = 'uploads/sarana/qr_codes/';
            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }
            // Save QR code as an image
            $filePath = public_path($path . $id . '.png');
            QrCode::size(200)->format('png')->generate($id, $filePath);
            // Update item with QR code path
            $data['qr_code'] = 'uploads/sarana/qr_codes/' . $id . '.png';
            // Create the item
            $this->itemModel->create($data);
        }

        return redirect()->route('sarana.index')->with('success', 'Item(s) created successfully.');
    }

    /**
     * Show the form for editing the specified item.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->itemModel->getItemsById($id);
        if (!$item) {
            return redirect()->route('sarana.index')->with('error', 'Item not found.');
        }
        // dd($item);
        $categories = $this->itemCategoryModel->all();
        return view('items.edit', compact('item', 'categories'));
    }
    /**
     * Update the specified item in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'item_category_id' => 'required|exists:item_categories,id',
            'condition' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'purchase_year' => 'required|integer|min:1900|max:' . date('Y'),
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $item = $this->itemModel->find($id);
        if (!$item) {
            return redirect()->route('sarana.index')->with('error', 'Item not found.');
        }

        // Handle file upload if exists
        if ($request->hasFile('photo_path')) {
            $file = $request->file('photo_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/items', $filename, 'public');
        } else {
            $filename = $item->photo_path; // Keep the old photo if no new one is uploaded
        }

        $data = [
            'name' => $request->name,
            'item_category_id' => $request->item_category_id,
            'condition' => $request->condition,
            'purchase_year' => $request->purchase_year,
            'photo_path' => $filename,
        ];

        $item->update($data);

        return redirect()->route('sarana.index')->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified item from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = $this->itemModel->find($id);
        if (!$item) {
            return redirect()->route('sarana.index')->with('error', 'Item not found.');
        }

        // Check if the item has any distributions or histories
        $hasDistributions = $this->distributionModel->where('item_id', $id)->exists();
        $hasHistories = $this->itemHistoryModel->where('item_id', $id)->exists();
        if ($hasDistributions || $hasHistories) {
            return redirect()->route('sarana.index')->with('error', 'Item tidak dapat dihapus karena memiliki distribusi atau riwayat yang terkait.');
        }

        // Delete the item
        $item->delete();

        return redirect()->route('sarana.index')->with('success', 'Item deleted successfully.');
    }


    public function qrGenerate($id)
    {
        $item = $this->itemModel->getItemsById($id);
        if (!$item) {
            return redirect()->route('sarana.index')->with('error', 'Item not found.');
        }

        // 1. Definisikan path relatif untuk disimpan di database
        $relativePath = 'uploads/sarana/qr_codes/' . $item->id . '.png';

        // 2. Definisikan path absolut untuk direktori penyimpanan file
        $directoryPath = public_path('uploads/sarana/qr_codes');

        // 3. Gunakan File Facade Laravel untuk memeriksa dan membuat direktori
        // Ini adalah cara yang benar dan aman
        if (!File::isDirectory($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true, true);
        }

        // 4. Generate dan simpan QR code dalam satu langkah
        $filePath = public_path($relativePath);
        QrCode::size(200)->format('png')->generate($item->id, $filePath);

        // 5. Update item dengan path relatif
        // Menggunakan $item->update() lebih disarankan jika model Anda mengizinkannya
        $itemModel = $this->itemModel->find($item->id);
        $itemModel->qr_code = $relativePath;
        $itemModel->save();

        return redirect()->route('sarana.show', $id)->with('success', 'QR Code generated successfully.');
    }

    public function apiShow($id)
    {
        // Mengambil data item utama
        $item = $this->itemModel->getItemsById($id);

        // Jika item tidak ditemukan, kembalikan response error 404 dengan pesan JSON
        if (!$item) {
            return response()->json(['message' => 'Sarana tidak ditemukan.'], 404);
        }

        // Mengambil data pendukung
        $histories = $this->itemHistoryModel->getHistoriesByItemId($id);
        $distributions = $this->distributionModel->getDistributionsByItemId($id);

        // Mengambil distribusi terakhir untuk ditampilkan secara khusus
        $lastDistribution = collect($distributions)->sortByDesc('distributed_at')->first();

        // Mengembalikan semua data dalam satu paket JSON yang terstruktur
        return response()->json([
            'item'              => $item,
            'histories'         => $histories,
            'distributions'     => $distributions, // Anda bisa hapus ini jika sudah terwakili oleh 'histories'
            'last_distribution' => $lastDistribution
        ]);
    }
}
