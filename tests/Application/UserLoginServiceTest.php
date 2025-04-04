<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use PHPUnit\Framework\TestCase;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;

final class UserLoginServiceTest extends TestCase
{
    private UserLoginService $userLoginService;
    protected function setUp(): void{
        parent::setup();
        $this->userLoginService = new UserLoginService();
    } 
    /**
     * @test
     */
    public function userDiegoIsAlreadyLoggedIn()
    {
        $user = new User("Diego");

        $this->expectExceptionMessage("User already logged in");

        $this->userLoginService->manualLogin($user);
        $this->userLoginService->manualLogin($user);

    }
    /**
     * @test
     */
    public function userDiegoIsLoggedIn()
    {
        $user = new User("Diego");

        $this->userLoginService->manualLogin($user);

        $response = $this->userLoginService->getLoggedUsers();
        
        $this->assertContainsEquals($user,$response);

    }
    /**
     * @test
     */
    public function obtaisExternalSessionsCount()
    {

        $response = $this->userLoginService->getExternalSessions();
        
        $this->assertIsInt($response);

    }
}
