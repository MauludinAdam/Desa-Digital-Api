<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\SosialAssistanceRecipientRepositoryInterface;
use App\Helpers\ResponseHelper;
use App\Http\Resources\SosialAssistanceRecipientResource;
use App\Http\Requests\SosialAssistanceRecipientStoreRequest;
use App\Http\Requests\SosialAssistanceRecipientUpdateRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SosialAssistanceRecipientController extends Controller
{
    private SosialAssistanceRecipientRepositoryInterface $sosialAssistanceRecipientRepository;

    public function __construct(SosialAssistanceRecipientRepositoryInterface $sosialAssistanceRecipientRepository) {
        $this->sosialAssistanceRecipientRepository = $sosialAssistanceRecipientRepository;
    }

    public static function middleware()
    {
        return [
            new Middleware(PermissionMiddleware::using(['sosial-assistance-recipient-list|sosial-assistance-recipient-create|sosial-assistance-recipient-edit|sosial-assistance-recipient-delete']), only: ['index', 'getAllPaginated','show']),

            new Middleware(PermissionMiddleware::using(['sosial-assistance-recipient-create']), only: ['store']),
            new Middleware(PermissionMiddleware::using(['sosial-assistance-recipient-edit']), only: ['update']).
            new Middleware(PermissionMiddleware::using(['sosial-assistance-recipient-delete']), only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $sosialAssistanceRecipients = $this->sosialAssistanceRecipientRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Sosial Berhasil Diambil', SosialAssistanceRecipientResource::collection($sosialAssistanceRecipients), 200);
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
            $sosialAssistanceRecipients = $this->sosialAssistanceRecipientRepository->getAllPaginated(
                $request['search'],
                $request['row_per_page'],
            );

            return ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Sosial Berhasil Diambil', PaginatedResource::make($sosialAssistanceRecipients), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SosialAssistanceRecipientStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $sosialAssistanceRecipient = $this->sosialAssistanceRecipientRepository->create($data);

            return ResponseHelper::jsonResponse(true, 'Data peneriman Bantuan Berhasil DiTambahkan', new SosialAssistanceRecipientResource($sosialAssistanceRecipient), 201);
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
            $sosialAssistanceRecipient = $this->sosialAssistanceRecipientRepository->getById($id);

            if(!$sosialAssistanceRecipient){
                return ResponseHelper::jsonResponse(false, 'Data Detail Penerima Bantuan Sosial Tidak Ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data Detail Penerima Bantuan Sosial Berhasil Diambil', new SosialAssistanceRecipientResource($sosialAssistanceRecipient), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SosialAssistanceRecipientUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $sosialAssistanceRecipient = $this->sosialAssistanceRecipientRepository->getById($id);

            if(!$sosialAssistanceRecipient){
                return ResponseHelper::jsonResponse(false, 'Data Penerima Bantuan Sosial Tidak Ditemukan', null, 404);
            }

            $sosialAssistanceRecipient = $this->sosialAssistanceRecipientRepository->update($id, $data);

            return ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Berhasil Diupdate', new SosialAssistanceRecipientResource($sosialAssistanceRecipient), 200);
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
            $sosialAssistanceRecipient = $this->sosialAssistanceRecipientRepository->getById($id);

            if(!$sosialAssistanceRecipient){
                return ResponseHelper::jsonResponse(false, 'Data Penerima Bantuan Tidak Ditemukan', null, 404);
            }

            $sosialAssistanceRecipient = $this->sosialAssistanceRecipientRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Berhasil Dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
