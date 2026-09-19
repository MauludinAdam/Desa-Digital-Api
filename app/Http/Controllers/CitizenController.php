<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citizen;
use App\Models\FamilyCard;
use App\Helpers\ResponseHelper;
use App\Http\Resources\CitizenResource;
use App\Http\Resources\PaginateResource;
use App\Http\Requests\Citizen\CitizenStoreRequest;
use App\Http\Requests\Citizen\CitizenUpdateRequest;
use Illuminate\Support\Facades\DB;


class CitizenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'row_per_page'  => 'nullable|integer|min:5|max:100',
        ]);

        $rowPerPage = $request->input('row_per_page', 10);

        $search = $request->input('search');

        $citizens = Citizen::with([
        'familyCard',
        'occupation',
        'education'
        ]) 
        ->when($search, function ($query) use ($search){
            $query->search($search);
        })->orderBy('created_at','desc')->paginate($rowPerPage); 

        if($citizens->isEmpty()){
            return ResponseHelper::jsonResponse(false, 'Data penduduk tidak ditemukan', null, 404);
        }

        return ResponseHelper::jsonResponse(true,
            'Data penduduk berhasil diambil',PaginateResource::make($citizens,CitizenResource::class), 200
        );
    }

    public function headOfFamilyOptions()
    {
        try {
            $citizens = Citizen::whereDoesntHave('familyCardsAsHead')
            ->orderBy('full_name','asc')
            ->get();

            return ResponseHelper::jsonResponse(true, 'Data calon kepala keluarga  berhasil diambil', CitizenResource::collection($citizens), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CitizenStoreRequest $request)
    {
        try {
            
            DB::beginTransaction();
            
            $data = $request->validated();

            $citizen = Citizen::create($data);

            
            DB::commit();

            return ResponseHelper::jsonResponse(true,
                'Data penduduk berhasil ditambahkan.', new CitizenResource($citizen), 201
            );
        } catch (\Throwable $e) {
            DB::rollback();

            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $citizen = Citizen::with([
                'familyCard',
                'occupation',
                'education',
                'citizenDocuments',
                'letters',
            ])->find($id);

            if(!$citizen){
                return ResponseHelper::jsonResponse(false, 'Data penduduk tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data penduduk berhasil diambil', new CitizenResource($citizen), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CitizenUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        try {
            $citizen = Citizen::find($id);

            $citizen->update($data);

        return ResponseHelper::jsonResponse(true, 'Data penduduk berhasil diupdate', new CitizenResource($citizen), 200);
        } catch (\ModelNotFoundException $e) {

           return ResponseHelper::jsonResponse(false, 'Data penduduk tidak ditemukan', null, 404);

        } catch (\Throwable $e){
             return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $citizen = Citizen::findOrFail($id);

            if(!$citizen){
                return ResponseHelper::jsonResponse(false, 'Data penduduk tidak ditemukan', null, 404);
            }

            $citizen->delete();

            return ResponseHelper::jsonResponse(true, 'Data penduduk berhasil dihapus.',null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
