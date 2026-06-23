<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Model\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class PageController extends AbstractController
{
    #[Route('/', name: 'app_page')]
    public function index(
        Request $request,
        MailerInterface $mailer
        ): Response
    {

     $contact = new Contact();

        $form = $this->createForm(
            ContactType::class,
            $contact
        );

        $form->handleRequest($request);
    

        if (
            $form->isSubmitted()
            && $form->isValid()
        ) {

            $email = (new Email())
                ->from('dannery.sophie@gmail.com')
                ->to('dannery.sophie@gmail.com')
                ->replyTo($contact->email)
                ->subject('Nouveau message')
                ->html("
                    <p><strong>Nom :</strong> {$contact->nom}</p>
                    <p><strong>Prénom :</strong> {$contact->prenom}</p>

                    <p><strong>Email :</strong> {$contact->email}</p>

                    <p>{$contact->message}</p>
                ");


        $mailer->send($email);

     



        $this->addFlash(
            'success',
            'Votre message a bien été envoyé.'
        );

            return $this->redirectToRoute('app_page');
        }

        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
            'form' => $form->createView()
        ]);
    }
}
