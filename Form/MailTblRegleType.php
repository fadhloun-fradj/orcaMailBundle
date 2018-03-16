<?php

namespace Orca\MailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailTblRegleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('regleLib',null,array(
                'label'=>'Regle lib',
                'attr'=>array('class'=>'form-control')
            ))
            ->add('vue',null,array(
                'label'=>'Vue',
                'attr'=>array('class'=>'form-control')
            ))
            ->add('mailType',null,array(
                'label'=>'Mail type',
                'attr'=>array('class'=>'form-control')
            ))
            ->add('regleHeure',null,array(
                'label'=>'Regle heure',
                'attr'=>array('class'=>'form-control')
            ))
            ->add('regleFrequence',null,array(
                'label'=>'Regle frequence',
                'attr'=>array('class'=>'form-control')
            ))
            ->add('regleActif',null,array(
                'label'=>'Regle actif',
                'attr'=>array()
            ))
            ->add('regleDateEnvoi',null,array(
                'label'=>'Regle date envoi',
                'attr'=>array('class'=>'')
            ))
            ->add('regleRenvoi',null,array(
                'label'=>'Regle renvoi',
                'attr'=>array()
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Orca\MailBundle\Entity\MailTblRegle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'orca_mailbundle_mailtblregle';
    }


}
