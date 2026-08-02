<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\SosialAssistanceCategoryRepositoryInterface;
use App\Helpers\ResponseHelper;
use App\Http\Resources\SosialAssistanceCategoryResource;
use App\Http\Resources\PaginateResource;
use App\Http\Requests\SosialAssistanceCategoryStoreRequest;
use App\Http\Requests\SosialAssistanceCategoryUpdateRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class SosialAssistanceCategoryController extends Controller implements HasMiddleware
{
    private SosialAssistanceCategoryRepositoryInterface $sosialAssistanceCategoryRepository;

    public function __construct(SosialAssistanceCategoryRepositoryInterface $sosialAssistanceCategoryRepository) {
        $this->sosialAssistanceCategoryRepository = $sosialAssistanceCategoryRepository;
    }

    public static function middleware()
    {
        return [
            new Middleware(PermissionMiddleware::using(['sosial-assistance-category-list|sosial-assistance-category-create|sosial-assistance-category-edit|sosial-assistance-category-delete']), only: ['index','getAllPaginated','show']),

            new Middleware(PermissionMiddleware::using(['sosial-assistance-category-create']), only: ['store']),
            new Middleware(PermissionMiddleware::using(['sosial-assistance-category-edit']), only: ['update']),
            new Middleware(PermissionMiddleware::using(['sosial-assistance-category-delete']), only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            $sosialAssistanceCategories = $this->sosialAssistanceCategoryRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Category Bantuan Berhasil Diambil', SosialAssistanceCategoryResource::collection($sosialAssistanceCategories), 200);
        } catch (\Excepton $e) {
            return ResposeHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $data = $request->validate([
            'search'        => 'nullable|string',
            'row_per_page'  => 'required|integer'
        ]);

    
        try {
            $sosialAssistanceCategories = $this->sosialAssistanceCategoryRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page'],
            );

            return ResponseHelper::jsonResponse(true, 'Data Bantuan Category Berhasil Diambil', PaginateResource::make($sosialAssistanceCategories, SosialAssistanceCategoryResource::class), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

        public function store(SosialAssistanceCategoryStoreRequest $request)
        {
            $data = $request->validated();

            try {
               $sosialAssistanceCategories = $this->sosialAssistanceCategoryRepository->create($data);

                return ResponseHelper::jsonResponse(true, 'Category berhasil ditambahkan.', new SosialAssistanceCategoryResource($sosialAssistanceCategories), 201);
            } catch (\Exception $e) {
                return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
            }
        }

        public function show(string $id)
        {
            try {
                $sosialAssistanceCategory = $this->sosialAssistanceCategoryRepository->getById($id);

                if(!$sosialAssistanceCategory){
                    return ResponseHelper::jsonResponse(false, 'Data Category Bantuan Tidak Ditemukan', null, 404);
                }

                return ResponseHelper::jsonResponse(true, 'Data Category Bantuan Berhasil Diambil', new SosialAssistanceCategoryResource($sosialAssistanceCategory), 200);
            } catch (\Exception $e) {
                return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
            }
        }

        public function update(SosialAssistanceCategoryUpdateRequest $request, string $id)
        {
            $data = $request->validated();

            try {
                $sosialAssistanceCategory = $this->sosialAssistanceCategoryRepository->getById($id);

                if(!$sosialAssistanceCategory){
                    return ResponseHelper::jsonResponse(false, 'Data Category Bantuan Tidak Ditemukan', null, 404);
                }

                $sosialAssistanceCategory = $this->sosialAssistanceCategoryRepository->update($id, $data);

                return ResponseHelper::jsonResponse(true, 'Data Category Bantuan Berhasil Diupdate', new SosialAssistanceCategoryResource($sosialAssistanceCategory), 200);
            } catch (\Exception $e) {
                return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
            }
        }

        public function destroy(string $id)
        {
            try {
                $sosialAssistanceCategory = $this->sosialAssistanceCategoryRepository->getById($id);

                if(!$sosialAssistanceCategory){
                    return ResponseHelper::jsonResponse(fales, 'Data category bantuan tidak ditemukan', null, 404);
                }

                $sosialAssistanceCategories = $this->sosialAssistanceCategoryRepository->delete($id);

                return ResponseHelper::jsonResponse(true, 'Data category bantuan berhasil dihapus', null, 200);
            } catch (\Exception $e) {
                return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
            }
        }
    }

