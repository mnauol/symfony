<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UsersRepository;
use App\Repository\TaskRepository;
use App\Entity\Users;
use App\Entity\Task;

final class UserTaskController extends AbstractController
{
    #[Route('/users/{userId}/assign-task/{taskId}', name: 'assign_task', methods: ['POST'])]
    public function assignTask(int $userId, int $taskId, UsersRepository $usersRepository, TaskRepository $taskRepository, EntityManagerInterface $em): Response
    {
        $user = $usersRepository->find($userId);
        $task = $taskRepository->find($taskId);

        if (!$user || !$task) {
            return $this->json(['error' => 'User or Task not found'], Response::HTTP_NOT_FOUND);
        }

        $task->setUser($user);
        $em->flush();

        return $this->json(['message' => "Task '{$task->getTask()}' assigned to user '{$user->getName()}'"]);
    }

    #[Route('/users/{userId}/tasks', name: 'user_tasks', methods: ['GET'])]
    public function getUserTasks(int $userId, UsersRepository $usersRepository): Response
    {
        $user = $usersRepository->find($userId);

        if (!$user) {
            return $this->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($user->getTasks());
    }

  
    #[Route('/users/{userId}/tasks/{taskId}/toggle-status', name: 'toggle_task_status', methods: ['PATCH'])]
    public function toggleTaskStatus(int $userId, int $taskId, UsersRepository $usersRepository, TaskRepository $taskRepository, EntityManagerInterface $em): Response
    {
        $user = $usersRepository->find($userId);
        $task = $taskRepository->find($taskId);

        if (!$user || !$task || $task->getUser() !== $user) {
            return $this->json(['error' => 'User or Task not found'], Response::HTTP_NOT_FOUND);
        }

        $task->setCompleted(!$task->isCompleted());
        $em->flush();

        return $this->json(['message' => "Task '{$task->getTask()}' status changed to " . ($task->isCompleted() ? 'completed' : 'not completed')]);
    }

    #[Route('/users/{userId}/tasks', name: 'delete_user_tasks', methods: ['DELETE'])]
    public function deleteUserTasks(int $userId, UsersRepository $usersRepository, EntityManagerInterface $em): Response
    {
        $user = $usersRepository->find($userId);

        if (!$user) {
            return $this->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        foreach ($user->getTasks() as $task) {
            $em->remove($task);
        }

        $em->flush();

        return $this->json(['message' => "All tasks for user '{$user->getName()}' have been deleted"]);
    }
}
