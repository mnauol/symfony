<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Task;    

final class TaskController extends AbstractController
{
    #[Route('/task', name: 'app_task')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TaskController.php',
        ]);
    }

    #[Route('/tasks', name: 'task_list', methods: ['GET'])]
    public function listTasks(TaskRepository $taskRepository): Response
    {
        $tasks = $taskRepository->findAll();
        return $this->json($tasks);
    }

    #[Route('/tasks', name: 'task_create', methods: ['POST'])]
    public function createTask(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        $task = new Task();
        $task->setTask($data['title']);
        $task->setDescription($data['description'] ?? null);
        $task->setCompleted(false);

        $em->persist($task);
        $em->flush();
        return $this->json(['message' => 'Task created!']);
    }
}


