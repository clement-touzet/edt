<?php

namespace App\Controller\Admin;

use App\Entity\Cours;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;;

use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;


class CoursCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cours::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Informations du cours'),
            IdField::new('id')->hideOnForm(),

            AssociationField::new('matiere')
                ->setFormTypeOptions(['by_reference' => true]),

            ChoiceField::new('type')->setChoices([
                'TD' => 'TD',
                'TP' => 'TP',
                'Cours' => 'Cours',
            ]),

            FormField::addPanel('Programmation du cours'),
            'dateHeureDebut',
            'dateHeureFin',
            AssociationField::new('professeur')
                ->setFormTypeOptions(['by_reference' => true]),
            AssociationField::new('salle')
                ->setFormTypeOptions(['by_reference' => true])
        ];
    }
}
