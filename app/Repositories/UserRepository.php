<?php 

namespace App\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute
    ){
        $query = User::where(function ($query) use ($search) {
            if($search){
                $query->search($search);
            }
        });

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
        ?int $rowPerPage
    ){
        $query = $this->getAll(
            $search,
            $rowPerPage,
            false
        );

        return $query->paginate($rowPerPage);
    }

    public function create(
        array $data
    ){
        DB::transaction();

        try {
            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);

            $user->save();
            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollback();

            throw new Exception($e->getMessage());
        }
    }
}