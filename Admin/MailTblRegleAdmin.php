<?php

namespace Orca\MailBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MailTblRegleAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id',null,array(
                'label'=>'Regle'
            ))
            ->add('regleLib',null,array(
                'label'=>'Regle lib'
            ))
            ->add('regleHeure',null,array(
                'label'=>'Regle heure'
            ))
            ->add('regleActif',null,array(
                'label'=>'Regle actif'
            ))
            ->add('regleDateEnvoi',null,array(
                'label'=>'Regle date envoi'
            ))
            ->add('regleRenvoi',null,array(
                'label'=>'Regle renvoi'
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id',null,array(
                'label'=>'Regle'
            ))
            ->add('regleLib',null,array(
                'label'=>'Regle lib'
            ))
            ->add('vue',null,array(
                'label'=>'Vue'
            ))
            ->add('mailType',null,array(
                'label'=>'Mail type'
            ))
            ->add('regleFrequence',null,array(
                'label'=>'Regle frequence'
            ))
            ->add('regleHeure',null,array(
                'label'=>'Regle heure'
            ))
            ->add('regleActif',null,array(
                'label'=>'Regle actif'
            ))
            ->add('regleDateEnvoi',null,array(
                'label'=>'Regle date envoi'
            ))
            ->add('regleRenvoi',null,array(
                'label'=>'Regle renvoi'
            ))
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('regleLib',null,array(
                'label'=>'Regle lib'
            ))
            ->add('vue',null,array(
                'label'=>'Vue'
            ))
            ->add('mailType',null,array(
                'label'=>'Mail type'
            ))
            ->add('regleFrequence',null,array(
                'label'=>'Regle frequence'
            ))
            ->add('regleHeure',null,array(
                'label'=>'Regle heure'
            ))
            ->add('regleActif',null,array(
                'label'=>'Regle actif'
            ))
            ->add('regleDateEnvoi',null,array(
                'label'=>'Regle date envoi'
            ))
            ->add('regleRenvoi',null,array(
                'label'=>'Regle renvoi'
            ))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('regleLib')
            ->add('regleHeure')
            ->add('regleActif')
            ->add('regleDateEnvoi')
            ->add('regleRenvoi')
        ;
    }
}
