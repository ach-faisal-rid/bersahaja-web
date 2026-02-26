<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Hadist;
use Illuminate\Http\Request;

class HadistController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get all hadists with pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $search = $request->query('search');

        $query = Hadist::query();

        if ($search) {
            $query->where('title', 'like', "%$search%")
                  ->orWhere('content', 'like', "%$search%")
                  ->orWhere('translation', 'like', "%$search%");
        }

        $hadists = $query->paginate($perPage);

        return $this->paginatedResponse($hadists, 'Hadists retrieved successfully');
    }

    /**
     * Get single hadist
     */
    public function show($id)
    {
        $hadist = Hadist::with('source')->find($id);

        if (!$hadist) {
            return $this->notFoundResponse('Hadist not found');
        }

        return $this->response($hadist, 'Hadist retrieved successfully');
    }
}
