<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhaseRequest;
use App\Http\Requests\UpdatePhaseRequest;
use App\Models\Phase;
use Exception;
use Illuminate\Http\JsonResponse;

class PhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhaseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Phase $phase)
    {
        return $phase->load('tasks.user')->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Phase $phase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhaseRequest $request, Phase $phase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Phase $phase)
    {
        try {
            $phase->delete();
            return new JsonResponse([
                "code" => 200,
                "status" => "success",
                "message" => "Phase delete successfully.!"
            ]);
        }catch (Exception $exception){
            return new JsonResponse([
                "code" => $exception->getCode(),
                "status" => "fail",
                "message" => $exception->getMessage(),
            ], $exception->getCode());
        }

    }
}
