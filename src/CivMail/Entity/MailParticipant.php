<?php

namespace CivMail\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity
  * @ORM\Table(name="mail_participant")
  */
class MailParticipant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /* @ORM\Column(type="string") */
    protected $composition;
    
    /* @ORM\Column(type="string") */
    protected $name;
    
    /* @ORM\Column(type="string") */
    protected $address;
    
    /**
     * @ORM\ManyToOne(targetEntity="Mail", inversedBy="participants")
     * @ORM\JoinColumn(name="mail_id", referencedColumnName="id")
     */
    protected $mail;
    
    public function getId()
    {
        return $this->id;
    }

    public function getComposition()
    {
        return $this->composition;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setComposition($composition)
    {
        $this->composition = $composition;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
        return $this;
    }


}