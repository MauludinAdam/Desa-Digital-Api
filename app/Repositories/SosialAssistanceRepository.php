<?php

namespace App\Repositories;

use App\Interfaces\SosialAssistanceRepositoryInterface;
use App\Models\SosialAssistance;
use Exception;
use Illuminate\Support\Facades\DB;

class SosialAssistanceRepository implements SosialAssistanceRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute
    ){
        $query = SosialAssistance::where(function($query) use ($search){
            if($search){
                $query->search($search);
            }
        });

        $query->orderBy('created_at', 'desc');

        if($limit){
            $query->take($limit);
        }

        if($execute){
            return $query->get();
        }

        return $query;
    }

    public function getAllPaginated(
        ?string $search,
        ?int $limit
    ){
        $query = $this->getAll(
            $search,
            $rowPerPage,
            false
        );

        return $query->paginate($rowPerPage);
    }

    public function getById(
        string $id
    ){
        $query = SosialAssistance::where('id', $id);

        return $query->first();
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $sosialAssistance = new SosialAssistance;
            
            $sosialAssistance->thumbnail    = $data['thumbnail']->store('assets/sosial-assistance','public');
            $sosialAssistance->name         = $data['name'];
            $sosialAssistance->category     = $data['category'];
            $sosialAssistance->amount       = $data['amount'];
            $sosialAssistance->provider     = $data['provider'];
            $sosialAssistance->description  = $data['description'];
            $sosialAssistance->is_available = $data['is_available'];

            $sosialAssistance->save();

            DB::commit();

            return $sosialAssistance;
        } catch (\Exception $e) {
            DB::rollback();

            throw new Exception($e->getMessage());
        }
    }

    public function update(
        string $id,
        array $data
    ){
        DB::beginTransaction();

        try {
            $sosialAssistance = SosialAssistance::findOrFail($id);

            if(isset($data['thumbnail'])){
                $sosialAssistance->thumbnail = $data['thumbnail']->store('assets/sosial-assistance', 'public');
            }

            $sosialAssistance->name         = $data['name'];
            $sosialAssistance->category     = $data['category'];
            $sosialAssistance->amount       = $data['amount'];
            $sosialAssistance->provider     = $data['provider'];
            $sosialAssistance->description   = $data['description'];
            $sosialAssistance->is_available = $data['is_available'];

            $sosialAssistance->save();

            DB::commit();
            
            return $sosialAssistance;
        } catch (\Exception $e) {
            DB::rollback();

            throw new Exception($e->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();

        try {
            $sosialAssistance = SosialAssistance::find($id);

            $sosialAssistance->delete();

            DB::commit();

            return $sosialAssistance;
        } catch (\Exception $e) {
            DB::rollback();

            throw new Exception($e->getMessage());
        }
    }
}