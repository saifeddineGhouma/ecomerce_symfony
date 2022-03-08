<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderValidateController extends AbstractController
{
    private $entitymanager ;
  public function __construct(EntityManagerInterface $entitymanager)
  {
      $this->entitymanager = $entitymanager ;
  }
    /**
     * @Route("/order/validate/success/{CheckoutSessionId}", name="order_validate_success")
     */
    public function success($CheckoutSessionId, Cart $cart): Response
    {
        $order = $this->entitymanager->getRepository(Order::class)->findOneBycheckoutSessionId( $CheckoutSessionId);
        
         if(empty($order) || $order->getUser() != $this->getUser())
              return $this->redirectToRoute('home');

         if(!$order->getIsPaid())
         {
             $order->setIsPaid(1);
             $this->entitymanager->flush();
             $cart->remove();
         }
         $user = $this->getUser() ;
         $sendmail = new Mail() ;
         $conetnu = 'Bonjour ';
         $conetnu .= $user->getFullname();
         $conetnu .= 'votre commande a id '.$order->getReferance().' sur le site bootique en ligne  cree avec success ' ;
         $sendmail->send($user->getEmail(),$user->getFullname(),'Compte create',$conetnu);

        return $this->render('order_validate/success.html.twig',['order'=>$order]);
    }
    
        /**
     * @Route("/order/validate/failed/{CheckoutSessionId}", name="order_validate_failed")
     */
    public function failed($CheckoutSessionId): Response
    {
        $order = $this->entitymanager->getRepository(Order::class)->findOneBycheckoutSessionId( $CheckoutSessionId);
        
         if(empty($order) || $order->getUser() != $this->getUser())
              return $this->redirectToRoute('home');

         

        return $this->render('order_validate/failed.html.twig',['order'=>$order]);
    }
}
