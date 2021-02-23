<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Formation;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('activite')
            //->add('dateDepot')
            ->add('entreprise', EntrepriseType::class)
            ->add('formations', EntityType::class, [
              'class' => Formation::class,
              'choice_label' => function(Formation $formations)
              {
                return $formations->getNom() . ' - ' . $formations->getLieu();
              },

              // used to render a select box, check boxes or radios
              'multiple' => true,
              'expanded' => true,
          ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
