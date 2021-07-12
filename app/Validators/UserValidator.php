<?php


namespace App\Validators;


use App\Entity\UserEntity;

/**
 * Class UserValidator
 * @package App\Validators
 */
class UserValidator
{

    /**
     * @param UserEntity $userEntity
     * @return bool
     */
    public function passed(UserEntity $userEntity): bool
    {

        return $this->hasAvatar($userEntity) &&
            $this->hasEmail($userEntity) && $this->hasFirstName($userEntity) &&
            $this->hasLastName($userEntity) === true;
        
    }


    /**
     * @param UserEntity $userEntity
     * @return bool
     */
    private function hasFirstName(UserEntity $userEntity) :bool
    {
        return !is_null($userEntity->getFirstName());
    }

    /**
     * @param UserEntity $userEntity
     * @return bool
     */
    private function hasLastName(UserEntity $userEntity) :bool
    {
        return !is_null($userEntity->getLastName());
    }

    /**
     * @param UserEntity $userEntity
     * @return bool
     */
    private function hasAvatar(UserEntity $userEntity) :bool
    {
        return !is_null($userEntity->getAvatar());

    }

    /**
     * @param UserEntity $userEntity
     * @return bool
     */
    private function hasEmail(UserEntity $userEntity) :bool
    {
        return !is_null($userEntity->getEmail());
    }
}