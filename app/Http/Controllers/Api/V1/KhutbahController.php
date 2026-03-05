<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Khutbah;
use Illuminate\Http\Request;

class KhutbahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Khutbah::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $khutbah = Khutbah::findOrFail($id);
        return response()->json($khutbah);
    }
}
