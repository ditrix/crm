<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contract\ContractStatus;
use Illuminate\Http\Request;
use App\Http\Requests\ContractStatusRequest;
use App\Http\Resources\ContractStatusResource;

class ContractStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ContractStatusResource::collection(ContractStatus::get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContractStatusRequest $request)
    {
        $contract_status = ContractStatus::create($request->validated());

        return new ContractStatusResource($contract_status);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractStatus $contract_status)
    {
        $contract_status = ContractStatus::where('id',$contract_status->id)->first();

        return new ContractStatusResource($contract_status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContractStatusRequest $request, ContractStatus $contractStatus)
    {
        $contractStatus->update($request->validated());

        return new ContractStatusResource($contractStatus);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractStatus $contractStatus)
    {
        $contractStatus->delete();

        return response()->noContent();
    }
}
