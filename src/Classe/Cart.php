<?php

namespace App\Classe ;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\Else_;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart 
{
    private $session;
    private $entitymanger ;

    public function __construct(EntityManagerInterface $entitymanager,SessionInterface $session)
    {
        $this->session = $session ;
        $this->entitymanger = $entitymanager ;
    }
   
    public function add($id)
    {
        $cart = $this->session->get('cart',[]);
        if(!empty($cart[$id]))
          $cart[$id]++ ;
        else 
          $cart[$id]=1 ;


        $this->session->set('cart',$cart );
    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function remove()
    {
        return $this->session->remove('cart');
    }

    public function delete($id)
    {
        $cart = $this->get();
         unset($cart[$id]);

         $this->session->set('cart',$cart );

    }

    public function decresse($id)
    {
        $cart = $this->get();
        if($cart[$id]>1)
         {
             $cart[$id]-- ;
             $this->session->set('cart',$cart );
         }  
        else
          $this->delete($id);
        

    }
    public function getAll()
    {
        $cart = $this->get();

        $cartComplet =[];
        if(!empty($cart))
     {  foreach($cart as $id=>$quentity)
        {

            $product = $this->entitymanger->getRepository(Product::class)->findOneById($id) ;
            if(empty($product)) 
              {
                  $this->delete($id);
                  continue ;
            }
            $cartComplet[] = [
                'product'=>$product,
                'quentity'=>$quentity
 
            ] ;
        }}
        return $cartComplet ;

    }

}
