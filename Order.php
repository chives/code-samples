<?php

namespace Adevo\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;

/**
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="Adevo\AdminBundle\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    
   
    
    /** @ORM\OneToOne(targetEntity="JMS\Payment\CoreBundle\Entity\PaymentInstruction") */
    private $paymentInstruction;
    
    

    
    /** @ORM\Column(type="float") */
    private $price;
    
    
    /**
     * @ORM\ManyToOne(
     *      targetEntity = "Common\UserBundle\Entity\User"
     * )
     * 
     * @ORM\JoinColumn(
     *      name = "author_id",
     *      referencedColumnName = "id"
     * )
     */
    private $user;
    
   
    /**
     * @ORM\ManyToOne(
     *      targetEntity = "Adevo\AdminBundle\Entity\PaymentProduct",
     *      inversedBy = "order"
     * )
     * 
     * @ORM\JoinColumn(
     *      name = "paymentProduct_id",
     *      referencedColumnName = "id",
     *      onDelete = "SET NULL"
     * )
     */
    private $paymentProduct;
    
    
    /**
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;

    
    
    public function __construct()
    {
       $this->createDate = new \DateTime();
       //$this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

   

    public function getPaymentInstruction()
    {
        return $this->paymentInstruction;
    }

    
	public function setPaymentInstruction(PaymentInstruction $instruction)
    {
        $this->paymentInstruction = $instruction;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Order
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return Order
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set user
     *
     * @param \Common\UserBundle\Entity\User $user
     *
     * @return Order
     */
    public function setUser(\Common\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Common\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set paymentProduct
     *
     * @param \Adevo\AdminBundle\Entity\PaymentProduct $paymentProduct
     *
     * @return Order
     */
    public function setPaymentProduct(\Adevo\AdminBundle\Entity\PaymentProduct $paymentProduct = null)
    {
        $this->paymentProduct = $paymentProduct;

        return $this;
    }

    /**
     * Get paymentProduct
     *
     * @return \Adevo\AdminBundle\Entity\PaymentProduct
     */
    public function getPaymentProduct()
    {
        return $this->paymentProduct;
    }

    
}
