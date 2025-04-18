<?php

namespace UserLoginService\Application;

use Exception;
use UserLoginService\Domain\User;

class UserLoginService
{
    private array $loggedUsers = [];
    private SessionManager $sessionManager;

    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }
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
        return $this->sessionManager->getSessions();
    }

    public function logout(User $user): string{
        if($this->sessionManager->logout($user->getUserName())){
            return "Ok";
        } 
        return "User not found";
    }

    public function login(string $userName, string $password): string{
        if($this->sessionManager->login($userName,$password)){
            return "Login correcto";
        } 
        return "Login incorrecto";
    } 
}
