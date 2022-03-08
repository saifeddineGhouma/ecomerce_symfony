<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{

  private $entitymanager ;
  public function __construct(EntityManagerInterface $entitymanager)
  {
      $this->entitymanager = $entitymanager ;
  }
    /**
     * @Route("/order/stripe/create-session/{referance}", name="order.stripe.create-session")
     */
    public function index(Cart $cart, $referance)
    {
        $YOUR_DOMAIN = 'http://localhost:8000';
        $for_stripe =[];
        $order = $this->entitymanager->getRepository(Order::class)->findOneBy(['referance' => $referance]);
         if(empty($order))
         {
          $resopnse  = new JsonResponse(['erreur' => 'order']);

         }
        
        foreach($order->getOrderDetailles()->getValues() as $produit)
              {
                $product_object = $this->entitymanager->getRepository(Product::class)->findOneBy(['name' => $produit->getProduct()]);
                
             
                $for_stripe [] = [
                    
                      'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => $produit->getPrice(),
                        'product_data' => [
                          'name' => $produit->getProduct(),
                          'images' => [$YOUR_DOMAIN.'/uploads/'.$product_object->getIllustration()],
                        ],
                      ],
                      'quantity' => $produit->getQuantity(),
                  ];

              } 

              $for_stripe [] = [
               
                    
                'price_data' => [
                  'currency' => 'usd',
                  'unit_amount' => $order->getCarrierprice(),
                  'product_data' => [
                    'name' => $order->getCarrierName(),
                    'images' => [$YOUR_DOMAIN],
                  ],
                ],
                'quantity' => 1,
            ];


         
        Stripe::setapikey("sk_test_51IJOoOEMZxiNL3ZZ7F3t7QOSkj5YfnKcmUC0R2ymOXmfI1kLPbMah2VkNr3PNOqOyD5GvevKrl9tqYxlN4V1t2bX00hNyq061n");    
        $checkout_session = Session::create([
          'customer_email'=>$this->getUser()->getEmail(),
          'payment_method_types' => ['card'],
          'line_items' => [
            $for_stripe
          ],
          'mode' => 'payment',
          'success_url' => $YOUR_DOMAIN . '/order/validate/success/{CHECKOUT_SESSION_ID}',
          'cancel_url' => $YOUR_DOMAIN . '/order/validate/failed/{CHECKOUT_SESSION_ID}',
        ]); 

        $order->setCheckoutSessionId($checkout_session->id);
     /*   $this->entitymanager->persist($order);*/
        $this->entitymanager->flush();
           $resopnse  = new JsonResponse(['id' => $checkout_session->id]);
           return $resopnse ;
    
    }
}
