<?php

namespace Orca\MailBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Templating\TemplateRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MailTblMailTypeAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('mailTypeLib')
            ->add('mailTypeObjet')
            ->add('mailTypeExpediteur')
            ->add('mailTypeCc')
            ->add('mailTypeBcc')
            ->add('mailTypeActif')
            ->add('mailTypeBody')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('mailTypeLib',null,array(
                'label'=>'Label'
            ))
            ->add('mailTypeObjet',null,array(
                'label'=>'Objet'
            ))
            ->add('mailTypeActif',null,array(
                'label'=>'Actif'
            ))
            ->add('mailTypeBody',TemplateRegistry::TYPE_HTML,array(
                'label'=>'Contenu'
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
            ->add('mailTypeLib',null,array(
                'label'=>'Label'
            ))
            ->add('mailTypeObjet',null,array(
                'label'=>'Objet'
            ))
            ->add('mailTypeExpediteur',null,array(
                'label'=>'Expediteur'
            ))
            ->add('mailTypeCc',null,array(
                'label'=>'CC'
            ))
            ->add('mailTypeBcc',null,array(
                'label'=>'BCC'
            ))
            ->add('mailTypeActif',null,array(
                'label'=>'Actif'
            ))
            ->add('mailTypeBody',TextareaType::class,array(
                'label'=>'Contenu',
                'attr' => array(
                    'class' => 'ckeditor', // optional  
                ),
            ))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('mailTypeLib')
            ->add('mailTypeObjet')
            ->add('mailTypeExpediteur')
            ->add('mailTypeCc')
            ->add('mailTypeBcc')
            ->add('mailTypeActif')
            ->add('mailTypeBody')
        ;
    }

    //Setting the template to edit mailtblmailtype.
    //edit and create configuration to let Textarea::class become a ckeditor type.
    public function configure()
    {
        $this->setTemplate('edit','@OrcaMail/CRUD/edit.html.twig');
    }
}
