<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MakeUserCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected static $defaultName = 'app:make:user';

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * MakeUserCommand constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setDescription('Creates a new app user');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);

        $username = $io->ask('Unique name of the user to create (e.g. siketyan)');
        $password = $io->askHidden('Initial password of the user');

        $user = (new User());
        $user
            ->setUsername($username)
            ->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $password
                )
            )
        ;

        $io->success('Successfully created!');
    }
}
