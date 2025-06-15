<?php

namespace App\Http\Controllers;

// Model Uses
use App\Models\M_Divisions;

// Laravel Uses
use Illuminate\Http\Response;
use Illuminate\Http\Request;



class DivisionsController extends Controller
{
    protected $divisionModel;

    public function __construct()
    {
        $this->divisionModel = new M_Divisions();
    }

    /**
     * Display a listing of the divisions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = $this->divisionModel->newQuery();


        $perPage = request()->input('per_page', 10); // Default to 10
        $divisions = $query->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('divisions.index', compact('divisions'));
    }

    /**
     * Show the form for displaying the specified division.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $division = $this->divisionModel->find($id);
        if (!$division) {
            return redirect()->route('divisi.index')->with('error', 'Division not found.');
        }
        return view('divisions.show', compact('division'));
    }

    /**
     * Show the form for creating a new division.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('divisions.create');
    }

    /**
     * Store a newly created division in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $division = $this->divisionModel->newInstance();
        $division->name = $request->name;
        $division->description = $request->description;
        $division->save();

        return redirect()->route('divisi.index')->with('success', 'Division created successfully.');
    }
    /**
     * Show the form for editing the specified division.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $division = $this->divisionModel->find($id);
        if (!$division) {
            return redirect()->route('divisi.index')->with('error', 'Division not found.');
        }
        return view('divisions.edit', compact('division'));
    }

    /**
     * Update the specified division in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $division = $this->divisionModel->find($id);
        if (!$division) {
            return redirect()->route('divisi.index')->with('error', 'Division not found.');
        }

        $division->name = $request->name;
        $division->description = $request->description;
        $division->save();

        return redirect()->route('divisi.index')->with('success', 'Division updated successfully.');
    }
    /**
     * Remove the specified division from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $division = $this->divisionModel->find($id);
        if (!$division) {
            return redirect()->route('divisions.index')->with('error', 'Division not found.');
        }

        // Check if the division has any items associated with it
        if ($division->items()->count() > 0) {
            return redirect()->route('divisi.index')->with('error', 'Division cannot be deleted because it has associated items.');
        }

        $division->delete();

        return redirect()->route('divisi.index')->with('success', 'Division deleted successfully.');
    }
}