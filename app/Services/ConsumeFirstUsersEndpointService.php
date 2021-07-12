<?php


namespace App\Services;


use App\Interfaces\ConsumeEndpointServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;


/**
 * Class ConsumeFirstUsersEndpointService
 * @package App\Services
 */
class ConsumeFirstUsersEndpointService extends ConsumeEndpointServiceInterface
{
    /**
     * @var string
     */
    protected string $uri = 'users/users_1';

    /**
     * @return Collection|mixed
     */
    public function callEndpoint(): Collection
    {

       try{
           $response =  $this->httpClient->get("{$this->uri}");
           $users =  collect(json_decode($response->getBody()));

           return $this->unifyResponseSchema($users);
       } catch (\Exception $e) {
           Log::error($e);
       }
    }

}