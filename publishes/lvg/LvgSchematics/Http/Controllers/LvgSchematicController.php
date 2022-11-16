<?php

namespace Lvg\LvgSchematics\Http\Controllers;

use Lvg\LvgSchematics\Models\Schematic;
use Lvg\LvgSchematics\Repositories\Schematics;
use Lvg\LvgSchematics\Http\Requests\Schematic\IndexRequest;
use Lvg\LvgSchematics\Http\Requests\Schematic\ViewRequest;
use Lvg\LvgSchematics\Http\Requests\Schematic\StoreRequest;
use Lvg\LvgSchematics\Http\Requests\Schematic\UpdateRequest;
use Lvg\LvgSchematics\Http\Requests\Schematic\DestroyRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;

class LvgSchematicController extends Controller
{
    public function __construct(private Schematics $repo)
    {
    }
    /**
     * Display a listing of the resource.
     * @param IndexRequest $request
     * @return Response
     */
    public function index(IndexRequest $request): Response
    {
        $model = Schematic::class;
        $can = [
            "viewAny" =>
                \Auth::check() && \Auth::user()->can("viewAny", $model),
            "create" => \Auth::check() && \Auth::user()->can("create", $model),
        ];
        return Inertia::render("LvgSchematics/Js/Pages/Index", compact("can"));
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $model = Schematic::class;
        $can = [
            "viewAny" =>
                \Auth::check() && \Auth::user()->can("viewAny", $model),
            "create" => \Auth::check() && \Auth::user()->can("create", $model),
        ];
        return Inertia::render("LvgSchematics/Js/Pages/Create", compact("can"));
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $payload = $this->repo->store($request->sanitizedObject());
            $success = "Record created successfully";
            return back()->with(compact("success", "payload"));
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->withErrors(["error" => $exception->getMessage()]);
        }
    }

    /**
     * Show the specified resource.
     * @param ViewRequest $request
     * @param Schematic $schematic
     * @return Response
     */
    public function show(ViewRequest $request, Schematic $schematic): Response
    {
        $model = $this->repo->setModel($schematic)->show();
        return Inertia::render("LvgSchematics/Js/Pages/Show", compact("model"));
    }

    /**
     * Edit the specified resource.
     * @param Request $request
     * @param Schematic $schematic
     * @return Response
     */
    public function edit(Request $request, Schematic $schematic): Response
    {
        $model = $this->repo->setModel($schematic)->show();
        return Inertia::render("LvgSchematics/Js/Pages/Edit", compact("model"));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Schematic $schematic
     * @return RedirectResponse
     */
    public function update(
        UpdateRequest $request,
        Schematic $schematic
    ): RedirectResponse {
        try {
            $payload = $this->repo
                ->setModel($schematic)
                ->update($request->sanitizedObject());
            $success = "Record updated successfully";
            return back()->with(compact("success", "payload"));
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->withErrors(["error" => $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param DestroyRequest $request
     * @param Schematic $schematic
     * @return RedirectResponse
     */
    public function destroy(
        DestroyRequest $request,
        Schematic $schematic
    ): RedirectResponse {
        try {
            $res = $this->repo->setModel($schematic)->destroy();
            $success = "Record deleted successfully";
            return back()->with(compact("success"));
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->withErrors(["error" => $exception->getMessage()]);
        }
    }
}
