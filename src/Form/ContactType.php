<?php

namespace App\Form;

use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ContactType extends AbstractType
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
            ->add('member', ChoiceType::class, array(
                'label' => 'Adhérent au Tennis Club de Teyran',
                'choices' => array(
                    'Oui' => 'Oui',
                    'Non' => 'Non')
            ))
            ->add('message', TextareaType::class, array(
                'label' => 'Votre message',
                'required' => true,
                'constraints' => array(
                    new NotBlank(array('message' => 'Veuillez saisir votre message.'))

                )))
            ->add('privacyPolicy', CheckboxType::class, array(
                'label' => "En soumettant ce formulaire, vous acceptez que vos informations personnelles soient exploitées 
                conformément à notre politique de confidentialité.",
                'constraints' => array(
                    new IsTrue(array('message' => 'Pour envoyer ce message, vous devez accepter notre politique de confidentialité.'))
            )))
            ->add('captcha', RecaptchaType::class, array(
                'required' => true,
                'constraints' => array(
                    new Recaptcha2(array('message' => 'reCaptcha invalide'))
                )))
        ;
    }

    public function getName()
    {
        return 'Contact';
    }

}