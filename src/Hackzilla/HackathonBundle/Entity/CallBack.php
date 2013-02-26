<?php

namespace Hackzilla\HackathonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CallBack
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Hackzilla\HackathonBundle\Entity\CallBackRepository")
 */
class CallBack
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="fromTel", type="string", length=255, nullable=true)
     */
    private $from;

    /**
     * @var integer
     *
     * @ORM\Column(name="pin", type="integer", nullable=true)
     */
    private $pin;

    /**
     * @var string
     *
     * @ORM\Column(name="callSid", type="string", length=255, nullable=true)
     */
    private $callSid;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @var integer
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="recording", type="text", nullable=true)
     */
    private $recording;

    /**
     * @var integer
     *
     * @ORM\Column(name="recording_duration", type="integer", nullable=true)
     */
    private $recordingDuration;

    /**
     * @var string
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set from
     *
     * @param string $from
     * @return CallBack
     */
    public function setFrom($from)
    {
        $this->from = $from;
    
        return $this;
    }

    /**
     * Get from
     *
     * @return string 
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set callSid
     *
     * @param string $callSid
     * @return CallBack
     */
    public function setCallSid($callSid)
    {
        $this->callSid = $callSid;
    
        return $this;
    }

    /**
     * Get callSid
     *
     * @return string 
     */
    public function getCallSid()
    {
        return $this->callSid;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return CallBack
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return CallBack
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set recording
     *
     * @param string $recording
     * @return CallBack
     */
    public function setRecording($recording)
    {
        $this->recording = $recording;
    
        return $this;
    }

    /**
     * Get recording
     *
     * @return string 
     */
    public function getRecording()
    {
        return $this->recording;
    }

    /**
     * Set recordingDuration
     *
     * @param integer $recordingDuration
     * @return CallBack
     */
    public function setRecordingDuration($recordingDuration)
    {
        $this->recordingDuration = $recordingDuration;
    
        return $this;
    }

    /**
     * Get recordingDuration
     *
     * @return integer 
     */
    public function getRecordingDuration()
    {
        return $this->recordingDuration;
    }

    /**
     * Set pin
     *
     * @param integer $pin
     * @return CallBack
     */
    public function setPin($pin)
    {
        $this->pin = $pin;
    
        return $this;
    }

    /**
     * Get pin
     *
     * @return integer 
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return CallBack
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}