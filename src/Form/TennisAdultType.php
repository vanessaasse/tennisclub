<?php

namespace App\Form;

use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class TennisAdultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastname', TextType::class, array(
            'label' => "Nom",
            'required' => true,
            'constraints' => array(
                new NotBlank(array('message' => 'Veuillez saisir votre nom de famille.'))
            )))
            ->add('firstname', TextType::class, array(
                'label' => "Prénom",
                'required' => true,
                'constraints' => array(
                    new NotBlank(array('message' => 'Veuillez saisir votre prénom.')))
            ))
            ->add('birthday', DateType::class, array(
                'label' => "Date de naissance",
                'required' => true,
                'data' => new \DateTime(),
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')-100),
                'constraints' => array(
                    new NotNull(array('message' => 'Veuillez saisir votre date de naissance.')),
                    new LessThan('Today')
                )))
            ->add('gender', ChoiceType::class, array(
                'label' => 'Genre',
                'required' => true,
                'choices' => array(
                    'Fille' => 'Fille',
                    'Garçon' => 'Garçon'),
                'constraints' => array(
                    new NotBlank(array('message' => 'Veuillez remplir ce champs.')))
            ))
            ->add('address', TextareaType::class, array(
                'label' => 'Adresse postale',
                'required' => true,
                'constraints' => array(
                    new NotBlank(array('message' => "Veuillez saisir votre adresse.")))
            ))
            ->add('postalCode', TextType::class, array(
                'label' => "Code Postal",
                'required' => true,
                'constraints' => array(
                    new NotBlank(array('message' => "Veuillez saisir votre code postal.")))
            ))
            ->add('city', TextType::class, array(
                'label' => "Ville",
                'required' => true,
                'constraints' => array(
                    new NotBlank(array('message' => "Veuillez saisir le nom de votre ville.")))
            ))
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
                    new NotBlank(array('message' => "Veuillez saisir votre adresse mail.")),
                    new Email(array('strict' => true, 'message' => "Cette adresse mail n'est pas valide."))
                )))
            ->add('level', ChoiceType::class, array(
                'label' => "Quel est votre niveau au tennis ?",
                'choices' => array(
                    'Débutant' => 'Débutant',
                    'Confirmé' => 'Confirmé'
                )))
            ->add('rank', TextType::class, array(
                'label' => "Etes-vous classé au tennis ? Si oui, indiquez ici votre classement :",
            ))
            ->add('formule', ChoiceType::class, array(
                'label' => "Formules choisies",
                'choices' => array(
                    'Je joue seul(e)' => 'Je joue seul(e)',
                    'Je joue avec mon enfant' => 'Je joue avec mon enfant'
                )))
            ->add('courses', ChoiceType::class, array(
                'label' => 'Je souhaite également :',
                'choices' => array(
                    'choices' => array(
                        'jouer avec un ami' => 'jouer avec un ami',
                        'rechercher un partenaire' => 'rechercher un partenaire',
                        'prendre des cours' => 'prendre des cours',
                        'participer aux compétitions' => 'participer aux compétitions')),
                'expanded' => true,
                'multiple' => true
            ))
            ->add('tournament', ChoiceType::class, array(
                'label' => "Souhaitez-vous participer aux tournois internes en simple ?",
                'choices' => array(
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                )))
            ->add('match', ChoiceType::class, array(
                'label' => "Souhaitez-vous participer aux matches par équipe ?",
                'choices' => array(
                    'Je souhaite participer' => 'Je souhaite participer',
                    'Je suis disponible en cas de besoin' => 'Je suis disponible en cas de besoin',
                    'Je ne souhaite pas participer' => 'Je ne souhaite pas participer'
                )))
            ->add('privacyPolicy', CheckboxType::class, array(
                'label' => "En soumettant ce formulaire, vous acceptez que vos informations personnelles soient exploitées 
                conformément à notre politique de confidentialité.",
                'constraints' => array(
                    new IsTrue(array('message' => 'Pour envoyer votre inscription, vous devez accepter notre politique de confidentialité.'))
                )))
            ->add('captcha', RecaptchaType::class, array(
                'required' => true,
                'constraints' => array(
                    new Recaptcha2(array('message' => 'reCaptcha invalide'))
                )));
    }
}