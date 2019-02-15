<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ForgotPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class, array(
            'label' => 'Saisissez votre adresse mail',
            'required' => true,
            'constraints' => array(
                new NotBlank(array('message' => 'Veuillez saisir votre adresse mail.')),
                new Email(array('strict' => true, 'message' => "Cette adresse mail n'est pas valide."))
            )));
    }
}