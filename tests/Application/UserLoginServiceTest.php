<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use PHPUnit\Framework\TestCase;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;

final class UserLoginServiceTest extends TestCase
{
    /**
     * @test
     */
    public function userDiegoIsLoggedIn()
    {
        $userLoginService = new UserLoginService();
        $user = new User("Diego");

        $this->expectExceptionMessage("User already logged in");

        $userLoginService->manualLogin($user);
        $userLoginService->manualLogin($user);

    }
    /**
     * @test
     */
    public function userIsLoggedIn()
    {
        $userLoginService = new UserLoginService();
        $user = new User("Diego");

        $userLoginService->manualLogin($user);

        $response = $userLoginService->getLoggedUsers();
        
        $this->assertEquals($user,$response[0]);

    }
}
