<?php

namespace CivMail\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** @ORM\Entity
  * @ORM\Table(name="mail")
  */
class Mail
{
    const CONSTRUCTION = 0;
    const QUEUED = 1;
    const SENT = 2;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /** @ORM\Column(type="string") */
    protected $subject;
    
     /** @ORM\Column(type="string", name="content_type") */
    protected $contentType;
    
    /** @ORM\Column(type="string") */
    protected $status;
    
    /** @ORM\Column(type="string", name="reply_name") */
    protected $replyName;
    
    /** @ORM\Column(type="string", name="reply_address") */
    protected $replyAddress;
    
    /** @ORM\Column(type="datetime", name="created_time") */
    protected $createdTime;
    
    /**
     * @ORM\OneToMany(targetEntity="MailParticipant", mappedBy="mail", fetch="EAGER", cascade={"persist"})
     */
    protected $participants;
    
    /**
     * @ORM\OneToMany(targetEntity="MailPart", mappedBy="mail", fetch="EAGER", cascade={"persist"})
     */
    protected $parts;
    
    public function __construct()
    {
        $this->status = self::CONSTRUCTION;
        $this->participants = new ArrayCollection();
        $this->parts = new ArrayCollection();
    }
    
    public function addParticipant($participant)
    {
        $this->participants[] = $participant;
        $participant->setMail($this);
    }
    
    public function addPart($part)
    {
        $this->parts[] = $part;
        $part->setMail($this);
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getContentType()
    {
        return $this->contentType;
    }
    
    public function getStatus()
    {
        return $this->status;
    }

    public function getReplyName()
    {
        return $this->replyName;
    }

    public function getReplyAddress()
    {
        return $this->replyAddress;
    }

    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    public function getParticipants()
    {
        return $this->participants->toArray();
    }
    
    public function getParts()
    {
        return $this->parts->toArray();
    }
    
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }
    
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function setReplyName($replyName)
    {
        $this->replyName = $replyName;
        return $this;
    }

    public function setReplyAddress($replyAddress)
    {
        $this->replyAddress = $replyAddress;
        return $this;
    }

    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
        return $this;
    }

}
