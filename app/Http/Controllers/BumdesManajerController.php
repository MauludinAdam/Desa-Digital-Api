<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\BumdesManajerResource;
use App\Helpers\ResponseHelper;
use App\Models\BumdesManajer;
use App\Http\Requests\BumdesManajer\BumdesManajerStoreRequest;
use App\Http\Requests\BumdesManajer\BumdesManajerUpdateRequest;
use Illuminate\Support\Facades\Storage;
class BumdesManajerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'row_per_page'      => 'nullable|integer',
        ]);

        $rowPerPage = $request->input('row_per_page', 10);

        $search = $request->input('search');

        $bumdesManajer = BumdesManajer::with([
            'bumdes',
        ])->when($search, function ($query) use ($search){
            $query->search($search);
        })->orderBy('created_at', 'desc')->paginate($rowPerPage);

        return ResponseHelper::jsonResponse(true, 'Data manajer bumdes berhasil diambil', PaginateResource::make($bumdesManajer, BumdesManajerResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BumdesManajerStoreRequest $request)
    {
        try {
            $data = $request->validated();

           if($request->hasFile('photo')){
            $file = $request->file('photo');

            $fileName = $file->getClientOriginalName();
            $data['photo'] = $file->storeAs('bumdes-manajers', $fileName, 'public');
           }else{
            unset($data['photo']);
           }

            $bumdesManajer = BumdesManajer::create($data);

            return ResponseHelper::jsonResponse(true, 'Data manajer bumdes berhasil disimpan', new BumdesManajerResource($bumdesManajer), 201);
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
            $bumdesManajer = BumdesManajer::find($id);

            if(!$bumdesManajer){
                return ResponseHelper::jsonResponse(false, 'Data pengurus bumdes tidak ditemukan', null, 4040);
            }

            return ResponseHelper::jsonResponse(true, 'Data pengurus bumdes berhasil diambil', new BumdesManajerResource($bumdesManajer), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false. $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BumdesManajerUpdateRequest $request, $id)
    {
        $data = $request->validated();
        try {
            $bumdesManajer = BumdesManajer::findOrFail($id);

            if($request->hasFile('photo')){

            if($bumdesManajer->photo){
                Storage::disk('public')->delete($bumdesManajer->photo);
            }
                $file = $request->file('photo');
                
                $fileName = $file->getClientOriginalName();
                $data['photo'] = $file->storeAs('bumdes-manajers', $fileName, 'public');
                }else{
                    unset($data['photo']);
                    }
    
            $bumdesManajer->update($data);

            return ResponseHelper::jsonResponse(true, 'Data pengurus bumdes berhasil diperbarui', new BumdesManajerResource($bumdesManajer), 200);
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
            $bumdesManajer = BumdesManajer::find($id);

            if(!$bumdesManajer){
                return ResponseHelper::jsonResponse(false, 'Data pengurus bumdes tidak ditemukan', null, 404);
            }

            $bumdesManajer->delete();

            return ResponseHelper::jsonResponse(true, 'Data pengurus bumdes berhasil dihapus', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
