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

    /**
     * Gets Doctrine service.
     *
     * @return AbstractManagerRegistry
     */
    private function getDoctrine(): AbstractManagerRegistry
    {
        return parent::getContainer()->get('doctrine');
    }

    /**
     * Gets the Doctrine repository of User entity.
     *
     * @return UserRepository
     */
    protected function getUserRepository(): UserRepository
    {
        return $this->getDoctrine()->getRepository(User::class);
    }

    /**
     * Gets the test user to authenticate the client.
     *
     * @return User
     */
    protected function getTestUser(): User
    {
        return $this->getUserRepository()->find(1);
    }

    /**
     * Authenticates the client.
     */
    private function login(): void
    {
        $this->loginAs(
            $this->getTestUser(),
            $this->FIREWALL_NAME
        );
    }

    /**
     * Creates an authenticated client.
     *
     * @return HttpKernelBrowser
     */
    protected function createAuthenticatedClient(): HttpKernelBrowser
    {
        $this->login();

        return $this->makeClient();
    }
}
