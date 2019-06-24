<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 *
 * @Route("/user")
 * @IsGranted("ROLE_USER")
 *
 * @package App\Controller
 */
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
     * @Route("/{id}", name="user")
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
