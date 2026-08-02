<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\SosialAssistanceApplicantRepositoryInterface;
use App\Helpers\ResponseHelper;
use App\Http\Resources\SosialAssistanceApplicantResource;
use App\Http\Resources\PaginateResource;
use App\Http\Requests\SosialAssistanceApplicantStoreRequest;
use App\Http\Requests\RejectSosialAssistanceApplicantRequest;
use App\Http\Requests\SosialAssistanceApplicantUpdateRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SosialAssistanceApplicantController extends Controller
{
    private SosialAssistanceApplicantRepositoryInterface $sosialAssistanceApplicantRepository;

    public function __construct(SosialAssistanceApplicantRepositoryInterface $sosialAssistanceApplicantRepository) {
        $this->sosialAssistanceApplicantRepository = $sosialAssistanceApplicantRepository;
    }

    public static function middleware()
    {
        return [
            new Middleware(PermissionMiddleware::using(['sosial-assistance-applicant-list|sosial-assistance-applicant-create|sosial-assistance-recipient-edit|sosial-assistance-recipient-delete']), only: ['index', 'getAllPaginated','show']),

            new Middleware(PermissionMiddleware::using(['sosial-assistance-applicant-create']), only: ['store']),
            new Middleware(PermissionMiddleware::using(['sosial-assistance-applicant-edit']), only: ['update']).
            new Middleware(PermissionMiddleware::using(['sosial-assistance-applicant-delete']), only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $sosialAssistanceApplicants = $this->sosialAssistanceApplicantRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Sosial Berhasil Diambil', SosialAssistanceApplicantResource::collection($sosialAssistanceApplicants), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search'        => 'nullable|string',
            'row_per_page'  => 'required|integer',
        ]);

        try {
            $sosialAssistanceApplicants = $this->sosialAssistanceApplicantRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page'],
            );

            return ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Sosial Berhasil Diambil', PaginateResource::make($sosialAssistanceApplicants, SosialAssistanceApplicantResource::class), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SosialAssistanceApplicantStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $sosialAssistanceApplicant = $this->sosialAssistanceApplicantRepository->create($data);

            return ResponseHelper::jsonResponse(true, 'Data peneriman Bantuan Berhasil DiTambahkan', new SosialAssistanceApplicantResource($sosialAssistanceApplicant), 201);
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
            $sosialAssistanceApplicant = $this->sosialAssistanceApplicantRepository->getById($id);

            if(!$sosialAssistanceApplicant){
                return ResponseHelper::jsonResponse(false, 'Data Detail Penerima Bantuan Sosial Tidak Ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data Detail Penerima Bantuan Sosial Berhasil Diambil', new SosialAssistanceApplicantResource($sosialAssistanceApplicant), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SosialAssistanceApplicantUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $sosialAssistanceApplicant = $this->sosialAssistanceApplicantRepository->getById($id);

            if(!$sosialAssistanceApplicant){
                return ResponseHelper::jsonResponse(false, 'Data Penerima Bantuan Sosial Tidak Ditemukan', null, 404);
            }

            $sosialAssistanceApplicant = $this->sosialAssistanceApplicantRepository->update($id, $data);

            return ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Berhasil Diupdate', new SosialAssistanceApplicantResource($sosialAssistanceApplicant), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function approve(string $id)
    {
        try {
            $data = $this->sosialAssistanceApplicantRepository->approve($id);

            return ResponseHelper::jsonResponse(true, 'Pengajuan berhasil di setujui', $data, 200);
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function reject(RejectSosialAssistanceApplicantRequest $request, $id)
    {
        try {
            $data = $this->sosialAssistanceApplicantRepository->reject($id, $request->validated());
        return ResponseHelper::jsonResponse(true, 'Pengajuan berhasil ditolak', $data, 200);
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
            $sosialAssistanceApplicant = $this->sosialAssistanceApplicantRepository->getById($id);

            if(!$sosialAssistanceApplicant){
                return ResponseHelper::jsonResponse(false, 'Data Penerima Bantuan Tidak Ditemukan', null, 404);
            }

            $sosialAssistanceApplicant = $this->sosialAssistanceApplicantRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Berhasil Dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
