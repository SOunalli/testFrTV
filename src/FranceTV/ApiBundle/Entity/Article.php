<?php
/**
 * Created by PhpStorm.
 * User: SOunalli
 * Date: 04/11/2016
 * Time: 10:03
 */

namespace FranceTV\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation As JMS;


/**
 * Article
 *
 * @ORM\Table(name="frtv_article")
 * @ORM\Entity
 */
class Article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Exclude()
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(max = 50)
     * @JMS\Type("string")
     *
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=30, unique=true)
     * @Assert\Length(max = 50)
     * @Gedmo\Slug(fields={"title"})
     * @JMS\Type("string")
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="leading_text", type="text", nullable=true)
     * @JMS\Type("string")
     */
    protected $leading;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     * @JMS\Type("string")
     */
    protected $body;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="created_by", type="string", length=50, nullable=true)
     * @Assert\Length(max = 50)
     * @JMS\Type("string")
     */
    protected $createdBy;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Article
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getLeading()
    {
        return $this->leading;
    }

    /**
     * @param string $leading
     * @return Article
     */
    public function setLeading($leading)
    {
        $this->leading = $leading;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return Article
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }


    /**
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param string $createdBy
     * @return Article
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }
}