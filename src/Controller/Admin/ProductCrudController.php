<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
   
            TextField::new('name'),
             SlugField::new('slug')->setTargetFieldName('name'),
            ImageField::new('illustration')->setBasePath('uploads/')
            ->setFormType(FileUploadType::class)
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setUploadDir('public/uploads/'),
            TextField::new('subtitle'),
            MoneyField::new('price')->setCurrency('TND'),
            AssociationField::new('category'),
            TextEditorField::new('description'),
        ];
    }
    
}
