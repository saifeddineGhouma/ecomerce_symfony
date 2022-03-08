<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Address;
use App\Form\AdressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private $entitymanager ;
    public function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entitymanager = $entitymanager ;
    }
    /**
     * @Route("/account/address", name="account_address")
     */
    public function index(): Response
    {
        
        return $this->render('account/_address.html.twig');
    }

      /**
     * @Route("/account/address/add", name="account.address.add")
     */
    public function add(Cart $cart ,Request $request): Response
    {
        $adress = new Address();
       
        $form =  $form = $this->createForm(AdressType::class,$adress);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $adress->setUser($this->getUser());
            $this->entitymanager->persist($adress);
            $this->entitymanager->flush();
             if(!empty($cart->get()))
             return $this->redirectToRoute('order');

            return $this->redirectToRoute('account_address');
        }
        return $this->render('account/_add_address.html.twig',
    ['form'=>$form->createView()]);
    }


     /**
     * @Route("/account/address/edit/{id}", name="account.address.edit")
     */
    public function edit(Request $request , $id): Response
    {
        $adress = $this->entitymanager->getRepository(Address::class)->findOneById($id);
        if(empty($adress) || $adress->getUser() != $this->getUser())
          return $this->redirectToRoute('account_address');
       
        $form =  $form = $this->createForm(AdressType::class,$adress);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            
            $this->entitymanager->flush();

            return $this->redirectToRoute('account_address');
        }
        return $this->render('account/_edit_address.html.twig',
    ['form'=>$form->createView()]);
    }



             /**
     * @Route("/account/address/delete/{id}", name="account.address.delete")
     */
    public function delete($id): Response
    {
        $adress = $this->entitymanager->getRepository(Address::class)->findOneById($id);
        if(!empty($adress) && $adress->getUser() == $this->getUser())
        {
            $this->entitymanager->remove($adress);
            $this->entitymanager->flush();

        }  
        return $this->redirectToRoute('account_address');
   
    }

}
