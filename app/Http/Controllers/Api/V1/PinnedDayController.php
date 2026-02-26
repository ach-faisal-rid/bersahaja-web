<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\PinnedDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PinnedDayController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get user pinned days
     */
    public function index(Request $request)
    {
        $pinnedDays = PinnedDay::where('user_id', $request->user()->id)->get();

        return $this->response($pinnedDays, 'Pinned days retrieved successfully');
    }

    /**
     * Add pinned day
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hijri_date' => 'required|date_format:Y-m-d',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        try {
            $pinnedDay = PinnedDay::create([
                'user_id' => $request->user()->id,
                'hijri_date' => $request->hijri_date,
                'title' => $request->title,
                'description' => $request->description,
            ]);

            return $this->response($pinnedDay, 'Pinned day added successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to add pinned day', 500);
        }
    }

    /**
     * Delete pinned day
     */
    public function destroy($id, Request $request)
    {
        $pinnedDay = PinnedDay::find($id);

        if (!$pinnedDay || $pinnedDay->user_id !== $request->user()->id) {
            return $this->notFoundResponse('Pinned day not found');
        }

        $pinnedDay->delete();

        return $this->response(null, 'Pinned day deleted successfully');
    }
}
