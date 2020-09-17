<?php

namespace Orca\MailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailTblVueType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vueLib',null,array(
                'label'=>'Libellé de la requête',
                'attr'=>array('class'=>'form-control')
            ))
            ->add('vueSqlRaw',TextareaType::class,array(
                'attr'=>array('class'=>'tinymce form-control','rows'=>10),
                'label'=>'Requête SQL'
            ))
            ->add('vuePostSqlRaw',TextareaType::class,array(
                'attr'=>array('class'=>'tinymce form-control','rows'=>10),
                'label'=>'Requête SQL (post traitement)'
            ))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Orca\MailBundle\Entity\MailTblVue'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'orca_mailbundle_mailtblvue';
    }


}
