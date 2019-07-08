<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\TestCase\AuthenticatedWebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends AuthenticatedWebTestCase
{
    use FixturesTrait;

    private const FIXTURE_FILE = __DIR__.'/../Fixture/user_controller_test.yaml';

    private const TEST_USER_ID = 1;
    private const ENDPOINT_PREFIX = '/user/';
    private const ENDPOINT_SHOW = self::ENDPOINT_PREFIX.self::TEST_USER_ID;
    private const ENDPOINT_LIST = self::ENDPOINT_PREFIX.'list';

    /**
     * Sets up the database with fixture files.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtureFiles([
            self::FIXTURE_FILE,
        ]);
    }

    /**
     * Gets the test user to authenticate the client.
     *
     * @return User
     */
    protected function getTestUser(): User
    {
        return $this->getUserRepository()->find(self::TEST_USER_ID);
    }

    /**
     * Tests to show the user with no credentials.
     */
    public function testShowNotLoggedIn(): void
    {
        $client = $this->createClient();
        $client->request('GET', self::ENDPOINT_SHOW);

        /** @var Response $response */
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertEquals(
            '/login',
            $client
                ->getInternalResponse()
                ->getHeader('Location')
        );
    }

    /**
     * Tests to show the user with the credential.
     */
    public function testShowLoggedIn(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', self::ENDPOINT_SHOW);

        /** @var Response $response */
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * Tests to list users.
     */
    public function testList(): void
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', self::ENDPOINT_LIST);

        /** @var Response $response */
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(
            count($this->getUserRepository()->findAll()),
            $crawler->filter('.card')->count()
        );
    }
}
