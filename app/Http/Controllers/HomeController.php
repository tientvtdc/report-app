<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userName = $request->input('q');

        $activities = Activity::with('causer')
            ->whereHas('causer', function ($query) use ($userName) {
                $query->where('name', 'like', '%' . $userName . '%');
            })
            ->latest()
            ->paginate(20);

        return view('welcome', compact('activities'));
    }
    public function loadMore(Request $request)
    {
        $userName = $request->input('q');
        $activities = Activity::with('causer')
            ->whereHas('causer', function ($query) use ($userName) {
                $query->where('name', 'like', '%' . $userName . '%');
            })
            ->latest()
            ->paginate(20);

        return response()->json($activities);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */


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
