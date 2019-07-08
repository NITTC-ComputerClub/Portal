<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\TestCase\AuthenticatedWebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class HomeControllerTest extends AuthenticatedWebTestCase
{
    use FixturesTrait;

    private const FIXTURE_FILE = __DIR__.'/../Fixture/home_controller_test.yaml';

    private const ENDPOINT_SHOW = '/';
    private const TEST_USER = 'normal';

    private const HEADER_SELECTOR = 'h1';
    private const HEADER_NOT_LOGGED_IN = 'Welcome to Portal!';
    private const HEADER_LOGGED_IN = 'Welcome back, '.self::TEST_USER.'!';

    private const CAPTION_SELECTOR = 'p';
    private const CAPTION_NOT_LOGGED_IN = 'You are not logged in.';
    private const CAPTION_LOGGED_IN = 'You are already logged in.';

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
     * @return User the test user
     */
    protected function getTestUser(): User
    {
        return $this->getUserRepository()->findOneBy([
            'username' => self::TEST_USER,
        ]);
    }

    /**
     * Tests to show the index page with no credentials.
     */
    public function testShowNotLoggedIn()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', self::ENDPOINT_SHOW);

        $this->assertEquals(
            self::HEADER_NOT_LOGGED_IN,
            trim($crawler->filter(self::HEADER_SELECTOR)->text())
        );

        $this->assertEquals(
            self::CAPTION_NOT_LOGGED_IN,
            trim($crawler->filter(self::CAPTION_SELECTOR)->text())
        );
    }

    /**
     * Tests to show the index page with the credential.
     */
    public function testShowLoggedIn()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', self::ENDPOINT_SHOW);

        $this->assertEquals(
            self::HEADER_LOGGED_IN,
            trim($crawler->filter(self::HEADER_SELECTOR)->text())
        );

        $this->assertEquals(
            self::CAPTION_LOGGED_IN,
            trim($crawler->filter(self::CAPTION_SELECTOR)->text())
        );
    }
}
