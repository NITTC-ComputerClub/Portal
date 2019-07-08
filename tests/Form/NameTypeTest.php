<?php

declare(strict_types=1);

namespace App\Tests\Form;

use App\Entity\Name;
use App\Form\NameType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Test\TypeTestCase;

class NameTypeTest extends TypeTestCase
{
    private const NAME_FIRST = 'dummy_first_name';
    private const NAME_LAST = 'dummy_last_name';
    private const NAME_FIRST_KANA = 'dummy_first_name_kana';
    private const NAME_LAST_KANA = 'dummy_last_name_kana';

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

        $this->form = $this->factory->create(NameType::class);
    }

    /**
     * Tests the form with valid input.
     */
    public function test(): void
    {
        $form = $this->form;
        $form->submit([
            'firstName' => self::NAME_FIRST,
            'lastName' => self::NAME_LAST,
            'firstNameKana' => self::NAME_FIRST_KANA,
            'lastNameKana' => self::NAME_LAST_KANA,
        ]);

        foreach ($form->getErrors(true) as $error) {
            var_dump($error->getMessage());
        }

        $this->assertTrue($form->isValid());

        /** @var Name $name */
        $name = $form->getData();
        self::assertName($this, $name);
    }

    /**
     * Gets the data of a name to use on tests.
     *
     * @return string[]
     */
    public static function getNameData(): array
    {
        return [
            'firstName' => self::NAME_FIRST,
            'lastName' => self::NAME_LAST,
            'firstNameKana' => self::NAME_FIRST_KANA,
            'lastNameKana' => self::NAME_LAST_KANA,
        ];
    }

    /**
     * Asserts the name is valid one.
     *
     * @param TestCase $testCase The test case to assert on.
     * @param Name     $name     The name to assert.
     */
    public static function assertName(TestCase $testCase, Name $name): void
    {
        $testCase->assertInstanceOf(Name::class, $name);
        $testCase->assertEquals(self::NAME_FIRST, $name->getFirstName());
        $testCase->assertEquals(self::NAME_LAST, $name->getLastName());
        $testCase->assertEquals(self::NAME_FIRST_KANA, $name->getFirstNameKana());
        $testCase->assertEquals(self::NAME_LAST_KANA, $name->getLastNameKana());
    }
}
