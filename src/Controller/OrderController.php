<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetaille;
use App\Form\OrderType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class OrderController extends AbstractController
{
    private $entitymanager ;
    public function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entitymanager = $entitymanager ;
    }
    /**
     * @Route("/order", name="order")
     */
    public function index(Cart $cart,Request $request): Response
    {
        if(empty($this->getUser()->getAddresses()->getValues()))
           return $this->redirectToRoute('account.address.add') ;
        $form = $this->createForm(OrderType::class,null,['user'=>$this->getUser()]);

       
        return $this->render('order/index.html.twig',
        ['form'=>$form->createView(),'cart'=>$cart->getAll()]);
    }

        /**
     * @Route("/order/add", name="order.add")
     */
    public function add(Cart $cart,Request $request): Response
    {
        
        $form = $this->createForm(OrderType::class,null,['user'=>$this->getUser()]);

       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid())
       {
           $date = new DateTime();
           $carrier = $form->get('carriers')->getData() ;
           $adress = $form->get('adresses')->getData() ;
           $delivery = $adress->getName().'<br/>'.$adress->getAdress().'-'.$adress->getPostal().'<br/>'.$adress->getCity().'-'.$adress->getCountry();
              /***save order */
              $order = new Order();
              $ref = $date->format('dmY').'-'.uniqid();
              $order->setReferance($ref);
              $order->setUser($this->getUser());
              $order->setCreatedAt($date) ; 
              $order->setCarrierName($carrier->getName());
              $order->setCarrierPrice($carrier->getPrice());
              $order->setDelivery($delivery);

              $order->setIsPaid(0);
              $this->entitymanager->persist($order);
             
                 
              /**save orderDetaille */
             
              foreach($cart->getAll() as $produit)
              {
                 
                
                  $orderdetialle = new OrderDetaille();
                  $orderdetialle->setMyorder($order);
                  $orderdetialle->setProduct($produit['product']->getName());
                  $orderdetialle->setQuantity($produit['quentity']);
                  $orderdetialle->setPrice($produit['product']->getPrice());
                  $total  = $produit['product']->getPrice() * $produit['quentity'] ;
                  $orderdetialle->setTotal($total) ;

                  $this->entitymanager->persist($orderdetialle);
              } 
             $this->entitymanager->flush();
               return $this->render('order/add.html.twig',
                            [
                                'cart'=>$cart->getAll(),
                                'order'=>$order
                                                            ]);
       }
       return $this->redirectToRoute('cart');
        
    }
}
