<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Iqamat;
use Illuminate\Http\Request;

class IqamatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Iqamat::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $waktu)
    {
        $iqamat = Iqamat::where('waktu', $waktu)->firstOrFail();
        return response()->json($iqamat);
    }
}
