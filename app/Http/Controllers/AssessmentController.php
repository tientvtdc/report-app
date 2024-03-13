<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentCriterion;
use App\Models\AssessmentCriterionStandard;
use App\Models\AssessmentEvidence;
use App\Models\Criterion;
use App\Models\Evidence;
use App\Models\Program;
use App\Models\Standard;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mockery\Exception;
use PhpOffice\PhpWord\PhpWord;

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


    public function addEvidence(Request $request)
    {
        $evidencesData = $request->input('evidences');
        $assessment_criterion_standard_id = $request->input('assessment_criterion_standard_id');

        if ($evidencesData) {
            foreach ($evidencesData as $evidenceData) {
                AssessmentEvidence::updateOrCreate([
                    'assessment_criterion_standard_id' => $assessment_criterion_standard_id,
                    'evidence_id' => $evidenceData['id'],
                ], [
                    'code' => $evidenceData['code'],
                    'added_by' => Auth::user()['id']
                ]);

            }
        }


        $assessmentEvidenceOld = AssessmentEvidence::where('assessment_criterion_standard_id',
            $assessment_criterion_standard_id)
            ->with('evidence')->get();

        $assessmentEvidenceOld->each(function ($oldEvidence) use ($evidencesData) {
            $evidenceId = $oldEvidence->evidence_id;
            $existsInInput = collect($evidencesData)->contains('id', $evidenceId);

            if (!$existsInInput || !$evidencesData) {
                $oldEvidence->delete();
            }
        });

        return redirect()->back()->with('success', 'Cập nhật thông tin bằng chứng thành công.');
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
        return Redirect::back()->with('success', 'Đánh giá đã được tạo thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $assessment = Assessment::with('program',
            'assessmentCriterionStandards')->find($id);
        $assessmentCriteria = AssessmentCriterion::where('assessment_id', $id)
            ->with('criterion')->get()
            ->sortBy('criterion.code');

        return view('assessment.show', compact('id',
            'assessment', 'assessmentCriteria'));
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
    public function destroy(Assessment $assessment)
    {
        $assessment->delete();
        return redirect()->back()->with('success', 'Đánh giá đã được xoá thành công!');
    }

    public function addStandards(Request $request, string $id)
    {
        $assessment = Assessment::with('program')->find($id);
        $criteriaID = $request->query('idCriteria');
        $criteria = Criterion::find($criteriaID);
        $standards = Standard::paginate(10);
        $assessmentCriterionStandards = AssessmentCriterionStandard::whereHas('assessmentCriterion',
            function ($query) use ($id, $criteriaID) {
                $query->where('assessment_id', $id)
                    ->where('criterion_id', $criteriaID);
            })->with('standard')->get();
        return view('assessment.add-standard',
            compact('id', 'assessment', 'criteria',
                'standards', 'assessmentCriterionStandards'));
    }

    public function saveNewStandards(Request $request, string $id)
    {
        var_dump($request->input());

        $standards = $request->input('standards');
        $criteriaID = $request->query('idCriteria');
        $assessmentCriterion = AssessmentCriterion::where('assessment_id', $id)
            ->where('criterion_id', $criteriaID)
            ->first();
        $assessmentCriterionStandards = AssessmentCriterionStandard::where('assessment_criterion_id', $assessmentCriterion->id)
            ->with('standard')
            ->get();

        foreach ($assessmentCriterionStandards as $assessmentCriterionStandard) {

            $standardId = $assessmentCriterionStandard['standard']['id'];
            $assessed_point = $assessmentCriterionStandard['standard']['point'];
            if (isset($standards[$standardId])) {
                if ($standards[$standardId]['point'] !== $assessed_point) {
                    AssessmentCriterionStandard::updateOrCreate(
                        [
                            'assessment_criterion_id' => $assessmentCriterion->id,
                            'standard_id' => $standardId,
                        ],
                        [
                            'content' => '',
                            'assessed_point' => $standards[$standardId]['point'],
                        ]
                    );
                }
                unset($standards[$standardId]);
            } else {
                $assessmentCriterionStandard->delete();
            }
        }
        foreach ($standards as $standard) {
            AssessmentCriterionStandard::updateOrCreate(
                [
                    'assessment_criterion_id' => $assessmentCriterion->id,
                    'standard_id' => $standard['id'],
                ],
                [
                    'content' => '',
                    'assessed_point' => $standard['point'],
                ]
            );
        }
        return Redirect::back()->with('success', 'Tiêu chuẩn đã được thêm thành công.');
    }

    public function addListCriterion(Request $request, string $id)
    {
        $assessment = Assessment::with('program',
            'assessmentCriterionStandards')->findOrFail($id);
        $criteria = Criterion::all();
        $assessmentCriteria = AssessmentCriterion::where('assessment_id', $id)->get();
        return view('assessment.add-criterion',
            compact('assessment', 'criteria', 'assessmentCriteria'));
    }

    public function storeListCriterion(Request $request, string $id)
    {
        $assessment = Assessment::find($id);
        $criteriaIds = $request->input('criteria', []);

        $assessment->load('criteria');
        foreach ($criteriaIds as $criterionId) {
            $assessmentCriterion = AssessmentCriterion::where('old_assessment_id', $id)->
            where('criterion_id', $criterionId)->first();
            if ($assessmentCriterion) {
                $assessmentCriterion->update(['assessment_id' => $id, 'old_assessment_id' => null]);
            } else {
                $oldAssessmentCriterion = AssessmentCriterion::where('assessment_id', $id)->
                where('criterion_id', $criterionId)->first();
                if (!$oldAssessmentCriterion) {
                    AssessmentCriterion::create([
                        'criterion_id' => $criterionId,
                        'assessment_id' => $id
                    ]);
                }
            }
        }

        foreach ($assessment->criteria as $criterion) {
            if (!in_array($criterion->id, $criteriaIds)) {
                $assessmentCriterion = AssessmentCriterion::where('assessment_id', $id)->
                where('criterion_id', $criterion['id'])->first();
                $assessmentCriterion->update(['assessment_id' => null, 'old_assessment_id' => $id]);
            }
        }
        return redirect()->back()->with('success', 'Đánh giá đã được cập nhật thành công!');
    }

    public function downloadFileEvidence(Request $request, string $id)
    {
        $assessment = Assessment::with('program')->findOrFail($id);
        $assessmentCriteriaStandards = AssessmentCriterionStandard::whereHas('assessmentCriterion',
            function ($query) use ($id) {
                $query->where('assessment_id', $id);
            })->with('evidences.evidence')->get(); // Adjust eager loading as needed

        $folderName = Str::slug($assessment['program']['program_vi_title'] . '_' . $assessment['schoolyear']) . '_minh-chung';
        $fileZipName = $folderName . '.zip';
        $zipFilePath = public_path($fileZipName);

        $zip = new \ZipArchive();
        $zip->open($fileZipName, \ZipArchive::CREATE);

        foreach ($assessmentCriteriaStandards as $assessmentCriterionStandards) {
            foreach ($assessmentCriterionStandards->evidences as $item) {
                $evidence = $item['evidence'];
                if ($evidence->attachment) {
                    $filePath = Storage::path($evidence['attachment']);
                    if (file_exists($filePath)) {
                        $zipPath = $folderName . '/' . basename($filePath);
                        $zip->addFile($filePath, $zipPath);
                    }
                }
            }
        }
        if ($zip->numFiles == 0) {
            return back()->with('error', 'Không có minh chứng nào được tìm thấy.');
        }
        $zip->close();
        return response()->download($fileZipName, $fileZipName)
            ->deleteFileAfterSend();
    }

    public function generatePDF(Request $request, string $id)
    {
        $assessment = Assessment::with('program',
            'assessmentCriterionStandards')->find($id);

        $assessment = Assessment::with('program',
            'assessmentCriterionStandards')->find($id);

        $assessmentCriteria = AssessmentCriterion::where('assessment_id', $id)
            ->with('criterion')->get()
            ->sortBy('criterion.code');


        return view('assessment.view-pdf', compact('assessment', 'assessmentCriteria'));
    }

    public function clone(Request $request, Assessment $assessment)
    {

        $assessmentCriterionStandards = AssessmentCriterionStandard::whereHas('assessmentCriterion', function ($query) use ($assessment) {
            $query->where('assessment_id', $assessment['id']);
        })
            ->with('evidences.evidence')
            ->get();
        $expireEvidences = [];
        foreach ($assessmentCriterionStandards as $assessmentCriterionStandard) {
            foreach ($assessmentCriterionStandard['evidences'] as $assessmentEvidence) {
                $evidence = $assessmentEvidence['evidence'];
                if ($evidence['valid_to'] < Carbon::now()) {
                    $expireEvidences[] = $evidence;
                }
            }
        }
        if (count($expireEvidences) > 0) {
            $expireEvidences = array_unique($expireEvidences);
            return view('assessment.expire-evidence', compact('expireEvidences', 'assessment'));
        }
        return $this->cloneFromAssessment($request, $assessment);
    }

    public function cloneFromAssessment(Request $request, Assessment $assessment)
    {
        $expireEvidenceIDs = $request->input('expireEvidence');
        $duplicateAssessment = $assessment->replicate();
        $duplicateAssessment['schoolyear'] = $assessment['schoolyear'] + 1;
        $duplicateAssessment->save();

        $assessmentCriteria = AssessmentCriterion::where('assessment_id', $assessment['id'])
            ->with('assessmentCriterionStandards.standard',
                'assessmentCriterionStandards.evidences.evidence', 'criterion')->get();
        foreach ($assessmentCriteria as $assessmentCriterion) {

            $duplicateAssessmentCriteria = $assessmentCriterion->replicate();
            $duplicateAssessmentCriteria['assessment_id'] = $duplicateAssessment['id'];
            $duplicateAssessmentCriteria->save();
            foreach ($assessmentCriterion['assessmentCriterionStandards'] as $assessmentCriterionStandards) {
                $duplicateAssessmentCriterionStandards = $assessmentCriterionStandards->replicate();
                $duplicateAssessmentCriterionStandards['assessment_criterion_id'] = $duplicateAssessmentCriteria['id'];
                $duplicateAssessmentCriterionStandards->save();
                foreach ($assessmentCriterionStandards['evidences'] as $assessmentEvidence) {
                    $evidence = $assessmentEvidence['evidence'];
                    if ($evidence['valid_to'] == null ||
                        ($evidence['valid_to'] < Carbon::now() && in_array($evidence['id'] . '', $expireEvidenceIDs))) {
                        $duplicateAssessmentEvidence = $assessmentEvidence->replicate();
                        $duplicateAssessmentEvidence['assessment_criterion_standard_id'] = $duplicateAssessmentCriterionStandards['id'];
                        $duplicateAssessmentEvidence->save();
                    }

                }
            }
        }
        return redirect('assessments')->with('success', 'Tạo đánh giá thành công.');
    }
}
