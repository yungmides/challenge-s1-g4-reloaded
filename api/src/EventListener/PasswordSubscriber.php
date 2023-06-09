<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordSubscriber implements EventSubscriberInterface
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher){}

    public function getSubscribedEvents(): array
    {
//        return [
//            Events::prePersist,
//            Events::preUpdate,
//        ];
        return [];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if (!$object instanceof User) return;

        $object->setPassword($this->passwordHasher->hashPassword($object, $object->getPassword()));
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if (!$object instanceof User) return;

        if ($object->getPassword()) {
            $object->setPassword($this->passwordHasher->hashPassword($object, $object->getPassword()));
        }
    }
}
