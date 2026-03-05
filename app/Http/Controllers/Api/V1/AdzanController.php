<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Adzan;
use Illuminate\Http\Request;

class AdzanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Adzan::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $waktu)
    {
        $adzan = Adzan::where('waktu', $waktu)->firstOrFail();
        return response()->json($adzan);
    }
}
