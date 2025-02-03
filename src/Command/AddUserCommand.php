<?php

namespace App\Command;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:add-user',
    description: 'Add new user to the database'
)]
class AddUserCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the user')
            ->addArgument('email', InputArgument::REQUIRED, 'Email of the user')
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
            ->addArgument('role', InputArgument::OPTIONAL, 'Role (default: ROLE_USER)', 'ROLE_USER');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $role = $input->getArgument('role');

        $user = new Users();
        $user->setName($name);
        $user->setEmail($email);
        $user->setRole($role);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln("User <info>{$name}</info> is successfully added!");

        return Command::SUCCESS;
    }
}