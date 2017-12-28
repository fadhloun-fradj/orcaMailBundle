<?php

namespace Orca\MailBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MailTblMailAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('mailObject')
            ->add('mailExpediteur')
            ->add('mailDestinataire')
            ->add('mailCc')
            ->add('mailBcc')
            ->add('mailBody')
            ->add('mailVueData')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('mailRegle',null,array(
                'label'=>'Regle'
            ))
            ->add('id',null,array(
                'label'=>'User'
            ))
            ->add('mailType',null,array(
                'label'=>'Mail type'
            ))
            ->add('mailObject',null,array(
                'label'=>'Mail object'
            ))
            ->add('mailExpediteur',null,array(
                'label'=>'Mail expediteur'
            ))
            ->add('mailDestinataire',null,array(
                'label'=>'Mail destinataire'
            ))
            ->add('mailCc',null,array(
                'label'=>'Mail CC'
            ))
            ->add('mailBcc',null,array(
                'label'=>'Mail BCC'
            ))
            ->add('mailBody',null,array(
                'label'=>'Mail body'
            ))
//            ->add('mailVueData')
            ->add('createdAt',null,array(
                'label'=>'Created at'
            ))
            ->add('updatedAt',null,array(
                'label'=>'Updated at'
            ))
//            ->add('mailRegle')
            ->add('_action', null, [
                'actions' => [
//                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
//            ->add('mailRegle',null,array(
//                'label'=>'Regle'
//            ))
//            ->add('id',null,array(
//                'label'=>'User'
//            ))
            ->add('mailType',null,array(
                'label'=>'Mail type'
            ))
            ->add('mailObject',null,array(
                'label'=>'Mail object'
            ))
            ->add('mailExpediteur',null,array(
                'label'=>'Mail expediteur'
            ))
            ->add('mailDestinataire',null,array(
                'label'=>'Mail destinataire'
            ))
            ->add('mailCc',null,array(
                'label'=>'Mail CC'
            ))
            ->add('mailBcc',null,array(
                'label'=>'Mail BCC'
            ))
            ->add('mailBody','textarea',array(
                'label'=>'Mail body',
                'attr'=>array('rows'=>'15')
            ))
            ->add('mailVueData','textarea',array(
                'label'=>'Mail vue data',
                'attr'=>array('rows'=>'8')
            ))
            ->add('createdAt',null,array(
                'label'=>'Created at'
            ))
            ->add('updatedAt',null,array(
                'label'=>'Updated at'
            ))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('mailObject')
            ->add('mailExpediteur')
            ->add('mailDestinataire')
            ->add('mailCc')
            ->add('mailBcc')
            ->add('mailBody')
            ->add('mailVueData')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
