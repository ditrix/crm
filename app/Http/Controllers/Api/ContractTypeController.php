<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContractType;
use Illuminate\Http\Request;
use App\Http\Resources\ContractTypeResource;
use App\Http\Requests\ContractTypeRequest;

class ContractTypeController extends Controller
{
/**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ContractTypeResource::collection(ContractType::get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContractTypeRequest $request)
    {
        $contract_type = ContractType::create($request->validated());

        return new ContractTypeResource($contract_type);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractType $contractType)
    {
        $contract_type = ContractType::where('id',$contractType->id)->first();

        return new ContractTypeResource($contract_type);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContractTypeRequest $request, ContractType $contractType)
    {
        $contractType->update($request->validated());

        return new ContractTypeResource($contractType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractType $contractType)
    {
        $contractType->delete();

        return response()->noContent();
    }
}
