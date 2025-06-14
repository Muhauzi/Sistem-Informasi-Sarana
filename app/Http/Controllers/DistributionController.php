<?php

namespace App\Http\Controllers;

// Model Uses
use App\Models\M_Distributions;
use App\Models\M_Items;
use App\Models\M_Item_Histories;
use App\Models\M_Divisions;
// Laravel Uses
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DistributionController extends Controller
{
    protected $distributionModel,
        $itemModel,
        $divisionModel,
        $itemHistoryModel;

    public function __construct()
    {
        $this->distributionModel = new M_Distributions();
        $this->itemModel = new M_Items();
        $this->divisionModel = new M_Divisions();
        $this->itemHistoryModel = new M_Item_Histories();
    }

    /**
     * Display a listing of the distributions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = $this->distributionModel->newQuery();

        // Optional search
        if (request()->has('search') && request()->search !== null) {
            $query->where('name', 'like', '%' . request()->search . '%');
        }

        $distributions = $query->orderBy('created_at', 'desc')
            ->paginate(10) // Default to 10 items per page
            ->withQueryString();

        return view('distributions.index', compact('distributions'));
    }

    /**
     * Display the specified distribution with related items and histories.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $distribution = $this->distributionModel
            ->with(['itemHistories.item', 'division'])
            ->find($id);

        if (!$distribution) {
            return redirect()->route('distributions.index')->with('error', 'Distribution not found.');
        }

        return view('distributions.show', compact('distribution'));
    }

    /**
     * Show the form for creating a new distribution.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisions = \App\Models\M_Divisions::all();

        return view('distributions.create', compact('divisions'));
    }

    public function createGetItems($idItems)
    {
        $items = $this->itemModel->find($idItems);
        if (!$items) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        return response()->json($items, 200);
    }

    /**
     * Store a newly created distribution in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'description' => 'nullable|string|max:255',
            'distributed_at' => 'required|date',
            'item_id' => 'required|array|min:1',
            'item_id.*' => 'required|distinct|exists:items,id',
        ], [
            'division_id.required' => 'Divisi wajib diisi.',
            'division_id.exists' => 'Divisi yang dipilih tidak valid.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
            'distributed_at.required' => 'Tanggal distribusi wajib diisi.',
            'distributed_at.date' => 'Tanggal distribusi harus berupa tanggal yang valid.',
            'item_id.required' => 'Pilih setidaknya satu item untuk didistribusikan.',
            'item_id.array' => 'Data item tidak valid.',
            'item_id.min' => 'Pilih setidaknya satu item untuk didistribusikan.',
            'item_id.*.required' => 'Setiap item harus diisi.',
            'item_id.*.distinct' => 'Terdapat item yang duplikat.',
            'item_id.*.exists' => 'Item yang dipilih tidak valid.',
        ]);

        try {
            $distribution = $this->distributionModel->create([
                'division_id' => $request->division_id,
                'distributed_by' => Auth::id(),
                'description' => $request->description,
                'distributed_at' => $request->distributed_at,
            ]);

            if ($request->has('item_id')) {
                foreach ($request->item_id as $itemId) {
                    $item = $this->itemModel->find($itemId);
                    $fromDivisionId = $item ? $item->division_id : null;
                    $distribution->itemHistories()->create([
                        'distribution_id' => $distribution->id,
                        'item_id' => $itemId,
                        'from_division_id' => $fromDivisionId,
                        'to_division_id' => $request->division_id,
                    ]);
                    $item->update(['division_id' => $request->division_id]); // Update item division
                }
            }

            return redirect()->route('distributions.index')->with('success', 'Distribution created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create distribution: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified distribution.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $distribution = $this->distributionModel->find($id);
        if (!$distribution) {
            return redirect()->route('distributions.index')->with('error', 'Distribution not found.');
        }

        $divisions = $this->divisionModel::all();
        $items = $this->itemHistoryModel->getItemByDistributions($id);
        //  dd($items);

        if ($items->isEmpty()) {
            return redirect()->route('distributions.index')->with('error', 'No items found for this distribution.');
        }

        return view('distributions.edit', compact('distribution', 'divisions', 'items'));
    }


    /**
     * Update the specified distribution in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'description' => 'nullable|string|max:255',
            'distributed_at' => 'required|date',
            'item_id' => 'required|array|min:1',
            'item_id.*' => 'required|distinct|exists:items,id',
        ], [
            'division_id.required' => 'Divisi wajib diisi.',
            'division_id.exists' => 'Divisi yang dipilih tidak valid.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
            'distributed_at.required' => 'Tanggal distribusi wajib diisi.',
            'distributed_at.date' => 'Tanggal distribusi harus berupa tanggal yang valid.',
            'item_id.required' => 'Pilih setidaknya satu item untuk didistribusikan.',
            'item_id.array' => 'Data item tidak valid.',
            'item_id.min' => 'Pilih setidaknya satu item untuk didistribusikan.',
            'item_id.*.required' => 'Setiap item harus diisi.',
            'item_id.*.distinct' => 'Terdapat item yang duplikat.',
            'item_id.*.exists' => 'Item yang dipilih tidak valid.',
        ]);

        try {
            $distribution = $this->distributionModel->findOrFail($id);

            $distribution->update([
                'division_id' => $request->division_id,
                'description' => $request->description,
                'distributed_at' => $request->distributed_at,
            ]);

            // Hapus histori item lama
            $distribution->itemHistories()->delete();

            // Tambahkan histori item baru
            foreach ($request->item_id as $itemId) {
                $item = $this->itemModel->find($itemId);
                $fromDivisionId = $item ? $item->division_id : null;
                $distribution->itemHistories()->create([
                    'distribution_id' => $distribution->id,
                    'item_id' => $itemId,
                    'from_division_id' => $fromDivisionId,
                    'to_division_id' => $request->division_id,
                ]);
                $item->update(['division_id' => $request->division_id]); // Update item division
            }

            return redirect()->route('distributions.index')->with('success', 'Distribution updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update distribution: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified distribution from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $distribution = $this->distributionModel->find($id);
        if (!$distribution) {
            return redirect()->route('distributions.index')->with('error', 'Distribution not found.');
        }

        $distribution->delete();

        return redirect()->route('distributions.index')->with('success', 'Distribution deleted successfully.');
    }
}
