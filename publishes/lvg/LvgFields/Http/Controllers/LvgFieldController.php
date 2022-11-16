<?php

namespace Lvg\LvgFields\Http\Controllers;

use Lvg\LvgFields\Models\Field;
use Lvg\LvgFields\Repositories\Fields;
use Lvg\LvgFields\Http\Requests\Field\IndexRequest;
use Lvg\LvgFields\Http\Requests\Field\ViewRequest;
use Lvg\LvgFields\Http\Requests\Field\StoreRequest;
use Lvg\LvgFields\Http\Requests\Field\UpdateRequest;
use Lvg\LvgFields\Http\Requests\Field\DestroyRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;

class LvgFieldController extends Controller
{
    public function __construct(private Fields $repo)
    {
    }
    /**
     * Display a listing of the resource.
     * @param IndexRequest $request
     * @return Response
     */
    public function index(IndexRequest $request): Response
    {
        $model = Field::class;
        $can = [
            "viewAny" =>
                \Auth::check() && \Auth::user()->can("viewAny", $model),
            "create" => \Auth::check() && \Auth::user()->can("create", $model),
        ];
        return Inertia::render("LvgFields/Js/Pages/Index", compact("can"));
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $model = Field::class;
        $can = [
            "viewAny" =>
                \Auth::check() && \Auth::user()->can("viewAny", $model),
            "create" => \Auth::check() && \Auth::user()->can("create", $model),
        ];
        return Inertia::render("LvgFields/Js/Pages/Create", compact("can"));
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
     * @param Field $field
     * @return Response
     */
    public function show(ViewRequest $request, Field $field): Response
    {
        $model = $this->repo->setModel($field)->show();
        return Inertia::render("LvgFields/Js/Pages/Show", compact("model"));
    }

    /**
     * Edit the specified resource.
     * @param Request $request
     * @param Field $field
     * @return Response
     */
    public function edit(Request $request, Field $field): Response
    {
        $model = $this->repo->setModel($field)->show();
        return Inertia::render("LvgFields/Js/Pages/Edit", compact("model"));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Field $field
     * @return RedirectResponse
     */
    public function update(
        UpdateRequest $request,
        Field $field
    ): RedirectResponse {
        try {
            $payload = $this->repo
                ->setModel($field)
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
     * @param Field $field
     * @return RedirectResponse
     */
    public function destroy(
        DestroyRequest $request,
        Field $field
    ): RedirectResponse {
        try {
            $res = $this->repo->setModel($field)->destroy();
            $success = "Record deleted successfully";
            return back()->with(compact("success"));
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->withErrors(["error" => $exception->getMessage()]);
        }
    }
}
