<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\DoaSetelahSholat;
use Illuminate\Http\Request;

class DoaSetelahSholatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(DoaSetelahSholat::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doa = DoaSetelahSholat::findOrFail($id);
        return response()->json($doa);
    }
}
