<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\GerakanShalat;
use Illuminate\Http\Request;

class GerakanShalatController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get all gerakan shalat with pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);

        $gerakan = GerakanShalat::paginate($perPage);

        return $this->paginatedResponse($gerakan, 'Gerakan Shalat retrieved successfully');
    }

    /**
     * Get single gerakan shalat
     */
    public function show($id)
    {
        $gerakan = GerakanShalat::find($id);

        if (!$gerakan) {
            return $this->notFoundResponse('Gerakan Shalat not found');
        }

        return $this->response($gerakan, 'Gerakan Shalat retrieved successfully');
    }
}
