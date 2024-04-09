<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function testEmailHasAGoodSubdomainEmail(): void
    {
        $kernel = self::bootKernel();

        $user = new User();
        $user
            ->setName('Test name')
            ->setEmail('email@test.co')
            ->setPassword('test')
        ;

        $this->assertTrue(strlen(explode('.', $user->getEmail())[1]) >= 2);
    }
}