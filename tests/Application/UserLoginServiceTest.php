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
    private User $user;
    private UserLoginService $userLoginService;
    protected function setUp(): void{
        parent::setup();
        $this->user = new User("Diego");
        $sessionManagerDouble = Mockery::mock(SessionManager::class);
        $this->userLoginService = new UserLoginService($sessionManagerDouble);
    } 
    /**
     * @test
     */
    public function userDiegoIsAlreadyLoggedIn()
    {

        $this->expectExceptionMessage("User already logged in");

        $this->userLoginService->manualLogin($this->user);
        $this->userLoginService->manualLogin($this->user);

    }
    /**
     * @test
     */
    public function userDiegoIsLoggedIn()
    {
        $this->userLoginService->manualLogin($this->user);

        $response = $this->userLoginService->getLoggedUsers();
        
        $this->assertContainsEquals($this->user,$response);

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
    /**
     * @test
     */
    public function userNotLoggedInLogsoutAndReturnsUserNotFound()
    {

        $response = $this->userLoginService->logout($this->user);
        
        $this->assertEquals("User not found",$response);

    }
    /**
     * @test
     */
    public function userLoggedInLogsoutAndReturnsOk()
    {
        $this->userLoginService->manualLogin($this->user);
        $response = $this->userLoginService->logout($this->user);
        
        $this->assertEquals("Ok",$response);

    }
}
