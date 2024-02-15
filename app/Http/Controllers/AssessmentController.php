<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Criterion;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assessments = Assessment::orderBy('created_at', 'desc')->with('program')->paginate(15);
        return view('assessment.list', compact('assessments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programs = Program::all();
        $criteria = Criterion::all();
        return view('assessment.create', compact('programs', 'criteria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate dữ liệu gửi từ form
        $validatedData = $request->validate([
            'schoolyear' => 'required|integer',
            'program_id' => 'required|exists:programs,id',
            'assessment_content' => 'required',
            'criteria' => 'array',
            'criteria.*' => 'exists:criteria,id',
        ], [
            'schoolyear.required' => 'Trường Năm không được để trống.',
            'schoolyear.integer' => 'Trường Năm phải là một số nguyên.',
            'program_id.required' => 'Trường Chương trình không được để trống.',
            'program_id.exists' => 'Chương trình đã chọn không tồn tại.',
            'assessment_content.required' => 'Trường Nội dung đánh giá không được để trống.',
            'criteria.array' => 'Danh sách tiêu chí phải là một mảng.',
            'criteria.*.exists' => 'Một hoặc nhiều tiêu chí đã chọn không tồn tại.',
        ]);
        // Tạo một đánh giá mới
        $assessment = new Assessment();
        $assessment->schoolyear = $request->schoolyear;
        $assessment->program_id = $request->program_id;
        $assessment->content = $request->assessment_content;
        $assessment->save();

        // Lưu các tiêu chí được chọn cho đánh giá
        $assessment->criteria()->attach($request->criteria);

        return redirect()->route('assessments.index')->with('success', 'Đánh giá đã được tạo thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $assessment = Assessment::with('program')->find($id);
        return view('assessment.show', compact('id', 'assessment'));
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
