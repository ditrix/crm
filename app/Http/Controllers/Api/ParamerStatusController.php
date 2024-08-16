<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParameterStatus;
use Illuminate\Http\Request;
use App\Http\Requests\ParameterStatusRequest;
use App\Http\Resources\ParameterStatusResource;

class ParamerStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ParameterStatusResource::collection(ParameterStatus::get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ParameterStatusRequest $request)
    {
        $parameter_status = ParameterStatus::create($request->validated());

        return new ParameterStatusResource($parameter_status);
    }

    /**
     * Display the specified resource.
     */
    public function show(ParameterStatus $parameterStatus)
    {
        $parameter_status = ParameterStatus::where('id',$parameterStatus->id)->first();

        return new ParameterStatusResource($parameter_status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ParameterStatusRequest $request, ParameterStatus $parameterStatus)
    {
        $parameterStatus->update($request->validated());

        return new ParameterStatusResource($parameterStatus);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParameterStatus $parameterStatus)
    {
        $parameterStatus->delete();

        return response()->noContent();
    }
}
