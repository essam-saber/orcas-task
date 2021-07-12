<?php


namespace App\Interfaces;


use App\Entity\UserEntity;
use App\Services\UsersHttpClient;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

/**
 * Class ConsumeEndpointServiceInterface
 * @package App\Interfaces
 */
abstract class ConsumeEndpointServiceInterface
{

    /**
     * @var UsersHttpClient
     */
    protected Client $httpClient;
    /**
     * @var
     */
    protected string $uri;

    /**
     * @var
     */
    protected $unifiedResponse;

    /**
     * ConsumeEndpointServiceInterface constructor.
     * @param UsersHttpClient $httpClient
     */
    public function __construct(UsersHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

    }

    /**
     * @return mixed
     */
    abstract public function callEndpoint(): Collection;

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
            $userEntity->setAvatar($user->avatar);
            $userEntity->setFirstName($user->firstName);
            $userEntity->setLastName($user->lastName);
            $this->unifiedResponse->push($userEntity);
        });
        return $this->unifiedResponse;
    }


    public function getUnifiedResponse()
    {
        return $this->unifiedResponse;
    }

}