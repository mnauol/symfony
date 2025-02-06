<?php

namespace App\Service;

use App\Entity\Task;
use App\Entity\Users;
use App\Repository\TaskRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskService
{
    private TaskRepository $taskRepository;
    private UsersRepository $usersRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        TaskRepository $taskRepository,
        UsersRepository $usersRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->taskRepository = $taskRepository;
        $this->usersRepository = $usersRepository;
        $this->entityManager = $entityManager;
    }

    public function createTask(string $title, string $description = null): JsonResponse
    {
        $task = new Task();
        $task->setTask($title);
        $task->setDescription($description);
        $task->setCompleted(false);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return new JsonResponse(['message' => "Task '{$title}' created successfully"], Response::HTTP_CREATED);
    }

    public function assignTaskToUser(int $taskId, int $userId): JsonResponse
    {
        $task = $this->taskRepository->find($taskId);
        $user = $this->usersRepository->find($userId);

        if (!$task || !$user) {
            return new JsonResponse(['error' => 'User or Task not found'], Response::HTTP_NOT_FOUND);
        }

        $task->setUser($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => "Task '{$task->getTask()}' assigned to user '{$user->getName()}'"]);
    }

    public function toggleTaskStatus(int $taskId): JsonResponse
    {
        $task = $this->taskRepository->find($taskId);
        if (!$task) {
            return new JsonResponse(['error' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

        $task->setCompleted(!$task->isCompleted());
        $this->entityManager->flush();

        return new JsonResponse(['message' => "Task '{$task->getTask()}' status changed to " . ($task->isCompleted() ? 'completed' : 'not completed')]);
    }

    public function deleteTask(int $taskId): JsonResponse
    {
        $task = $this->taskRepository->find($taskId);
        if (!$task) {
            return new JsonResponse(['error' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($task);
        $this->entityManager->flush();

        return new JsonResponse(['message' => "Task '{$task->getTask()}' deleted"]);
    }
}
