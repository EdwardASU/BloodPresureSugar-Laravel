<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BloodPressureController extends Controller
{
    // I(mp) list current user's blood pressure records, paginated
    public function index(Request $request): JsonResponse
    {
        $records = $request->user()->bloodPressures()
            ->orderByDesc('recorded_at')
            ->paginate(15);

        return response()->json($records);
    }

    // I(mp) store new record; recorded_at defaults to now() if not provided
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'systolic'    => ['required', 'integer', 'min:50', 'max:300'],
            'diastolic'   => ['required', 'integer', 'min:30', 'max:200'],
            'pulse'       => ['nullable', 'integer', 'min:20', 'max:300'],
            'recorded_at' => ['nullable', 'date'],
            'notes'       => ['nullable', 'string', 'max:1000'],
        ]);

        $data['recorded_at'] ??= now();

        $record = $request->user()->bloodPressures()->create($data);

        return response()->json($record, 201);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $record = $request->user()->bloodPressures()->findOrFail($id);

        return response()->json($record);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $record = $request->user()->bloodPressures()->findOrFail($id);

        $data = $request->validate([
            'systolic'    => ['sometimes', 'integer', 'min:50', 'max:300'],
            'diastolic'   => ['sometimes', 'integer', 'min:30', 'max:200'],
            'pulse'       => ['nullable', 'integer', 'min:20', 'max:300'],
            'recorded_at' => ['sometimes', 'date'],
            'notes'       => ['nullable', 'string', 'max:1000'],
        ]);

        $record->update($data);

        return response()->json($record);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $record = $request->user()->bloodPressures()->findOrFail($id);
        $record->delete();

        // O(pt) 204 No Content is the correct REST response for DELETE
        return response()->json(null, 204);
    }
}
