<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $carrierName;

    /**
     * @ORM\Column(type="float")
     */
    private $carrierprice;

    /**
     * @ORM\Column(type="text")
     */
    private $delivery;

    /**
     * @ORM\OneToMany(targetEntity=OrderDetaille::class, mappedBy="myorder")
     */
    private $orderDetailles;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPaid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $referance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $checkoutSessionId;

    public function __construct()
    {
        $this->orderDetailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    public function getTotal()
    {
        $ordersdetailles = $this->getOrderDetailles()->getValues() ;
        $total = null ;
        foreach($ordersdetailles as  $product)
        {
          
           $total += $product->getTotal();
        }
        return $total ;

    }
    public  function getDate()
    {
        return $this->getCreatedAt();
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCarrierName(): ?string
    {
        return $this->carrierName;
    }

    public function setCarrierName(string $carrierName): self
    {
        $this->carrierName = $carrierName;

        return $this;
    }

    public function getCarrierprice(): ?float
    {
        return $this->carrierprice;
    }

    public function setCarrierprice(float $carrierprice): self
    {
        $this->carrierprice = $carrierprice;

        return $this;
    }

    public function getDelivery(): ?string
    {
        return $this->delivery;
    }

    public function setDelivery(string $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * @return Collection|OrderDetaille[]
     */
    public function getOrderDetailles(): Collection
    {
        return $this->orderDetailles;
    }

    public function addOrderDetaille(OrderDetaille $orderDetaille): self
    {
        if (!$this->orderDetailles->contains($orderDetaille)) {
            $this->orderDetailles[] = $orderDetaille;
            $orderDetaille->setMyorder($this);
        }

        return $this;
    }

    public function removeOrderDetaille(OrderDetaille $orderDetaille): self
    {
        if ($this->orderDetailles->removeElement($orderDetaille)) {
            // set the owning side to null (unless already changed)
            if ($orderDetaille->getMyorder() === $this) {
                $orderDetaille->setMyorder(null);
            }
        }

        return $this;
    }

    public function getIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): self
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getReferance(): ?string
    {
        return $this->referance;
    }

    public function setReferance(string $referance): self
    {
        $this->referance = $referance;

        return $this;
    }

    public function getCheckoutSessionId(): ?string
    {
        return $this->checkoutSessionId;
    }

    public function setCheckoutSessionId(string $checkoutSessionId): self
    {
        $this->checkoutSessionId = $checkoutSessionId;

        return $this;
    }
}
