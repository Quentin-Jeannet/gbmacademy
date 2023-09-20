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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom: ',
                'required' => false,
            'label_attr' => [
                'class' => 'col-sm-12',
            ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom: ',
                'required' => false,
            'label_attr' => [
                'class' => 'col-sm-12',
            ],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email:',
                'required' => true,
            'label_attr' => [
                'class' => 'col-sm-12',
            ],
            ])
            ->add('onNewsLetter', CheckboxType::class , [
                'required' => false,
                'label' => ' Je souhaite pouvoir recevoir par email de Novocure les informations et invitations relatives aux évènements mis en place, ainsi qu’à ses produits, services ou toutes autres informations scientifiques. Vous pouvez vous désinscrire à tout moment via ces emails. Pour plus d’informations, la politique de confidentialité est accessible à l’adresse suivante : <a class="text-color" href="https:/docs.novocure.eu/politique-de-confidentialité-novocure-France/">https:/docs.novocure.eu/politique-de-confidentialité-novocure-France/</a>',
                'label_html' => true,
            'label_attr' => [
                'class' => 'col-sm-12',
            ],
            ])
            ->add('titre', ChoiceType::class, [
                'label' => 'Titre',
                'choices' => [
                'Professeur' => 'Professeur',
                'Docteur' => 'Docteur',

                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            'label_attr' => [
                'class' => 'col-sm-12',
            ],
            ])
            ->add('civilite', ChoiceType::class, [
                'label' => 'Civilité',
                'choices' => [
                'Monsieur' => 'Monsieur',
                'Madame' => 'Madame',
                ],
                'required' => false,
            'label_attr' => [
                'class' => 'col-sm-12',
            ],
            ])
            ->add('dateNaissance', DateType::class,[
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'required' => false,
            'label_attr' => [
                'class' => 'col-sm-12',
            ],
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            'label_attr' => [
                'class' => 'col-sm-12',
            ],
            ])
            ->add('ville', TextareaType::class, [
                'label' => 'Ville',
                'required' => false,
            'label_attr' => [
                'class' => 'col-sm-12',
            ],
            ])
            ->add('hopital', TextareaType::class, [
                'label' => 'Hôpital',
                'required' => false,
            'label_attr' => [
                'class' => 'col-sm-12',
            ],
            ])
            ->add('specialite', TextareaType::class, [
                'label' => 'Spécialité',
                'required' => false,
            'label_attr' => [
                'class' => 'col-sm-12',
            ],
            ])
            ->add('service', TextareaType::class, [
                'label' => 'Service',
                'required' => false,
            'label_attr' => [
                'class' => 'col-sm-12',
            ],
            ])
            ->add('numRPPS', TextareaType::class, [
                'label' => 'Numéro RPPS',
                'required' => false,
            'label_attr' => [
                'class' => 'col-sm-12',
            ],
            ])
            ->add('certificat', ChoiceType::class, [
                'label' => 'Certificat de présence',
                'choices' => [
                'Oui' => 'Oui',
                'Non' => 'Non',
                ],
            'expanded' => true,
            'multiple' => false,
            'required' => true,
            'label_attr' => [
                'class' => 'col-sm-12',
            ],
            ])
            ->add('hebergement', ChoiceType::class, [
                'label' => 'J’ai besoin d’un hébergement',
                'choices' => [
                'Oui' => 'Oui',
                'Non' => 'Non',
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            'label_attr' => [
                'class' => 'col-sm-12',
            ],
            ])
            ->add('transport', ChoiceType::class, [
                'label' => 'Pour venir à la 2ème Journée Nationale de la GBM Academy, nous nous chargeons de votre transport. <br><br>J’ai besoin d’un transport',
                'choices' => [
                'Oui' => 'Oui',
                'Non' => 'Non',
                ],
                'label_html' => true,
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'label_attr' => [
                    'class' => 'col-sm-12',
                ],
            ])
            ->add('conditions', CheckboxType::class , [
                'required' => false,
                'label' => 'J’ai lu et j’accepte les conditions d’utilisation',
                'label_html' => true,
                'mapped' => false,
                'label_attr' => [
                    'class' => 'col-sm-12',
                ],
            ])
            ->remove('raison')
            // ->add('submit', SubmitType::class, [
            //     'label' => 'Je valide',
            // ])
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
