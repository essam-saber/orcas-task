<?php


namespace App\Services;


use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Mixed_;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    /**
     * @var ConsumeFirstUsersEndpointService
     */
    protected ConsumeFirstUsersEndpointService $consumeFirstUsersEndpointService;
    /**
     * @var ConsumeSecondUsersEndpointService
     */
    protected ConsumeSecondUsersEndpointService $consumeSecondUsersEndpointService;
    /**
     * @var UserValidator
     */
    protected UserValidator $userValidator;
    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * UserService constructor.
     * @param ConsumeFirstUsersEndpointService $consumeFirstUsersEndpointService
     * @param ConsumeSecondUsersEndpointService $consumeSecondUsersEndpointService
     * @param UserValidator $userValidator
     * @param UserRepository $userRepository
     */
    public function __construct(ConsumeFirstUsersEndpointService $consumeFirstUsersEndpointService,
                                ConsumeSecondUsersEndpointService $consumeSecondUsersEndpointService,
                                UserValidator $userValidator,
                                UserRepository $userRepository)
    {
        $this->consumeFirstUsersEndpointService = $consumeFirstUsersEndpointService;
        $this->consumeSecondUsersEndpointService = $consumeSecondUsersEndpointService;
        $this->userValidator = $userValidator;
        $this->userRepository = $userRepository;
    }

    /**
     * @param $keyword
     * @return array
     */
    public function searchUsers($keyword): array
    {

        return $this->userRepository->search($keyword);

    }

    /**
     * @param $take
     * @param $page
     * @return array
     */
    public function getAllUsers($take, $page): array
    {
        return $this->userRepository->all($take, $page);
    }


    /**
     * @return \Illuminate\Support\Collection|mixed
     */
    private function requestApiUsers()
    {
        try{

            $firstUsersCollection = $this->consumeFirstUsersEndpointService->callEndpoint();

            $secondUsersCollection = $this->consumeSecondUsersEndpointService->callEndpoint();

            $apiUsers = $firstUsersCollection->merge($secondUsersCollection);

            return $apiUsers;
        } catch (\Exception $e) {

            Log::error($e);
        }
    }


    /**
     * @return void
     */
    public function storeUsers(): void
    {
        $apiUsers = $this->requestApiUsers();

        $usersToStore = $apiUsers->filter(function($user){
            return $this->userRepository->userExistWithEmail($user->getEmail()) === false;
        })->filter(function($user){
            return $this->userValidator->passed($user) === true;
        })->map(function($user){
            return $user->toArray();
        })->toArray();

        $this->userRepository->saveMany($usersToStore);
    }

}