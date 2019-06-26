<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserController constructor.
     *
     * @param UserRepository               $repository
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        UserRepository $repository,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->repository = $repository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/create", name="user_create")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws Exception
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(UserType::class, new User());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $user->getPassword()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'The user was created successfully!');
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView(),
        ]);
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
