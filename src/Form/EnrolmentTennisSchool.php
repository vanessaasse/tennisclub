<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;

class EnrolmentTennisSchool extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('childLastname', TextType::class, array(
            'label' => "Nom",
            'required' => true,
            'constraints' => array(
                    new NotBlank(array('message' => 'Veuillez saisir le nom de famille de votre enfant.'))
            )))
            ->add('childFirstname', TextType::class, array(
            'label' => "Prénom",
            'required' => true,
            'constraints' => array(
                new NotBlank(array('message' => 'Veuillez saisir le prénom de votre enfant.')))
            ))
            ->add('childBirthday', DateType::class, array(
                'label' => "Date de naissance",
                'required' => true,
                'data' => new \DateTime(),
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')-100),

                'constraints' => array(
                    new NotNull(array('message' => 'Veuillez saisir la date de naissance de votre enfant.')),
                    new LessThan('Today')
            )))
            ->add('childgender', ChoiceType::class, array(
                'label' => 'Genre',
                'required' => true,
                'choices' => array(
                    'Fille' => 'Fille',
                    'Garçon' => 'Garçon'),
                'constraints' => array(
                    new NotBlank(array('message' => 'Veuillez remplir ce champs.')))
            ))
            ->add('childAdress', TextareaType::class, array(
                'label' => 'Adresse postale',
                'required' => true,
                'constraints' => array(
                new NotBlank(array('message' => "Veuillez saisir l'adresse de votre enfant.")))
            ))
            ->add('childPostalCode', TextType::class, array(
                'label' => "Code Postal",
                'required' => true,
                'constraints' => array(
                    new NotBlank(array('message' => "Veuillez saisir le code postal.")))
            ))
            ->add('childCity', TextType::class, array(
                'label' => "Ville",
                'required' => true,
                'constraints' => array(
                    new NotBlank(array('message' => "Veuillez saisir le nom de votre ville.")))
            ))
            ->add('courses', ChoiceType::class, array(
                'label' => 'Formules choisies :',
                'choices' => array(
                    'choices' => array(
                        'Mini tennis' => 'Mini tennis',
                        'Club junior' => 'Club junior',
                        "Centre d'entraînement" => "Centre d'entraînement",
                        'Team TC Teyran' => 'Team TC Teyran')),
                    'expanded' => true,
                    'multiple' => true
                ))
            ->add('individualTournament', ChoiceType::class, array(
                'label' => "Souhaitez-vous que votre enfant participe aux tournois individuels ?",
                'choices' => array(
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                )))
            ->add('match', ChoiceType::class, array(
                'label' => "Souhaitez-vous que votre enfant participe aux matches par équipe ?",
                'choices' => array(
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                    'Si besoin' => 'Si besoin'
                )))
            ->add('parentLastname', TextType::class, array(
                'label' => 'Nom',
                'required' => true,
                'constraints' => array(
                    new NotBlank(array('message' => 'Veuillez saisir le nom de famille du parent.'))
                )))
            ->add('parentFirstname', TextType::class, array(
                'label' => 'Prénom',
                'required' => true,
                'constraints' => array(
                    new NotBlank(array('message' => 'Veuillez saisir le prénom du parent.')))
            ))
            ->add('phone', TelType::class, array(
                'label' => 'Téléphone',
                'required' => true,
                'constraints' => array(
                    new NotBlank(array('message' => 'Veuillez saisir le numéro de téléphone du parent.'))
                )))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'required' => true,
                'constraints' => array(
                    new NotBlank(array('message' => "Veuillez saisir l'adresse mail du parent.")),
                    new Email(array('strict' => true, 'message' => "Cette adresse mail n'est pas valide."))
                )))
            ->add('image', ChoiceType::class, array(
                'label' => "Autorisez-vous des prises de vue photographiques ou des enregistrements audiovisuels sur 
        lesquels votre enfant pourrait apparaître ? (pour des publications sur le site du club et sur la page Facebook)",
                'choices' => array(
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                )))
            ->add('privacyPolicy', CheckboxType::class, array(
                'label' => "En soumettant ce formulaire, vous acceptez que vos informations personnelles soient exploitées 
                conformément à notre politique de confidentialité.",
                'required' => false
            ));


    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'EnrolmentTennisSchool';
    }

}