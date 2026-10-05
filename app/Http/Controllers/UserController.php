<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\ResponseHelper;
use App\Http\Resources\UserResource;
use App\Http\Resources\PaginateResource;
use App\Http\Requests\users\UserStoreRequest;
use App\Http\Requests\users\UserUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'row_per_page'  => 'nullable|integer',
        ]);

        $rowPerPage = $request->input('row_per_page', 10);
        $search = $request->input('search');

        $user = User::with(['role'])
        ->when($search, function ($query) use ($search){
            $query->Search($search);
        })->orderBy('created_at', 'desc')->paginate($rowPerPage);

        return ResponseHelper::jsonResponse(true, 'Data user manajemen berhasil diambi', PaginateResource::make($user, UserResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        try {

            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            $role = Role::find($data['role_id']);

            if(!$role){
                return ResponseHelper::jsonResponse(false, 'Role tidak ditemukan', null, 404);
            }

            // Assign Role Spatie ke user
            $user->assignRole($role);

            return ResponseHelper::jsonResponse(true, 'Data User berhasil ditambahkan', new UserResource($user), 201);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);

            if(!$user){
                return ResponseHelper::jsonResponse(false, 'Data User Tidak Ditemukan', 404);
            }

            return ResponseHelper::jsonResponse(true, 'Detail User Berhasil Diambil', new UserResource($user), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $user = User::findOrFail($id);

            if(empty($user)){
                return ResponseHelper::jsonResponse(false, 'Data User Tidak Ditemukan', null, 404);
            }

            $user->update($data);

            $role = Role::findOrFail($data['role_id']);
            $user->syncRoles($role->name);

            return ResponseHelper::jsonResponse(true, 'Data User Berhasil Diupdate', new UserResource($user), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500); 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = user::find($id);

            if(!$user){
                return ResponseHelper::jsonResponse(false, 'Data User Tidak Ditemukan', null, 404);
            }

            $user->delete();

            return ResponseHelper::jsonResponse(true, 'Data User Berhasil Dihapus', new UserResource($user), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function status(Request $request, $id)
    {
        
        $request->validate([
            'status' => 'required|in:Active,Inactive',
        ]);

        try {
            $user = User::findOrFail($id);

            // Cek role user mau diubah
            if($user->id === $request->user()->id){
                return ResponseHelper::jsonResponse(false, 'Anda tidak dapat mengubah status akun sendiri', null, 403);
            }

            // tidak boleh mengubah status kepala desa
            if($user->hasRole('Kepala Desa')){
                return ResponseHelper::jsonResponse(false, 'Status kepala desa tidak bisa diubah', null, 403);
            }

            $user->update([
                'status' => $request->status,
            ]);

            return ResponseHelper::jsonResponse(true, 'Status useer berhasil diperbarui', new UserResource($user->load('role')), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
