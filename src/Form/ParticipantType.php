<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom: ',
                'required' => false,
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom: ',
                'required' => false,
            ])
            ->add('email', TextType::class, [
                'label' => 'Email:',
                'required' => true,
            ])
            ->add('onNewsLetter', CheckboxType::class , [
                'required' => false,
                'label' => ' Je souhaite pouvoir recevoir par email de Novocure les informations et invitations relatives aux évènements mis en place, ainsi qu’à ses produits, services ou toutes autres informations scientifiques. Vous pouvez vous désinscrire à tout moment via ces emails. Pour plus d’informations, la politique de confidentialité est accessible à l’adresse suivante : <a href="https:/docs.novocure.eu/politique-de-confidentialité-novocure-France/">https:/docs.novocure.eu/politique-de-confidentialité-novocure-France/</a>',
                'label_html' => true,
            ])
            ->remove('raison')
            ->add('submit', SubmitType::class, [
                'label' => 'Je valide',
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                // 'action_name' => 'homepage',
                'locale' => 'fr',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
