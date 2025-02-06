<?php

namespace App\Service;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserService
{
    private UsersRepository $usersRepository;
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        UsersRepository $usersRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->usersRepository = $usersRepository;
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public function createUser(string $name, string $email, string $password, string $role = 'ROLE_USER'): JsonResponse
    {
        $user = new Users();
        $user->setName($name);
        $user->setEmail($email);
        $user->setRole($role);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => "User '{$name}' created successfully"], Response::HTTP_CREATED);
    }

    public function getAllUsers(): JsonResponse
    {
        return new JsonResponse($this->usersRepository->findAll());
    }

    public function getUserById(int $id): JsonResponse
    {
        $user = $this->usersRepository->find($id);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($user);
    }

    public function deleteUser(int $id): JsonResponse
    {
        $user = $this->usersRepository->find($id);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => "User '{$user->getName()}' deleted"]);
    }
}
