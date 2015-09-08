<?php

namespace UrlShortenerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Url
 *
 * @ORM\Table(name="urlshortener_url",indexes={@ORM\Index(name="search_idx", columns={"short_code"})})
 * @ORM\Entity(repositoryClass="UrlShortenerBundle\Entity\UrlRepository")
 * @UniqueEntity("shortCode")
 * @ExclusionPolicy("all")
 */
class Url
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
     * @Assert\NotBlank()
     * @Assert\Length(min = "3")
     * @Assert\Regex(pattern="/^((http|https)\:\/{2})/")
     * @ORM\Column(name="url", type="text")
     * @Expose
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="short_code", type="string", length=255)
     * @Expose
     */
    private $shortCode;

    /**
     * @var \DateTime
     * 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="date_created", type="datetime")
     */
    private $dateCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="counter", type="integer")
     */
    private $counter;


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
     * Set url
     *
     * @param string $url
     * @return Url
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set shortCode
     *
     * @param string $shortCode
     * @return Url
     */
    public function setShortCode($shortCode)
    {
        $this->shortCode = $shortCode;

        return $this;
    }

    /**
     * Get shortCode
     *
     * @return string 
     */
    public function getShortCode()
    {
        return $this->shortCode;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Url
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set counter
     *
     * @param integer $counter
     * @return Url
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;

        return $this;
    }

    /**
     * Get counter
     *
     * @return integer 
     */
    public function getCounter()
    {
        return $this->counter;
    }
    
     /**
     * add one to counter
     *
     * @param integer $counter
     * @return Url
     */
    public function addCounter()
    {
        $this->counter++;

        return $this;
    }
}
