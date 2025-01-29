<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Task;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $task = new Task();
        $task->setTask('task');
        $task->setDescription('description');
        $task->setCompleted(false);
        $manager->persist($task);

        for ($i = 1; $i <= 5; $i++) {
            $task = new Task();
            $task->setTask("task{$i}");
            $task->setDescription("description");
            $task->setCompleted(false);
            $manager->persist($task);
        }

        $manager->flush();
    }
}
