<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\TataCara;
use Illuminate\Http\Request;

class TataCaraController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get all tata cara with pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);

        $tataCara = TataCara::paginate($perPage);

        return $this->paginatedResponse($tataCara, 'Tata Cara retrieved successfully');
    }

    /**
     * Get single tata cara
     */
    public function show($id)
    {
        $tataCara = TataCara::find($id);

        if (!$tataCara) {
            return $this->notFoundResponse('Tata Cara not found');
        }

        return $this->response($tataCara, 'Tata Cara retrieved successfully');
    }
}
