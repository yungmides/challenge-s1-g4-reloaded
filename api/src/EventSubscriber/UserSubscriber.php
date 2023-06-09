<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\User;
use App\Service\UserEmailService;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private UserEmailService $userEmailService,
        private UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => [
                ['sendEmailConfirmation', EventPriorities::POST_WRITE],
                ['hashPassword', EventPriorities::PRE_WRITE],
            ],
        ];
    }


    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmailConfirmation(ViewEvent $event): void
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$user instanceof User || Request::METHOD_POST !== $method) {
            return;
        }
        if ($user->isVerified() || str_contains($user->getEmail(), 'example.com')) {
            return;
        }

        $this->userEmailService->sendEmailVerification($user);
    }

    public function hashPassword(ViewEvent $event): void
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        $body = json_decode($event->getRequest()->getContent());

        if (!$user instanceof User || !in_array($method, [Request::METHOD_POST, Request::METHOD_PATCH, Request::METHOD_PUT])) {
            return;
        }

        if (isset($body->password)) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $body->password));
        }
    }

}
