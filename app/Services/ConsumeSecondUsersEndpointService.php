<?php


namespace App\Services;


use App\Entity\UserEntity;
use App\Interfaces\ConsumeEndpointServiceInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;


/**
 * Class ConsumeSecondUsersEndpointService
 * @package App\Services
 */
class ConsumeSecondUsersEndpointService extends ConsumeEndpointServiceInterface
{

    /**
     * @var string
     */
    protected string $uri = 'users/user_2';


    /**
     * @return Collection|mixed
     */
    public function callEndpoint(): Collection
    {
        try{
            $response = $this->httpClient->get("{$this->uri}");
            $users =  collect(json_decode($response->getBody()));
            return $this->unifyResponseSchema($users);
        } catch (GuzzleException $e) {
            Log::error($e);
        }
    }


    /**
     * @param Collection $users
     * @return Collection
     */
    protected function unifyResponseSchema(Collection $users): Collection
    {
        $this->unifiedResponse = collect();
        $users->each(function($user){
            $userEntity = new UserEntity();
            $userEntity->setEmail($user->email);
            $userEntity->setAvatar($user->picture);
            $userEntity->setFirstName($user->fName);
            $userEntity->setLastName($user->lName);
            $this->unifiedResponse->push($userEntity);
        });
        return $this->unifiedResponse;
    }


}