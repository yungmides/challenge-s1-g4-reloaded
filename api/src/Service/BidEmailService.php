<?php

namespace App\Service;

use App\Entity\TokenResetPassword;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class BidEmailService
{
    public function __construct(private VerifyEmailHelperInterface $helper, private MailerInterface $mailer, private UserRepository $repository)
    {
    }

    //Fonction pour le mail envoyé quand un autre utilisateur a surenchéri sur celle de l'utilisateur
    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmailBidOldOwner(User $user): void
    {
        $signatureComponents = $this->helper->generateSignature(
            'api_verify_email',
            $user->getId(),
            $user->getEmail(),
            ['id' => $user->getId()]
        );
        $link = $signatureComponents->getSignedUrl();

        $mail = (new TemplatedEmail())
            ->subject('Vous n\'êtes plus le meilleur enchérisseur')
            ->to(new Address($user->getEmail()))
            ->htmlTemplate('emails/verifyEmail.html.twig')
            ->context([
                'link' => $link,
            ]);

        $this->mailer->send($mail);
    }

    //Fonction pour le mail envoyé quand un autre utilisateur a surenchéri sur celle de l'utilisateur
    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmailBidNewOwner(User $user): void
    {
        $signatureComponents = $this->helper->generateSignature(
            'api_verify_email',
            $user->getId(),
            $user->getEmail(),
            ['id' => $user->getId()]
        );
        $link = $signatureComponents->getSignedUrl();

        $mail = (new TemplatedEmail())
            ->subject('Vous n\'êtes plus le meilleur enchérisseur')
            ->to(new Address($user->getEmail()))
            ->htmlTemplate('emails/verifyEmail.html.twig')
            ->context([
                'link' => $link,
            ]);

        $this->mailer->send($mail);
    }
}
