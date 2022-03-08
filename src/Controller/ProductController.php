<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Form\FilterType;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entitymanager ;
    public function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entitymanager = $entitymanager ;
    }
    /**
     * @Route("/products", name="products")
     */
    public function index(Request $request): Response
    {
        $products = $this->entitymanager->getRepository(Product::class)->findAll();
            $search = new Search();
          
        $form = $this->createForm(FilterType::class,$search);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
         {
             $data = $form->getData();
             $products = $this->entitymanager->getRepository(Product::class)->findWithSearch($data);
           }
        return $this->render('product/index.html.twig',
                  [
                      'products'=>$products,
                      'form'=>$form->createView()
                  ]);
    }
    /**
     * @Route("/product/{slug}", name="product.show")
     */
    public function show($slug): Response
    {
        $product = $this->entitymanager->getRepository(Product::class)->findOneBy(['slug' => $slug]);
        if(empty($product))
          return $this->redirectToRoute('products');

        return $this->render('product/show.html.twig',
                  ['product'=>$product]);
    }
}
