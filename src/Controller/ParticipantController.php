<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\InscriptionType;
use App\Form\ParticipantType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class ParticipantController extends AbstractController
{

    private $em;
    private $mailer;

    public function __construct(EntityManagerInterface $entityManagerInterface, MailerInterface $mailerInterface)
    {
        $this->em = $entityManagerInterface;
        $this->mailer = $mailerInterface;
    }


    #[Route('/', name: 'app_home')]
    public function programme(): Response
    {
        return $this->render('participant/programme.html.twig');
    }

    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request): Response
    {

        $participant = new Participant();
        $form = $this->createForm(InscriptionType::class, $participant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($participant);
            $this->em->flush();
            // $this->sendMail($participant);
            $this->addFlash('success', 'Votre inscription a bien été prise en compte');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('participant/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/pas-interesse', name: 'app_pas_interesse')]
    public function pasInteresse(Request $request, UserRepository $userRepository): Response
    {

        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $participant->setRaison('Pas intéressé');
            $this->em->persist($participant);
            $this->em->flush();
            $this->sendMail($participant);
            $this->addFlash('success', 'Votre choix a bien été pris en compte');

            return $this->redirectToRoute('app_pas_interesse');
        }
        return $this->render('participant/pas-interesse.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/pas-disponible', name: 'app_pas_disponible')]
    public function disponible(Request $request): Response
    {

        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $participant->setRaison('Pas disponible');
            $this->sendMail($participant);
            $this->em->persist($participant);
            $this->em->flush();
            $this->addFlash('success', 'Votre choix a bien été pris en compte');
            return $this->redirectToRoute('app_pas_disponible');
        }
        return $this->render('participant/pas-disponible.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function sendMail($participant)
    {
        $email = (new TemplatedEmail())
            ->from('gbmacademy@graphikchannel.com')
            ->to('agnes@actiondeclat.com')
            ->subject('Prospect ne participant pas')
            ->htmlTemplate('participant/email.html.twig')
            ->context([
                'participant' => $participant,
            ]);
        $this->mailer->send($email);

    }
}