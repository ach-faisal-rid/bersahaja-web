<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Bacaan;
use Illuminate\Http\Request;

class BacaanController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get all bacaan with pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $search = $request->query('search');

        $query = Bacaan::query();

        if ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('arabic', 'like', "%$search%")
                  ->orWhere('translation', 'like', "%$search%");
        }

        $bacaan = $query->paginate($perPage);

        return $this->paginatedResponse($bacaan, 'Bacaan retrieved successfully');
    }

    /**
     * Get single bacaan
     */
    public function show($id)
    {
        $bacaan = Bacaan::find($id);

        if (!$bacaan) {
            return $this->notFoundResponse('Bacaan not found');
        }

        return $this->response($bacaan, 'Bacaan retrieved successfully');
    }
}
