<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $repository;

    /**
     * UserController constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/user/{id}", name="user")
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(int $id): Response
    {
        $user = $this->repository
            ->findOneBy(
                ['id' => $id]
            )
        ;

        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }
}
