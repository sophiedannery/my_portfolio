<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_send', methods: ['POST'])]
public function send(
    Request $request,
    MailerInterface $mailer
): Response {

    $nom = $request->request->get('nom');
    $prenom = $request->request->get('prenom');
    $email = $request->request->get('email');
    $message = $request->request->get('message');

    $mail = (new Email())
        ->from('portfolio@test.com')
        ->replyTo($email)
        ->to('tonadresse@gmail.com')
        ->subject('Nouveau message depuis le portfolio')
        ->html("
            <h2>Nouveau message</h2>

            <p><strong>Nom :</strong> {$nom}</p>
            <p><strong>Nom :</strong> {$prenom}</p>
            <p><strong>Email :</strong> {$email}</p>

            <p>{$message}</p>
        ");

    $mailer->send($mail);

    $this->addFlash(
        'success',
        'Votre message a bien été envoyé.'
    );

    return $this->redirectToRoute('app_page');
}
}
