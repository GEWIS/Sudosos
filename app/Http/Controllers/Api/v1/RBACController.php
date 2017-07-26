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
    /**
     * @SWG\Get(
     *     path ="/roles/owner/{owner_id}",
     *     summary = "Returns all roles that belong to an organ.",
     *     tags = {"Role"},
     *     description = "Returns all roles that belogn to an organ.",
     *     operationId = "getAllRoles",
     *     produces = {"application/json"},
     *      @SWG\Parameter(
     *         name="owner_id",
     *         in="path",
     *         description="Id of the owner",
     *         required=true,
     *         type="integer",
     *         ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *      @SWG\Response(
     *         response=404,
     *         description="Owner not found",
     *     ),
     * ),
     */
    public function getRoles($owner_id)
    {
        $organ = Organ::find($owner_id);
        if (!$organ) {
            $this->response(404, "Owner not found");
        }

        $roles = Role::where('owner_id', $owner_id)->get();
        if ($roles->isEmpty()) {
            return $roles;
        }
        $this->authorize('view', $roles->first());
        return $roles;
    }

    /**
     * @SWG\Get(
     *     path ="/roles/{id}",
     *     summary = "Returns the role by id.",
     *     tags = {"Role"},
     *     description = "Returns a role with a specified id.",
     *     operationId = "getRole",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the product",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Role not found",
     *     ),
     * ),
     */
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

    /**
     * @SWG\Post(
     *     path ="/roles",
     *     summary = "Create a new role.",
     *     tags = {"Role"},
     *     description = "Create a new role.",
     *     operationId = "createRole",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="Role",
     *         in="body",
     *         required=true,
     *         description="Model of the Role to store",
     *        @SWG\Schema(ref="#/definitions/role"),
     *         ),
     *     @SWG\Response(
     *         response=201,
     *         description="Role created succesfully",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Role invalid.",
     *     ),
     *    @SWG\Response(
     *         response=404,
     *         description="Owner not found",
     *     ),
     * ),
     */
    public function createRole(Request $request)
    {
        $owner = Organ::find($request->owner_id);
//        dd($owner->id);
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

    /**
     * @SWG\Put(
     *     path ="/roles/{id}",
     *     summary = "Updates a role by id.",
     *     tags = {"Role"},
     *     description = "Updates the role.",
     *     operationId = "updateRole",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="Role",
     *         in="body",
     *         required=true,
     *         description="Model of the role to store",
     *        @SWG\Schema(ref="#/definitions/inputRole"),
     *         ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the role",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Role succesfully updated",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Role not valid",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Role not found",
     *     ),
     * ),
     */
    public function updateRole(Request $request, $id)
    {
        $role = Role::find($id);

        if ($role) {
            $this->authorize('update', $role);
            $role->update($request->all());
            if ($role->isValid()) {
                return response()->json("Role succesfully updated", 200);
            } else {
                return $this->response(400, "Role invalid", $role->getErrors());
            }
        } else {
            return $this->response(404, "Role not found");
        }
    }

    /**
     * @SWG\Delete(
     *     path="/roles/{id}",
     *     summary="Delete a role by id.",
     *     description="Delete a role by id.",
     *     operationId="deleteRole",
     *     produces={"application/json"},
     *     tags={"Role"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the role",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Role succesfully deleted."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Role not found."
     *     ),
     * )
     */
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

    /**
     * @SWG\Put(
     *     path ="/roles/{id}/reinstate",
     *     summary = "Reinstate a role by id.",
     *     tags = {"Role"},
     *     description = "Reinstate a role by id.",
     *     operationId = "reinstateRole",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the role",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Role succesfully reinstated",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Role not found",
     *     ),
     *     @SWG\Response(
     *         response=409,
     *         description="Role already active",
     *     ),
     * ),
     */
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

    /**
     * @SWG\Post(
     *     path ="/roles/{role_id}/assign/{user_id}",
     *     summary = "Adds an user to a role.",
     *     tags = {"Role"},
     *     description = "Adds an user to a role.",
     *     operationId = "addUserToRole",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="role_id",
     *         in="path",
     *         description="Id of the role",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="Id of the user",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Role successfully added to the user",
     *     ),
     *    @SWG\Response(
     *         response=404,
     *         description="Role / user not found",
     *     ),
     *    @SWG\Response(
     *         response=409,
     *         description="User already added to the role",
     *     ),
     * ),
     */
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

    /**
     * @SWG\Delete(
     *     path ="/roles/{role_id}/remove/{user_id}",
     *     summary = "Removes an user from a role.",
     *     tags = {"Role"},
     *     description = "Removes an user from a role.",
     *     operationId = "removeUserFromRole",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="role_id",
     *         in="path",
     *         description="Id of the role",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="Id of the user",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Role succesfully removed from the user",
     *     ),
     *    @SWG\Response(
     *         response=404,
     *         description="Role / user not found",
     *     ),
     *    @SWG\Response(
     *         response=409,
     *         description="User does not have this role",
     *     ),
     * ),
     */
    public function removeRoleFromUser($role_id, $user_id)
    {
        $role = Role::find($role_id);
        if (!$role) {
            return $this->response(404, "Role not found");
        }

        $this->authorize('update', $role);

       if(!$role->users->contains($user_id)) {
            return $this->response(409, "User does not contain this role");
        } else {
            $role->users()->detach($user_id);
            return response()->json("Role succesfully removed from the user", 200);
        }
    }


    /**
     * @SWG\Get(
     *     path ="/roles/{id}/permissions",
     *     summary = "Returns all permissions by role id.",
     *     tags = {"Role"},
     *     description = "Returns all permissions by role id.",
     *     operationId = "getPermissionsByRole",
     *     produces = {"application/json"},
     *      @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the role",
     *         required=true,
     *         type="string",
     *         ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *      @SWG\Response(
     *         response=404,
     *         description="Owner not found",
     *     ),
     * ),
     */
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
    /**
     * @SWG\Get(
     *     path ="/permissions",
     *     summary = "Returns all permissions.",
     *     tags = {"Permission"},
     *     description = "Returns all permissions.",
     *     operationId = "getPermissions",
     *     produces = {"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     * ),
     */
    public function getPermissions()
    {
        return Permission::all();
    }
    
    /**
     * @SWG\Post(
     *     path ="/permissions/{permission_id}/assign/{role_id}",
     *     summary = "Adds an permission to a role.",
     *     tags = {"Permission"},
     *     description = "Adds an permission to a role.",
     *     operationId = "addPermissionToRole",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="permission_id",
     *         in="path",
     *         description="Id of the permission",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="role_id",
     *         in="path",
     *         description="Id of the role",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Permission successfully added to the role",
     *     ),
     *    @SWG\Response(
     *         response=404,
     *         description="Permission / role not found",
     *     ),
     *    @SWG\Response(
     *         response=409,
     *         description="Permission already added to role",
     *     ),
     * ),
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

    /**
     * @SWG\Delete(
     *     path ="/permissions/{permission_id}/remove/{role_id}",
     *     summary = "Removes an permission from a role.",
     *     tags = {"Permission"},
     *     description = "Removes an permission from a role.",
     *     operationId = "removePermissionFromRole",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="permission_id",
     *         in="path",
     *         description="Id of the permission",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="role_id",
     *         in="path",
     *         description="Id of the role",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Permission succesfully removed from the role",
     *     ),
     *    @SWG\Response(
     *         response=404,
     *         description="Permission / role not found",
     *     ),
     *    @SWG\Response(
     *         response=409,
     *         description="Role does not contain this permission",
     *     ),
     * ),
     */
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
            return $this->response(409, "Role does not contain this permission");
        } else {
            $permission->roles()->detach($role_id);
            return response()->json("Permission removed from the role", 200);
        }
    }
}
