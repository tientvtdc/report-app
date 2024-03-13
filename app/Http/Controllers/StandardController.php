<?php

namespace App\Http\Controllers;

use App\Models\Standard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StandardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $standards = Standard::paginate(15);
        return view("standards.list", compact('standards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("standards.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'standard_code' => 'required|string',
            'standard_point' => 'required|integer',
            'standard_description' => 'required|string',
        ], [
            'standard_code.required' => 'Vui lòng nhập mã tiêu chuẩn.',
            'standard_code.string' => 'Mã tiêu chuẩn phải là chuỗi.',
            'standard_point.required' => 'Vui lòng nhập điểm tiêu chuẩn.',
            'standard_point.integer' => 'Điểm tiêu chuẩn phải là số nguyên.',
            'standard_description.required' => 'Vui lòng nhập mô tả tiêu chuẩn.',
            'standard_description.string' => 'Mô tả tiêu chuẩn phải là chuỗi.',
        ]);
        $standard = new Standard;
//        $standard->criterion_id = $your_criterion_id; // Cần cung cấp criterion_id
        $standard->code = $validatedData['standard_code'];
        $standard->point = $validatedData['standard_point'];
        $standard->content = $validatedData['standard_description'];
        $standard->save();

        return redirect()->route('standards.index');
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
    public function edit(Standard $standard)
    {
        //
        return view('standards.edit', compact('standard'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Standard $standard)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:255',
            'point' => 'required|integer|min:1',
            'content' => 'required|string',
        ]);

        $standard->update($validatedData);

        session()->flash('success', 'Tiêu chuẩn đã được cập nhật thành công!');

        return redirect()->route('standards.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Standard $standard)
    {
        //
        $standard->delete();
        return redirect()->back()->with('success', 'tiêu chuẩn đã được xóa.');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $results = Standard::where('content', 'like', "%$query%")->get();
        return response()->json($results);
    }

}
