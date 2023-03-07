<?php

namespace App\Controller\Admin;

use App\Entity\NoteCours;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class NoteCoursCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NoteCours::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('cours'),
            ChoiceField::new('note')
                ->setChoices(fn () => [0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5])
                ->renderAsNativeWidget(),
            TextField::new('commentaire'),
            TextField::new('emailEtudiant'),
        ];
    }
    
}
