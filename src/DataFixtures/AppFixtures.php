<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Users;
use App\Entity\Task;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setName('admin');
        $admin->setEmail('admin@example.com');
        $admin->setRole('ROLE_ADMIN');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));
        $manager->persist($admin);

        for ($i = 1; $i <= 5; $i++) {
            $user = new Users();
            $user->setName("user{$i}");
            $user->setEmail("user{$i}@example.com");
            $user->setRole('ROLE_USER');
            $user->setPassword($this->passwordHasher->hashPassword($user, 'user'));
            $manager->persist($user);
        }

        for ($i = 1; $i <= 5; $i++) {
            $task = new Task();
            $task->setTask("Task {$i}");
            $task->setDescription("Description for task {$i}");
            $task->setCompleted(false);
            $manager->persist($task);
        }


        $manager->flush();
    }
}