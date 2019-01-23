<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;

class ReservationTennisCourtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastname', TextType::class, array(
            'label' => 'Nom',
            'required' => true,
            'constraints' => array(
                new NotBlank(array('message' => 'Veuillez saisir votre nom de famille.'))
            )))
            ->add('firstname', TextType::class, array(
                'label' => 'Prénom',
                'required' => true,
                'constraints' => array(
                    new NotBlank(array('message' => 'Veuillez saisir votre prénom.'))
                )))
            ->add('phone', TelType::class, array(
                'label' => 'Téléphone',
                'required' => true,
                'constraints' => array(
                    new NotBlank(array('message' => 'Veuillez saisir votre numéro de téléphone.'))
                )))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'required' => true,
                'constraints' => array(
                    new NotBlank(array('message' => 'Veuillez saisir votre adresse mail.')),
                    new Email(array('strict' => true, 'message' => "Cette adresse mail n'est pas valide."))
                )))
            ->add('date', DateType::class, array(
                'label' => 'Date de réservation souhaitée',
                'data' => new \DateTime(),
                'required' => true,
                'constraints' => array(
                    new NotNull(array('message' => 'Veuillez saisir une date de réservation.')),
                    new Range(array('min' => "today", 'minMessage' => "Vous ne pouvez pas saisir une date ultérieure à aujourd'hui.",
                        'max' => "+1 year", 'maxMessage' => "Vous ne pouvez pas saisir une date au-delà d'une année
                        .")),
                    new GreaterThan(array('value' => 'Today', 'message' => "Vous devez saisir une date supérieure à aujourd'hui."))
            )))
            ->add('time', TimeType::class, array(
                'label' => 'Heure de réservation souhaitée',
                'required' => true,
                'input' => 'datetime',
                'widget' => 'choice'
            ))
            ->add('member', ChoiceType::class, array(
                'label' => 'Adhérent au Tennis Club de Teyran',
                'choices' => array(
                    'Oui' => 'Oui',
                    'Non' => 'Non')
            ))
            ->add('message', TextareaType::class, array(
                'label' => 'Votre message',
                'constraints' => array(
                    new NotBlank(array('message' => 'Veuillez saisir votre message.'))

                )))
            ->add('privacyPolicy', CheckboxType::class, array(
                'label' => "En soumettant ce formulaire, vous acceptez que vos informations personnelles soient exploitées 
                conformément à notre politique de confidentialité.",
                'constraints' => array(
                    new IsTrue(array('message' => 'Pour envoyer ce message, vous devez accepter notre politique de confidentialité.'))
            )));
    }

    public function getName()
    {
        return 'ReservationTennisCourt';
    }

}