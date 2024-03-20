<?php

namespace App\Policies;

use App\Models\Server;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use function Symfony\Component\Translation\t;

class ServerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Server $server): bool
    {
        if($user?->admin){
            return true;
        }
        if($server->isSuspended()){
            return false;
        }
        if($server->private && !$user?->servers->contains($server)){
            return false;
        }
        if($user?->id==$server->owner_id||$user?->servers->contains($server)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Server $server): bool
    {
        if($user->admin){
            return true;
        }
        if($user->isSuspended()){
            return false;
        }
        if($user->id==$server->owner_id){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Server $server): bool
    {
        if($user->admin){
            return true;
        }
        if($user->isSuspended()){
            return false;
        }
        if($user->id==$server->owner_id){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Server $server): bool
    {
       return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Server $server): bool
    {
       if($user->admin){
           return true;
       }
       if($user->isSuspended()){
           return false;
       }
       if($user->id==$server->owner_id){
           return true;
       }
       return false;
    }
}
