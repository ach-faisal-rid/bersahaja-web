<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Doa;
use Illuminate\Http\Request;

class DoaController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get all doas with pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $search = $request->query('search');

        $query = Doa::query();

        if ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('arab', 'like', "%$search%")
                  ->orWhere('translation', 'like', "%$search%");
        }

        $doas = $query->paginate($perPage);

        return $this->paginatedResponse($doas, 'Doas retrieved successfully');
    }

    /**
     * Get single doa
     */
    public function show($id)
    {
        $doa = Doa::find($id);

        if (!$doa) {
            return $this->notFoundResponse('Doa not found');
        }

        return $this->response($doa, 'Doa retrieved successfully');
    }

    /**
     * Get doas by tag
     */
    public function byTag($tagId, Request $request)
    {
        $perPage = $request->query('per_page', 15);

        $doas = Doa::whereHas('tags', function ($query) use ($tagId) {
            $query->where('id', $tagId);
        })->paginate($perPage);

        return $this->paginatedResponse($doas, 'Doas by tag retrieved successfully');
    }
}
