<?php

declare(strict_types=1);

namespace App\Tests\Form;

use App\Form\LoginType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Test\TypeTestCase;

class LoginTypeTest extends TypeTestCase
{
    private const USERNAME = 'dummy_username';
    private const PASSWORD = 'dummy_password';

    /**
     * @var FormInterface The form to test.
     */
    private $form;

    /**
     * Sets up the form.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->form = $this->factory->create(LoginType::class);
    }

    /**
     * Tests the form with valid input.
     */
    public function test(): void
    {
        $form = $this->form;
        $form->submit([
            'username' => self::USERNAME,
            'password' => self::PASSWORD,
        ]);

        $this->assertTrue($form->isValid());

        $data = $form->getData();
        $this->assertEquals(self::USERNAME, $data['username']);
        $this->assertEquals(self::PASSWORD, $data['password']);
    }
}
