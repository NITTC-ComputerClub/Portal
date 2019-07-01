<?php

declare(strict_types=1);

namespace App\Tests\Form;

use App\Entity\User;
use App\Form\UserType;
use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    private const USERNAME = 'dummy_username';
    private const PASSWORD = 'dummy_password';
    private const NAME_FIRST = 'dummy_first_name';
    private const NAME_LAST = 'dummy_last_name';
    private const NAME_FIRST_KANA = 'dummy_first_name_kana';
    private const NAME_LAST_KANA = 'dummy_last_name_kana';
    private const STUDENT_ID = 12345;

    /**
     * @var FormInterface The form to test.
     */
    private $form;

    /** @var DateTimeInterface The date to test with. */
    private $today;

    /**
     * Sets up the form.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->form = $this->factory->create(UserType::class);
        $this->today = new DateTimeImmutable();
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
            'name' => [
                'firstName' => self::NAME_FIRST,
                'lastName' => self::NAME_LAST,
                'firstNameKana' => self::NAME_FIRST_KANA,
                'lastNameKana' => self::NAME_LAST_KANA,
            ],
            'studentId' => self::STUDENT_ID,
            'birthday' => [
                'year' => $this->today->format('Y'),
                'month' => $this->today->format('n'),
                'day' => $this->today->format('j'),
            ],
        ]);

        foreach ($form->getErrors(true) as $error) {
            var_dump($error->getMessage());
        }

        $this->assertTrue($form->isValid());

        /** @var User $user */
        $user = $form->getData();
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(self::USERNAME, $user->getUsername());
        $this->assertEquals(self::PASSWORD, $user->getPassword());
        $this->assertEquals(self::NAME_FIRST, $user->getName()->getFirstName());
        $this->assertEquals(self::NAME_LAST, $user->getName()->getLastName());
        $this->assertEquals(self::NAME_FIRST_KANA, $user->getName()->getFirstNameKana());
        $this->assertEquals(self::NAME_LAST_KANA, $user->getName()->getLastNameKana());
        $this->assertEquals(self::STUDENT_ID, $user->getStudentId());
        $this->assertEquals($this->today->format('Ymd'), $user->getBirthday()->format('Ymd'));
    }
}
