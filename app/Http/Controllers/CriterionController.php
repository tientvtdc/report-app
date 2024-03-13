<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Criterion;
use Illuminate\Http\Request;

class CriterionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $criteria = Criterion::orderBy('created_at', 'desc')->paginate(15);
        return view('criterion.list', compact('criteria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('criterion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string',
            'content' => 'required|string',
        ]);

        $criterion = Criterion::create($validatedData);
        return redirect()->route('criteria.index');
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
    public function edit(Criterion $criterion)
    {
        //

        return view('criterion.edit', compact('criterion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Criterion $criterion)
    {
        //
        $data = $request->all();
        $criterion->update($data);
        return redirect()->route('criteria.index')->with('success', 'Tiêu chí đã được cập nhật.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criterion $criterion)
    {
        $criterion->delete();
        return redirect()->back()->with('success', 'Minh chứng đã được xóa.');
    }
}
