<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use PHPUnit\Framework\TestCase;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;
use UserLoginService\Application\SessionManager;
use Mockery;

final class UserLoginServiceTest extends TestCase
{
    private UserLoginService $userLoginService;
    protected function setUp(): void{
        parent::setup();
        $sessionManagerDouble = Mockery::mock(SessionManager::class);
        $this->userLoginService = new UserLoginService($sessionManagerDouble);
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
        $sessionManagerDouble = Mockery::mock(SessionManager::class);
        $sessionManagerDouble->allows('getSessions')->andReturn(4);
        $this->userLoginService = new UserLoginService($sessionManagerDouble);

        $response = $this->userLoginService->getExternalSessions();

        $this->assertEquals(4,$response);

    }
}
