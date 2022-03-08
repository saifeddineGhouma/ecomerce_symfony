<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
    private $entitymanager ;

    public function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entitymanager = $entitymanager ;
    }
    /**
     * @Route("/account/edit-password", name="account_password")
     */
    public function index(Request $request , UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class,$user);
        $form->handleRequest($request);
        $notification =null ;

        if($form->isSubmitted() && $form->isValid())
        {
            $old_password = $form->get('old_password')->getData();
            if($encoder->isPasswordValid($user,$old_password))
            {
                $new_password = $form->get('new_password')->getData();
                $password = $encoder->encodePassword($user,$new_password);
                $user->setPassword($password);
                $this->entitymanager->flush();
                $notification = "votre mot de passe bien modifier " ;

            }else{
                $notification = "votre ancien  mot de passe pas valide " ;

            }
        }
        return $this->render('account/_password.html.twig',
            [
                'form'=>$form->createView(),
                'message'=>$notification

                
            ]
         );
    }
}
