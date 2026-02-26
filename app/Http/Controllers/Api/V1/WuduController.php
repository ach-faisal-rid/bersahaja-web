<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Wudu;
use Illuminate\Http\Request;

class WuduController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get all wudu with pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);

        $wudu = Wudu::paginate($perPage);

        return $this->paginatedResponse($wudu, 'Wudu retrieved successfully');
    }

    /**
     * Get single wudu
     */
    public function show($id)
    {
        $wudu = Wudu::find($id);

        if (!$wudu) {
            return $this->notFoundResponse('Wudu not found');
        }

        return $this->response($wudu, 'Wudu retrieved successfully');
    }
}
