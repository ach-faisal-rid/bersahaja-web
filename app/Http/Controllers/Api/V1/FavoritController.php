<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Favorit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoritController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get user favorits
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $type = $request->query('type'); // doa, hadist, bacaan, etc

        $query = Favorit::where('user_id', $request->user()->id);

        if ($type) {
            $query->where('favoritable_type', "App\\Models\\" . ucfirst($type));
        }

        $favorits = $query->with('favoritable')->paginate($perPage);

        return $this->paginatedResponse($favorits, 'Favorits retrieved successfully');
    }

    /**
     * Add to favorits
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:doa,hadist,bacaan,wudu,gerakan_shalat,tata_cara',
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        try {
            $type = $request->type;
            $modelClass = 'App\\Models\\' . match($type) {
                'doa' => 'Doa',
                'hadist' => 'Hadist',
                'bacaan' => 'Bacaan',
                'wudu' => 'Wudu',
                'gerakan_shalat' => 'GerakanShalat',
                'tata_cara' => 'TataCara',
                default => throw new \Exception('Invalid type'),
            };

            // Check if already favorited
            $exists = Favorit::where('user_id', $request->user()->id)
                ->where('favoritable_type', $modelClass)
                ->where('favoritable_id', $request->id)
                ->exists();

            if ($exists) {
                return $this->errorResponse('Already added to favorits', 400);
            }

            Favorit::create([
                'user_id' => $request->user()->id,
                'favoritable_type' => $modelClass,
                'favoritable_id' => $request->id,
            ]);

            return $this->response(null, 'Added to favorits successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to add favorit: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Remove from favorits
     */
    public function destroy($id, Request $request)
    {
        $favorit = Favorit::find($id);

        if (!$favorit || $favorit->user_id !== $request->user()->id) {
            return $this->notFoundResponse('Favorit not found');
        }

        $favorit->delete();

        return $this->response(null, 'Removed from favorits successfully');
    }
}
