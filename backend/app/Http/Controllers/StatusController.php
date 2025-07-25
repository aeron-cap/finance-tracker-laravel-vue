<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $status = Status::all();

        if ($status->isEmpty()) {
            return response()->json([
                'message' => 'No status found',
            ], 204);
        }

        return response()->json([
            'message' => 'Status found',
            'status' => $status,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $status = $request->validate([
            'name' => 'required',
        ]);

        $s = auto_create(Status::class, $status);
        $s->save();
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
