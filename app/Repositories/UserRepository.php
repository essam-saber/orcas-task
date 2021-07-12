<?php


namespace App\Repositories;


use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Collection;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @param array $users
     */
    public function saveMany(array $users): void
    {
        DB::table('host_users')->insert($users);
    }

    /**
     * @param $take
     * @param $page
     * @return array
     */
    public function all($take, $page): array
    {
        $offset = ($page * $take) - $take;

        return DB::select(DB::raw("SELECT firstName, lastName, email, avatar FROM host_users LIMIT {$take} OFFSET {$offset}"));
    }

    /**
     * @param $keyword
     * @return array
     */
    public function search($keyword): array
    {
        return DB::select(DB::raw("SELECT firstName, lastName, email, avatar FROM host_users 
                WHERE (firstName LIKE '".$keyword."%' OR lastName LIKE '".$keyword."%' OR email LIKE '".$keyword."%' )"));
    }

    /**
     * @param string $email
     * @return bool
     */
    public function userExistWithEmail(string $email): bool
    {
        return DB::table('host_users')->where('email', $email)->exists();
    }
}