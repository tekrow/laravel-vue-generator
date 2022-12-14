<?php

namespace Lvg\LvgSchematics\Http\Controllers\Api;

use Lvg\LvgSchematics\Models\Schematic;
use Lvg\LvgSchematics\Repositories\Schematics;
use Lvg\LvgSchematics\Http\Requests\Schematic\IndexRequest;
use Lvg\LvgSchematics\Http\Requests\Schematic\DtRequest;
use Lvg\LvgSchematics\Http\Requests\Schematic\ViewRequest;
use Lvg\LvgSchematics\Http\Requests\Schematic\StoreRequest;
use Lvg\LvgSchematics\Http\Requests\Schematic\UpdateRequest;
use Lvg\LvgSchematics\Http\Requests\Schematic\DestroyRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Tekrow\Lvg\Helpers\ApiResponse;

class LvgSchematicController extends Controller
{
    public function __construct(
        private ApiResponse $api,
        private Schematics $repo
    ) {
    }
    /**
     * Display a listing of the resource.
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        try {
            $data = $this->repo->index();
            return $this->api
                ->success()
                ->message("List of LvgSchematics")
                ->payload($data)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * @param DtRequest $request
     * @return LengthAwarePaginator|JsonResponse
     */
    public function dt(DtRequest $request): LengthAwarePaginator|JsonResponse
    {
        try {
            return $this->repo->dt();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $payload = $this->repo->store($request->sanitizedObject());
            $success = "Record created successfully";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Show the specified resource.
     * @param ViewRequest $request
     * @param Schematic $schematic
     * @return JsonResponse
     */
    public function show(
        ViewRequest $request,
        Schematic $schematic
    ): JsonResponse {
        try {
            $payload = $this->repo->setModel($schematic)->show();
            $success = "Single record fetched";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Schematic $schematic
     * @return JsonResponse
     */
    public function update(
        UpdateRequest $request,
        Schematic $schematic
    ): JsonResponse {
        try {
            $payload = $this->repo
                ->setModel($schematic)
                ->update($request->sanitizedObject());
            $success = "Record updated successfully";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param DestroyRequest $request
     * @param Schematic $schematic
     * @return JsonResponse
     */
    public function destroy(
        DestroyRequest $request,
        Schematic $schematic
    ): JsonResponse {
        try {
            $payload = $this->repo->setModel($schematic)->destroy();
            $success = "Record deleted successfully";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }
}
