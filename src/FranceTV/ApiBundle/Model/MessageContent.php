<?php
/**
 * Created by PhpStorm.
 * User: SOunalli
 * Date: 04/11/2016
 * Time: 12:22
 */

namespace FranceTV\ApiBundle\Model\Api;

use JMS\Serializer\Annotation As JMS;


class MessageContent
{

    /**
     * Enum("S", "E", "W")
     *
     * @var String
     * @JMS\Type("string")
     */
    private $type;

    /**
     * message a afficher a l'utilisateur
     *
     * @var String
     * @JMS\Type("string")
     */
    private $text;

    /**
     * @return String
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param String $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return String
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param String $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

}