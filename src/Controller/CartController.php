<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $entitymanger ;

    public function __construct(EntityManagerInterface $entitymanger)
    {
        $this->entitymanger =$entitymanger ;
    }

            /**
     * @Route("/cart/remove", name="cart.remove")
     */
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute('products');
    }

             /**
     * @Route("/cart/delete/{id}", name="cart.delete")
     */
    public function delete(Cart $cart , $id): Response
    {
        $cart->delete($id);
        return $this->redirectToRoute('cart');
    }


                 /**
     * @Route("/cart/decresse/{id}", name="cart.decresse")
     */
    public function decresse(Cart $cart , $id): Response
    {
        $cart->decresse($id);
        return $this->redirectToRoute('cart');
    }



    /**
     * @Route("/cart", name="cart")
     */
    public function index(Cart $cart): Response
    {
     
       
        return $this->render('cart/index.html.twig',
            [
                'cart'=>$cart->getAll()
                
            ]);
    }


     /**
     * @Route("/cart/add/{id}", name="cart.add")
     */
    public function add(Cart $cart ,$id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

 
}
