<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BloodSugar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BloodSugarController extends Controller
{
    // I(mp) list current user's blood sugar records, paginated
    public function index(Request $request): JsonResponse
    {
        $records = $request->user()->bloodSugars()
            ->orderByDesc('recorded_at')
            ->paginate(15);

        return response()->json($records);
    }

    // I(mp) store new record; recorded_at defaults to now() if not provided
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'value'       => ['required', 'numeric', 'min:0.1', 'max:100'],
            'recorded_at' => ['nullable', 'date'],
            'notes'       => ['nullable', 'string', 'max:1000'],
        ]);

        $data['recorded_at'] ??= now();

        $record = $request->user()->bloodSugars()->create($data);

        return response()->json($record, 201);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $record = $request->user()->bloodSugars()->findOrFail($id);

        return response()->json($record);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $record = $request->user()->bloodSugars()->findOrFail($id);

        $data = $request->validate([
            'value'       => ['sometimes', 'numeric', 'min:0.1', 'max:100'],
            'recorded_at' => ['sometimes', 'date'],
            'notes'       => ['nullable', 'string', 'max:1000'],
        ]);

        $record->update($data);

        return response()->json($record);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $record = $request->user()->bloodSugars()->findOrFail($id);
        $record->delete();

        // O(pt) 204 No Content is the correct REST response for DELETE
        return response()->json(null, 204);
    }
}
