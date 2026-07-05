<?php

namespace App\Repositories;

use App\Interfaces\SosialAssistanceRecipientRepositoryInterface;
// use App\Repositories\SosialAssistanceRecipientRepository;
use App\Models\SosialAssistanceRecipient;
use Exception;
use Illuminate\Support\Facades\DB;

class SosialAssistanceRecipientRepository implements SosialAssistanceRecipientRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute
    ){
        $query = SosialAssistanceRecipient::where(function ($query) use ($search){
            if($search){
                $query->search($search);
            }
        });

        $query->orderBy('created_at','desc');

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
        ?int $limit,
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
        $query = SosialAssistanceRecipient::where('id', $id);

        return $query->first();
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $sosialAssistanceRecipient = new SosialAssistanceRecipient;

            $sosialAssistanceRecipient->sosial_assistance_id = $data['sosial_assistance_id'];
            $sosialAssistanceRecipient->head_of_family_id    = $data['head_of_family_id'];
            $sosialAssistanceRecipient->amount               = $data['amount'];
            $sosialAssistanceRecipient->reason               = $data['reason'];
            $sosialAssistanceRecipient->bank                 = $data['bank'];
            $sosialAssistanceRecipient->account_number       = $data['account_number'];

            if(isset($data['proof'])){
                $sosialAssistanceRecipient->proof                = $data['proof'];
            }

            if(isset($data['status'])){
                $sosialAssistanceRecipient->status               = $data['status'];
            }

            $sosialAssistanceRecipient->save();

            DB::commit();

            return $sosialAssistanceRecipient;
        } catch (\Exception $e) {
            DB::rollback();

            throw new Exception($e->getMessage());
        }
    }

    public function update(
        string $id,
        array $data,
    ){
        DB::beginTransaction();

        try {
            $sosialAssistanceRecipient = SosialAssistanceRecipient::findOrFail($id);
            $sosialAssistanceRecipient->sosial_assistance_id = $data['sosial_assistance_id'];
            $sosialAssistanceRecipient->head_of_family_id = $data['head_of_family_id'];
            $sosialAssistanceRecipient->amount  = $data['amount'];
            $sosialAssistanceRecipient->bank    = $data['bank'];
            $sosialAssistanceRecipient->reason  = $data['reason'];
            $sosialAssistanceRecipient->account_number = $data['account_number'];

            if(isset($data['proof'])){
                $sosialAssistanceRecipient->proof = $data['proof'];
            }

            if(isset($data['status'])){
                $sosialAssistanceRecipient->status = $data['status'];
            }

            $sosialAssistanceRecipient->save();

            DB::commit();

            return $sosialAssistanceRecipient;
        } catch (\Exception $e) {
            DB::rollback();

            throw new Exception($e->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();

        try {
            $sosialAssistanceRecipient = SosialAssistanceRecipient::find($id);

            $sosialAssistanceRecipient->delete();

            DB::commit();

            return $sosialAssistanceRecipient;
        } catch (\Exception $e) {
            DB::rollback();

            throw new Exception($e->getMessage());
        }
    }
}