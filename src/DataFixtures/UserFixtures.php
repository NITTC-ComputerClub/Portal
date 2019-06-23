<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Creates the root user.
     *
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $root = new User();
        $root
            ->setUsername('root')
            ->setPassword(
                $this->passwordEncoder->encodePassword(
                    $root,
                    'root'
                )
            )
            ->setRoles([
                'ROLE_ADMIN',
            ])
        ;

        $manager->persist($root);
        $manager->flush();
    }
}
