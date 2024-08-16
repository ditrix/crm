<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Resources\PermissionResource;
use App\Http\Requests\PermissionRequest;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PermissionResource::collection(Permission::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        return new PermissionResource(Permission::where('id',$permission->id)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());

        return new PermissionResource($permission);
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(PermissionRequest $request)
    {

        $permission = Permission::create($request->validated());

        return new PermissionResource($permission);
    }


}
