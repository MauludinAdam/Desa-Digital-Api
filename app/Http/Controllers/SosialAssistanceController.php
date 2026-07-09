<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\SosialAssistanceRepositoryInterface;
use App\Helpers\ResponseHelper;
use App\Http\Resources\SosialAssistanceResource;
use App\Http\Resources\PaginateResource;
use App\Http\Requests\SosialAssistanceStoreRequest;
use App\Http\Requests\SosialAssistanceUpdateRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class SosialAssistanceController extends Controller implements HasMiddleware
{
    private SosialAssistanceRepositoryInterface $sosialAssistanceRepository;

    public function __construct(SosialAssistanceRepositoryInterface $sosialAssistanceRepository) {
        $this->sosialAssistanceRepository = $sosialAssistanceRepository;
    }

    public function middleware()
    {
        return [
            new Middleware(PermissionMiddleware::using(['sosial-assistance-list|sosial-assistance-create|sosial-assistance-edit|sosial-assistance-delete']), only: ['index','getAllPaginated', 'show']),

            new Middleware(PermissionMiddleware::using(['sosial-assistance-create']), only: ['store']),
            new Middleware(PermissionMiddleware::using(['sosial-assistance-edit']), only: ['update']),
            new Middleware(PermissionMiddleware::using(['sosial-assistance-delete']), only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $sosialAssistances = $this->sosialAssistanceRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

           return ResponseHelper::jsonResponse(true, 'Data Bantuan Sosial Berhasil Diambil', SosialAssistanceResource::collection($sosialAssistances), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search'        =>  'nullable|string',
            'row_per_page'  => 'required|integer',
        ]);

        try {
            $sosialAssistances = $this->sosialAssistanceRepository->getAllPaginated(
                $request['search'],
                $request['row_per_page'],
            );

            return ResponseHelper::jsonResponse(true, 'Data Bantuan Sosial Berhasil Diambil', PaginateResource::make($sosialAssistances, SosialAssistanceResourec::class), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SosialAssistanceStoreRequest $request)
    {
        $request = $request->validated();

        try {
            $sosialAssistance = $this->sosialAssistanceRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Bantuan Sosial Berhasil Ditambahkan', new SosialAssistanceResource($sosialAssistance), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $sosialAssistance = $this->sosialAssistanceRepository->getById($id);

            if(empty($sosialAssistance)){
                return ResponseHelper::jsonResponse(false, 'Data Detail Bantuan Sosial Tidak Ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data Detail Bantuan Sosial Berhasil Diambil', new SosialAssistanceResource($sosialAssistance), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SosialAssistanceUpdateRequest $request, string $id)
    {
        $request = $request->validated();

         try {
            $sosialAssistance = $this->sosialAssistanceRepository->getById($id);

            if(!$sosialAssistance){
                return ResponseHelper::jsonResponse(false, 'Data Bantuan Sosial Tidak Ditemukan', null, 404);
            }

            $sosialAssistance =$this->sosialAssistanceRepository->update($id, $request);

            return ResponseHelper::jsonResponse(true, 'Data Bantuan Sosial Berhasil Diupdate', new SosialAssistanceResource($sosialAssistance), 200);

         } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
         }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sosialAssistance = $this->sosialAssistanceRepository->getById($id);

            if(empty($sosialAssistance)){
                return ResponseHelper::jsonResponse(false, 'Data Bantuan Sosial Tidak Ditemukan', null, 404);
            }
            
            $sosialAssistance = $this->sosialAssistanceRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data Bantuan Sosial Berhasil Dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
