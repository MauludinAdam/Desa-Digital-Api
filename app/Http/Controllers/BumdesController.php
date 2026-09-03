<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BumdesResource;
use App\Helpers\ResponseHelper;
use App\Models\Bumdes;
use App\Http\Requests\Bumdes\BumdesUpdateRequest;

class BumdesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $profileBumdes = Bumdes::firstOrFail();

        return ResponseHelper::jsonResponse(true, 'Profile bumdes berhasil ditampilkan', new BumdesResource($profileBumdes), 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BumdesUpdateRequest $request)
    {
        
        try {
            $data = $request->validated();
            
            if($request->hasFile('logo')){
                $file = $request->file('logo');

                $fileName = $file->getClientOriginName();
                $data['logo'] = $file->storeAs('bumdes', $fileName, 'public');
            }else{
                unset($data['logo']);
            }

            $profileBumdes = Bumdes::first();

            $profileBumdes->update($data);

            return ResponseHelper::jsonResponse(true, 'Profile bumdes berhasil diperbarui', new BumdesResource($profileBumdes), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
