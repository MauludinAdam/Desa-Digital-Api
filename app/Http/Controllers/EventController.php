<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Resources\EventResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\EventRepositoryInterface;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;

class EventController extends Controller
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository) {
        $this->eventRepository = $eventRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $events = $this->eventRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Event Berhasil Ditampilkan', EventResource::collection($events), 200);
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
            $events = $this->eventRepository->getAllPaginated(
                $data['search'],
                $data['row_per_page'],
            );

            return ResponseHelper::jsonResponse(true, 'Data Event Berhasil Ditampilkan', PaginateResource::make($events), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(EventStoreRequest $request)
    {

    $data = $request->validated();

        try {
            $event = $this->eventRepository->create($data);

            return ResponseHelper::jsonResponse(true, 'Data Event Berhasil Disimpan', new EventResource($event), 201);
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
            $event = $this->eventRepository->getById($id);

            if(!$event){
                return ResponseHelper::jsonResponse(false,'Data Detail Event Tidak Ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data Detail Event Berhasil Diambil', new EventResource($event), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $event = $this->eventRepository->getById($id);

            if(!$event){
                return ResponseHelper::jsonResponse(false, 'Data Event Tidak Ditemukan', null, 404);
            }

            $event = $this->eventRepository->update($id, $data);

            return ResponseHelper::jsonResponse(true, 'Data Event Berhasil Diupdate', new EventResource($event), 200);
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
            $event = $this->eventRepository->getById($id);

            if(!$event){
                return ResponseHelper::jsonResponse(false, 'Data Event Tidak Ditemukan', null, 404);
            }

            $event->delete($id);

            return ResponseHelper::jsonResponse(true,'Data Event Berhasil Dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
