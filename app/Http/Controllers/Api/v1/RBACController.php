<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\RBAC\Permission;
use App\Models\RBAC\Role;

use App\Models\GEWIS\Organ;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RBACController extends Controller
{
    public function getRoles($owner_id)
    {
        $organ = Organ::find($owner_id);
        if (!$organ) {
            $this->response(404, "Owner not found");
        }

        $roles = Role::where('organ_id', $owner_id)->get();
        if ($roles->isEmpty()) {
            return $roles;
        }
        $this->authorize('view', $roles->first());
        return $roles;
    }

    public function getRole($id)
    {
        $role = Role::find($id);
        if ($role) {
            $this->authorize('view', $role);
            return $role;
        } else {
            return $this->response(404, "Role not found");
        }
    }

    public function createRole(Request $request)
    {
        $owner = Organ::find($request->owner_id);

        if (!$owner) {
            return $this->response(404, 'Owner not found');
        }

        $this->authorize('create', [Role::class,$owner->id]);

        $role = Role::create($request->all());
        if ($role->isValid()) {
            return response()->json($role->id, 201);
        } else {
            return $this->response(400, "Role invalid", $role->getErrors());
        }
    }

    public function updateRole(Request $request, $id)
    {
        $role = Role::find($id);

        if ($role) {
            $this->authorize('update', $role);
            $role->update($request->all());
            if ($role->isValid()) {
                return response()->json("Role succesfully updated", 200);
            } else {
                return $this->response(400, "Product invalid", $role->getErrors());
            }
        } else {
            return $this->response(404, "Role not found");
        }
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);
        if ($role) {
            $this->authorize('delete', $role);
            $role->delete();
            return response()->json("Role succesfully deleted", 200);
        } else {
            return $this->response(404, "Role not found");
        }
    }

    public function reinstateRole($id)
    {
        if (Role::find($id)) {
            return $this->response(409, "Role already active.");
        }
        $role = Role::withTrashed()->find($id);
        if ($role) {
            $this->authorize('update', $role);
            $role->restore();
            return response()->json("Role succesfully reinstated", 200);
        } else {
            return $this->response(404, "Role not found");
        }
    }

    public function addRoleToUser($role_id, $user_id)
    {
        $role = Role::find($role_id);
        // Only internal GEWIS members are allowed to have commitee permissions.
        $user = User::find($user_id)->where('type', User::TYPE_GEWIS);

        if (!$role) {
            return  $this->response(404, 'Role not found');
        }
        if (!$user) {
            return $this->response(404, 'User not found or is not a GEWIS member');
        }
        $this->authorize('update', $role);
        if($role->users->contains($user_id)){
            return $this->response(409, 'Role already added to the user');
        }

        $role->users()->attach($user);
        return response()->json("Role successfully added to the user", 201);
    }

    public function removeRoleFromUser($role_id, $user_id)
    {
        $role = Role::find($role_id);
        if (!$role) {
            return $this->response(404, "Role not found");
        }

        $this->authorize('update', $role);

       if(!$role->users->contains($user_id)) {
            return $this->response(404, "User does not contain this role");
        } else {
            $role->users()->detach($user_id);
            return response()->json("Role succesfully removed from the user", 200);
        }
    }

    public function getPermissionFromRoles($role_id)
    {
        $role = Role::find($role_id);

        if (!$role) {
            return $this->response(404, 'Role not found');
        }
        $this->authorize('view', $role);

        return $role->permissions;
    }


    /*
     * Permission part
     */

    public function addPermissionToRole($permission_id, $role_id)
    {
        $permission = Permission::find($permission_id);
        $role = Role::find($role_id);

        if (!$permission) {
            return $this->response(404, 'Permission not found');
        }

        if (!$role) {
           return $this->response(404, 'Role not found');
        }

        $this->authorize('create', [Role::class,$role->owner->id]);

        if ($role->permissions->contains($permission_id)) {
           return $this->response(409, 'Permission already added to role');
        }
        $role->permissions()->attach($permission_id);
        return response()->json("Permission successfully added to the role.", 201);
    }

    public function removePermissionFromRole($permission_id, $role_id)
    {
        $permission = Permission::find($permission_id);
        $role = Role::find($role_id);

        if (!$permission) {
            return $this->response(404, "Permission not found");
        }
        if (!$role) {
            return $this->response(404, 'Role not found');
        }

        $this->authorize('delete', $role);

        if (!$permission->roles->contains($role_id)) {
            return $this->response(404, "Permission is not added to the role");
        } else {
            $permission->roles()->detach($role_id);
            return response()->json("Permission removed from the role", 200);
        }
    }

    public function getPermissions()
    {
        return Permission::all();
    }
}
