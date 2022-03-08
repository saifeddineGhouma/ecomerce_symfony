<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountOrderController extends AbstractController
{
    private $entitymanager ;
    public function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entitymanager = $entitymanager ;
    }
    /**
     * @Route("/account/order", name="account.order")
     */
    public function index(): Response
    {
        $orders = $this->entitymanager->getRepository(Order::class)->getSuccessOrder($this->getUser());
        return $this->render('account/_order.html.twig',[
            'orders'=>$orders
        ]);
    }


    /**
     * @Route("/account/order/show/{ref}", name="account.order.show")
     */
    public function show($ref): Response
    {
        $order = $this->entitymanager->getRepository(Order::class)->findOneByReferance($ref);
        if(empty($order) || $order->getUser() != $this->getUser())
           return $this->redirectToRoute('account.order');
        return $this->render('account/_order_show.html.twig',[
            'order'=>$order
        ]);
    }


}
