<?php

namespace App\Http\Controllers;

use App\Models\CutoffType;
use Illuminate\Http\Request;

class CutoffTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $cutoff_types = CutoffType::all();

        if ($cutoff_types->isEmpty()) {
            return response()->json([
                'message' => 'No cutoffs found',
            ], 204);
        }

        return response()->json([
            'message' => 'Cutoffs found',
            'cutoff_types' => $cutoff_types,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $cutoff_type = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $ct = auto_create(CutoffType::class, $cutoff_type);
        $ct->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
