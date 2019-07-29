<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Form\OAuth2AuthorizationRequestApproveType;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Trikoder\Bundle\OAuth2Bundle\Event\AuthorizationRequestResolveEvent;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AuthorizationRequestResolveListener
{
    private const SESSION_KEY_IS_APPROVED = 'oauth2_authorization_approved';
    private const TEMPLATE_NAME = 'oauth2/authorize.html.twig';

    /**
     * @var RequestStack the request stack to process
     */
    private $requestStack;

    /**
     * @var PsrHttpFactory the factory to create PSR-7 response from Symfony one
     */
    private $psrHttpFactory;

    /**
     * @var Environment the templating environment of Twig
     */
    private $twigEnvironment;

    /**
     * @var FormFactoryInterface the factory to create forms
     */
    private $formFactory;

    /**
     * AuthorizationRequestResolveListener constructor.
     *
     * @param RequestStack         $requestStack    the request stack to process
     * @param PsrHttpFactory       $psrHttpFactory  the factory to create PSR-7 response from Symfony one
     * @param Environment          $twigEnvironment the templating environment of Twig
     * @param FormFactoryInterface $formFactory     the factory to create forms
     */
    public function __construct(
        RequestStack $requestStack,
        PsrHttpFactory $psrHttpFactory,
        Environment $twigEnvironment,
        FormFactoryInterface $formFactory
    ) {
        $this->requestStack = $requestStack;
        $this->psrHttpFactory = $psrHttpFactory;
        $this->twigEnvironment = $twigEnvironment;
        $this->formFactory = $formFactory;
    }

    /**
     * Handles the event on authorization request resolving.
     *
     * @param AuthorizationRequestResolveEvent $event the event to handle
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function onAuthorizationRequestResolve(AuthorizationRequestResolveEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();

        if (!$session->has(self::SESSION_KEY_IS_APPROVED)) {
            $form = $this->formFactory->create(OAuth2AuthorizationRequestApproveType::class);
            $event->setResponse(
                $this->psrHttpFactory->createResponse(
                    new Response(
                        $this->twigEnvironment->render(self::TEMPLATE_NAME, [
                            'form' => $form->createView(),
                            'client' => $event->getClient(),
                        ])
                    )
                )
            );

            return;
        }

        $isApproved = $session->get(self::SESSION_KEY_IS_APPROVED);
        $session->remove(self::SESSION_KEY_IS_APPROVED);

        $event->resolveAuthorization($isApproved);
    }
}
