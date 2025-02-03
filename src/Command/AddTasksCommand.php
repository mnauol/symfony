<?php

namespace App\Command;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:add-task',
    description: 'Add new task to the database'
)]
class AddTasksCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('title', InputArgument::REQUIRED, 'Title of the task')
            ->addArgument('description', InputArgument::REQUIRED, 'Description of the task')
            ->addArgument('completed', InputArgument::OPTIONAL, 'Task status (0 - not complited, 1 - complited)', 0);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $title = $input->getArgument('title');
        $description = $input->getArgument('description');
        $completed = (bool) $input->getArgument('completed');

        $task = new Task();
        $task->setTask($title);
        $task->setDescription($description);
        $task->setCompleted($completed);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        $status = $completed ? 'completed' : 'not completed';
        $output->writeln("Task '{$title}' is successfuly added. Task status: {$status}!");

        return Command::SUCCESS;
    }
}