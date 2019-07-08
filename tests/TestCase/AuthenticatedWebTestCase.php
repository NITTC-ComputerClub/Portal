<?php

declare(strict_types=1);

namespace App\Tests\TestCase;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernelBrowser;

class AuthenticatedWebTestCase extends WebTestCase
{
    private $FIREWALL_NAME = 'main';

    private function getDoctrine(): AbstractManagerRegistry
    {
        return parent::getContainer()->get('doctrine');
    }

    protected function getUserRepository(): UserRepository
    {
        return $this->getDoctrine()->getRepository(User::class);
    }

    protected function getTestUser(): User
    {
        return $this->getUserRepository()->find(1);
    }

    private function login(): void
    {
        $this->loginAs(
            $this->getTestUser(),
            $this->FIREWALL_NAME
        );
    }

    protected function createAuthenticatedClient(): HttpKernelBrowser
    {
        $this->login();

        return $this->makeClient();
    }
}
