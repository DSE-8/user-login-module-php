<?php

namespace UserLoginService\Application;

use Exception;
use UserLoginService\Domain\User;
use UserLoginService\Infrastructure\FacebookSessionManager;

class UserLoginService
{
    private array $loggedUsers = [];

    public function manualLogin(User $user): void
    {
        if(in_array($user,$this->loggedUsers)){
            throw new Exception("User already logged in");
        } 
        $this->loggedUsers[] = $user;
    }

    public function getLoggedUsers(){
        return $this->loggedUsers;
    } 

    public function getExternalSessions(): int{
        $sessionManager = new FacebookSessionManager();
        return $sessionManager->getSessions();
    } 

}
