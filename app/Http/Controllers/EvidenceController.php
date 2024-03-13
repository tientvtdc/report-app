<?php

namespace App\Http\Controllers;

use App\Models\AssessmentEvidence;
use Illuminate\Http\Request;
use App\Models\Evidence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EvidenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Evidence::orderBy('created_at', 'desc')->with('creator')->with('editor');

        if ($search = $request->input('q')) {
            $query->where('title', 'LIKE', "%{$search}%")
                ->orWhereHas('creator', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
        }

        $evidences = $query->paginate(30);
        $request->flashExcept(['_token']);
        return view('evidence.list', compact('evidences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('evidence.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'name_organizations' => 'nullable|string',
            'issued_at' => 'required|date',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png', // Xác thực file
        ]);

        $filePath = null;
        if ($request->hasFile('attachment')) {
            $originalFileName = $request->file('attachment')->getClientOriginalName();
            $filePath = $request->file('attachment')->storeAs('public/evidences', $originalFileName);
        }

        $evidence = Evidence::create([
            'title' => $validatedData['title'],
            'name_organizations' => $validatedData['name_organizations'],
            'attachment' => $filePath,
            'issued_at' => $validatedData['issued_at'],
            'valid_from' => $validatedData['valid_from'],
            'valid_to' => $validatedData['valid_to'],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('evidences.create')
            ->with('success', 'Minh chứng đã được tạo thành công.');
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
        $evidence = Evidence::findOrFail($id);
        if ($evidence->creator->id !== Auth::id() && !Auth::user()->hasRole('SUPER_ADMIN')) {
            abort(403, 'Unauthorized action.');
        }
        return view('evidence.edit', compact('evidence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evidence $evidence)
    {
        if ($evidence->creator->id !== Auth::id() && !Auth::user()->hasRole('SUPER_ADMIN')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'title' => 'required|string',
            'name_organizations' => 'nullable|string',
            'issued_at' => 'required|date',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after:valid_from',
            'attachment' => 'nullable|file|mimes:pdf',
        ]);

        $data = $request->all();

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('evidences');
            Storage::delete($evidence->attachment);
        }
        $data['issued_by'] = Auth::id();
        $evidence->update($data);

        return redirect()->route('evidences.index')->with('success', 'Minh chứng đã được cập nhật.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // Trong EvidenceController
    public function destroy(Evidence $evidence)
    {
        if ($evidence->creator->id !== Auth::id() && !Auth::user()->hasRole('SUPER_ADMIN')) {
            abort(403, 'Unauthorized action.');
        }

        $evidence->delete();
        if ($evidence->attachment && Storage::exists($evidence->attachment)) {
            Storage::delete($evidence->attachment);
        }
        return redirect()->route('evidences.index')->with('success', 'Minh chứng đã được xóa.');
    }

    public function search(Request $request)
    {
        $sortBy = $request->input('sortBy');
        $query = Evidence::orderBy('created_at', $sortBy)->with('creator')->with('editor');

        if ($search = $request->input('q')) {
            $query->where('title', 'LIKE', "%{$search}%")
                ->orWhereHas('creator', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
        }

        $evidences = $query->paginate(15);
        return response()->json($evidences);
    }

    public function getAssessmentEvidence(Request $request, string $id)
    {
        $assessmentEvidences = AssessmentEvidence::where('assessment_criterion_standard_id', $id)
            ->with('evidence')->orderBy('code', 'asc')->get();

        return response()->json($assessmentEvidences);
    }
}
