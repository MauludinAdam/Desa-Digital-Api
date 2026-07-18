<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\EventParticipantRepositoryInterface;
use App\Helpers\ResponseHelper;
use App\Http\Resources\EventParticipantResource;
use App\Http\Requests\EventParticipantStoreRequest;
use App\Http\Requests\EventParticipantUpdateRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;


class EventParticipantController extends Controller implements HasMiddleware
{
    private EventParticipantRepositoryInterface $eventParticipantRepository;

    public function __construct(EventParticipantRepositoryInterface $eventParticipantRepository) {
        $this->eventParticipantRepository = $eventParticipantRepository;
    }

    public static function middleware()
    {
        return [
            new Middleware(PermissionMiddleware::using(['event-participant-list|event-participant-create|event-participant-edit|event-participant-delete']), only: ['index','getAllPaginated','show']),

            new Middleware(PermissionMiddleware::using(['event-participant-create']), only: ['store']),
            new Middleware(PermissionMiddleware::using(['event-participant-edit']), only: ['update']),
            new Middleware(PermissionMiddleware::using(['event-participant-delete']), only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $eventparticipants = $this->eventParticipantRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Pendaftaran Event Berhasil Ditampilkan', EventParticipantResource::collection($eventparticipants), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $data = $request->validate([
           'search'         => 'nullable|string',
           'row_per_page'   => 'required|integer',
        ]);

        try {
            $events = $this->eventParticipantRepository->getAllPaginated(
                $data['search'],
                $data['row_per_page'],
            );

            return ResponseHelper::jsonResponse(true, 'Data Pendaftaran Event Berhasil Ditampilkan', PaginateResource::make($eventparticipants), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventParticipantStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $eventParticipant = $this->eventParticipantRepository->create($data);

            return ResponseHelper::jsonResponse(true, 'Data Pendaftaran Event Berhasil Ditambahkan', new EventParticipantResource($eventParticipant), 201);
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
            $eventParticipant = $this->eventParticipantRepository->getById($id);

            if(!$eventParticipant){
                return ResponseHelper::jsonResponse(false, 'Data Pendaftaran Event Tidak Ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data Detail Pendaftaran Event Berhasil Ditampilkan', new EventParticipantResource($eventParticipant), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventParticipantUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $eventParticipant = $this->eventParticipantRepository->getById($id);

            if(!$eventParticipant){
                return ResponseHelper::jsonResponse(false, 'Data Pendaftaran Event Tidak Ditemukan', null, 404);
            }

            $eventParticipant = $this->eventParticipantRepository->update($id, $data);

            return ResponseHelper::jsonResponse(true, 'Data Pendaftaran Event Berhasil Diupdate', new EventParticipantResource($eventParticipant), 200);
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
            $eventParticipant = $this->eventParticipantRepository->getbyId($id);

            if(!$eventParticipant){
                return ResponseHelper::jsonResponse(false, 'Data Pendaftaran Event Tidak Ditemukan', null, 404);
            }

            $eventParticipant = $this->eventParticipantRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data Pendaftaran Event Berhasil Dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
