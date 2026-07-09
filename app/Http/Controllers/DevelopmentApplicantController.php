<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\DevelopmentApplicantRepositoryInterface;
use App\Http\Resources\DevelopmentApplicantResource;
use App\Http\Requests\DevelopmentApplicantStoreRequest;
use App\Http\Requests\DevelopmentApplicantUpdateRequest;
use App\Http\Resources\PaginateResource;
use App\Helpers\ResponseHelper;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class DevelopmentApplicantController extends Controller implements HasMiddleware
{
    private DevelopmentApplicantRepositoryInterface $developmentApplicantRepository;

    public function __construct(DevelopmentApplicantRepositoryInterface $developmentApplicantRepository) {
        $this->developmentApplicantRepository = $developmentApplicantRepository;
    }

    public function middleware()
    {
        return [
            new Middleware(PermissionMiddleware::using(['development-applicant-list|development-applicant-create|development-applicant-edit|development-applicant-delete']), only: ['index','getAllPaginated','show']),

            new Middleware(PermissionMiddleware::using(['development-applicant-create']), only: ['store']),
            new Middleware(PermissionMiddleware::using(['development-applicant-edit']), only: ['update']),
            new Middleware(PermissionMiddleware::using(['development-applicant-delete']), only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $developmentApplicants = $this->developmentApplicantRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Pendaftaran Pembangunan Berhasil Diambil', DevelopmentApplicantResource::collection($developmentApplicants), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $data = $request->validate([
            'search'        => 'nullable|string',
            'row_per_page'  => 'required|integer',
        ]);

        try {
            $developmentApplicants = $this->developmentApplicantRepository->getAllPaginated(
                $data['search'],
                $data['row_per_page'],
            );

            

            return ResponseHelper::jsonResponse(true, 'Data Pendaftaran Pembangunan Berhasil Diambil', PaginateResource::make($developmentApplicants), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessaget(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DevelopmentApplicantStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $developmentApplicant = $this->developmentApplicantRepository->create($data);

            return ResponseHelper::jsonResponse(true, 'Data Pendaftaran Pembangunan Berhasil Ditambahkan', new DevelopmentApplicantResource($developmentApplicant), 201);
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
            $developmentApplicant = $this->developmentApplicantRepository->getById($id);

            if(!$developmentApplicant){
                return ResponseHelper::jsonResponse(false, 'Detail Data Pendaftaran Pembangunan Tidak Ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true,'Detail Data Pendaftaran Pembangunan Berhasil Ditampilkan', new DevelopmentApplicantResource($developmentApplicant), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DevelopmentApplicantUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $developmentApplicant = $this->developmentApplicantRepository->getById($id);
            
            if(!$developmentApplicant){
                return ResponseHelper::jsonResponse(false, 'Data Pendaftaran Pembangunan Tidak Ditemukan', null, 404);
            }

            $developmentApplicant = $this->developmentApplicantRepository->update($id, $data);

            return ResponseHelper::jsonResponse(true, 'Data Pendaftaran Pembangunan Berhasil Diupdate', new DevelopmentApplicantResource($developmentApplicant), 200);
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
            $developmentApplicant = $this->developmentApplicantRepository->getById($id);

            if(!$developmentApplicant){
                return ResponseHelper::jsonResponse(false, 'Data Pendaftaran Pembangun Tidak Ditemukan', null, 404);
            }

            $developmentApplicant->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data Pendaftaran Pembangunan Berhasil Dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
