<?php

namespace Lvg\LvgFields\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use App\Models\User as AuthUser;
use Lvg\LvgFields\Models\Field;
class FieldPolicy
{
    use HandlesAuthorization;
    private string $basePerm = "lvg-fields";
    /**
     * Determine whether the user can view any models.
     *
     * @param  AuthUser $user
     * @return Response|bool
     */
    public function viewAny(AuthUser $user): Response|bool
    {
        return $user->hasPermissionTo("$this->basePerm.view-any");
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  AuthUser  $user
     * @param  Field  $model
     * @return Response|bool
     */
    public function view(AuthUser $user, Field $model): Response|bool
    {
        return $user->hasPermissionTo("$this->basePerm.view");
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  AuthUser  $user
     * @return Response|bool
     */
    public function create(AuthUser $user): Response|bool
    {
        return $user->hasPermissionTo("$this->basePerm.create");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  AuthUser  $user
     * @param  Field $model
     * @return Response|bool
     */
    public function update(AuthUser $user, Field $model): Response|bool
    {
        return $user->hasPermissionTo("$this->basePerm.update");
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  AuthUser  $user
     * @param  Field $model
     * @return Response|bool
     */
    public function delete(AuthUser $user, Field $model): Response|bool
    {
        return $user->hasPermissionTo("$this->basePerm.delete");
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  AuthUser  $user
     * @param  Field $model
     * @return Response|bool
     */
    public function restore(AuthUser $user, Field $model): Response|bool
    {
        return $user->hasPermissionTo("$this->basePerm.restore");
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  AuthUser  $user
     * @param  Field $model
     * @return Response|bool
     */
    public function forceDelete(AuthUser $user, Field $model): Response|bool
    {
        return $user->hasPermissionTo("$this->basePerm.force-delete");
    }
}
