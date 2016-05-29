<?php

namespace CivMail\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity
  * @ORM\Table(name="mail_part")
  */
class MailPart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /* @ORM\Column(type="string") */
    protected $type;
    
    /* @ORM\Column(type="text") */
    protected $content;
    
    /**
     * @ORM\ManyToOne(targetEntity="Mail", inversedBy="parts")
     * @ORM\JoinColumn(name="mail_id", referencedColumnName="id")
     */
    protected $mail;
    
    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getContent()
    {
        return $this->content;
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

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
        return $this;
    }


}