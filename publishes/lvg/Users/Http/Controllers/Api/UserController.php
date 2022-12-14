<?php

namespace Lvg\Users\Http\Controllers\Api;

use Lvg\Users\Models\User;
use Lvg\Users\Repositories\Users;
use Lvg\Users\Http\Requests\User\IndexRequest;
use Lvg\Users\Http\Requests\User\DtRequest;
use Lvg\Users\Http\Requests\User\ViewRequest;
use Lvg\Users\Http\Requests\User\StoreRequest;
use Lvg\Users\Http\Requests\User\UpdateRequest;
use Lvg\Users\Http\Requests\User\DestroyRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Log;
use Tekrow\Lvg\Helpers\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Throwable;

class UserController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct(private ApiResponse $api, private Users $repo)
    {
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
                ->message("List of Users")
                ->payload($data)
                ->send();
        } catch (Throwable $e) {
            Log::error($e);
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
        } catch (Throwable $e) {
            Log::error($e);
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
        } catch (Throwable $e) {
            Log::error($e);
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
     * @param User $user
     * @return JsonResponse
     */
    public function show(ViewRequest $request, User $user): JsonResponse
    {
        try {
            $payload = $this->repo->setModel($user)->show();
            $success = "Single record fetched";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (Throwable $e) {
            Log::error($e);
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
     * @param User $user
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, User $user): JsonResponse
    {
        try {
            $payload = $this->repo
                ->setModel($user)
                ->update($request->sanitizedObject());
            $success = "Record updated successfully";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (Throwable $e) {
            Log::error($e);
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
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(DestroyRequest $request, User $user): JsonResponse
    {
        try {
            $payload = $this->repo->setModel($user)->destroy();
            $success = "Record deleted successfully";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (Throwable $e) {
            Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * @throws AuthorizationException
     */
    public function toggleRole(Request $request, User $user): JsonResponse
    {
        $this->authorize('update',$user);
        $validated = $request->validate([
            'role_id' => ['required','integer'],
            'assigned' => ['required','boolean'],
        ]);
        try {
            $payload = $this->repo
                ->setModel($user)
                ->toggleRole((object) $validated);
            $success = "Record updated successfully";
            return $this->api
                ->success()
                ->message($success)
                ->send();
        } catch (Throwable $e) {
            Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }
}
