<?php
namespace App\EventSubscriber ;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{

    private $appKernel ;
    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel ;
    }
    
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setIllustration']
        ];
    }
    public function setIllustration(BeforeEntityPersistedEvent $event)
    {
        if(!($event->getEntityInstance() instanceof Product))
           return ;
        $entity = $event->getEntityInstance();
        $tmp_name = $entity->getIllustration();
        $filename =uniqid();
        $extention = pathinfo($tmp_name,PATHINFO_EXTENSION);
        $project_dir = $this->appKernel->getProjectDir();
        
        move_uploaded_file($tmp_name,$project_dir.'public/uploads/'.$filename.'.'.$extention);

     //   $entity->setIllustration($filename.'.'.$extention);
       

    }

}