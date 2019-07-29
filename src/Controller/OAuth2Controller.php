<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\OAuth2AuthorizationRequestApproveType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OAuth2Controller extends AbstractController
{
    /**
     * @Route("/authorize", name="oauth2_authorize_approve", methods={"post"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function approveAuthorizationRequest(Request $request): Response
    {
        $form = $this->createForm(OAuth2AuthorizationRequestApproveType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var SubmitButton $approveButton */
            $approveButton = $form->get('approve');

            $request->getSession()->set(
                'oauth2_authorization_approved',
                $approveButton->isClicked()
            );
        }

        return $this->redirect($request->getRequestUri());
    }
}
