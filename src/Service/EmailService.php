<?php

namespace App\Service;

class EmailService
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var \Twig_Environment
     */
    protected $templating;

    /**
     * @var
     */
    private $emailFrom;


    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating, $emailFrom)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->emailFrom = $emailFrom;
    }


    /**
     * @param $data
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendMailContact($data)
    {
        $message = (new \Swift_Message("Tennis Club de Teyran  - Demande d'informations via le site internet"))
            ->setFrom($data['email']) // je récupère l'adresse donnée par l'internaute dans le formulaire.
            // Dans le controller, j'ai appelé les datas par  $emailService->sendMailContact($form->getData());
            ->setTo($this->emailFrom) // je récupère l'adresse que j'ai enregistré dans parameters.yml grâce à
            // cet
            // argument
            ->setBody($this->templating->render('email/contact.html.twig',
                array('data' => $data)))
            ->setContentType('text/html');
        $this->mailer->send($message);
    }


    /**
     * @param $data
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendMailReservationTennisCourt($data)
    {
        $message = (new \Swift_Message("Tennis Club de Teyran  - Réservation de court de tennis"))
            ->setFrom($data['email'])
            ->setTo($this->emailFrom)
            ->setBody($this->templating->render('email/reservationTennisCourt.html.twig',
                array('data' => $data)))
            ->setContentType('text/html');
        $this->mailer->send($message);
    }

    /**
     * @param $data
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendMailEnrolmentTennisSchool($data)
    {
        $message = (new \Swift_Message("Tennis Club de Teyran  - Inscription à l'école de tennis"))
            ->setFrom($data['email'])
            ->setTo($this->emailFrom)
            ->setBody($this->templating->render('email/enrolmentTennisSchool.html.twig',
                array('data' => $data)))
            ->setContentType('text/html');
        $this->mailer->send($message);
    }

    /**
     * @param $data
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendConfirmationMailEnrolmentTennisSchool($data)
    {
        $message = (new \Swift_Message("Tennis Club de Teyran  - Inscription à l'école de tennis"))
            ->setFrom($this->emailFrom)
            ->setTo($data['email'])
            ->setBody($this->templating->render('email/confirmationEmailEnrolmentTennisSchool.html.twig',
                array('data' => $data)))
            ->setContentType('text/html');
        $this->mailer->send($message);
    }


    /**
     * @param $data
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendMailTennisAdult($data)
    {
        $message = (new \Swift_Message("Tennis Club de Teyran  - Inscription au Tennis Adulte"))
            ->setFrom($data['email'])
            ->setTo($this->emailFrom)
            ->setBody($this->templating->render('email/tennisAdult.html.twig',
                array('data' => $data)))
            ->setContentType('text/html');
        $this->mailer->send($message);
    }

    /**
     * @param $data
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendConfirmationMailTennisAdult($data)
    {
        $message = (new \Swift_Message("Tennis Club de Teyran  - Inscription au Tennis Adulte"))
            ->setFrom($this->emailFrom)
            ->setTo($data['email'])
            ->setBody($this->templating->render('email/ConfirmationEmailTennisAdult.html.twig',
                array('data' => $data)))
            ->setContentType('text/html');
        $this->mailer->send($message);
    }
}