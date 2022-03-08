<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    private $entitymanager ;

    public function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entitymanager = $entitymanager ;
    }
    /**
     * @Route("/sign-up", name="register")
     */
    public function index(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('account');
        }
        $notfication = null ;
        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);

        $form->handleRequest($request);
        /* en submited */
        if($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();
            $search_email = $this->entitymanager->getRepository(User::class)->findOneByEmail($user->getEmail());
            if(empty($search_email))
            {
                $password =  $encoder->encodePassword($user,$user->getPassword());
                $user->setPassword($password);
                $this->entitymanager->persist($user);
                $this->entitymanager->flush();
                $sendmail = new Mail() ;
                $conetnu = 'Bonjour ';
                $conetnu .= $user->getFullname();
                $conetnu .= 'votre contnu sur le site bootique en ligne  cree avec success ' ;
                $sendmail->send($user->getEmail(),$user->getFullname(),'Compte create',$conetnu);
                $notfication = 'success create account' ;
                
            }else{
                $notfication = 'email  exist deja vous ' ;


            }
            
        }

        return $this->render('register/index.html.twig',
    [
        'form'=>$form->createView(),
        'notification'=>$notfication
    ]);
    }
}
