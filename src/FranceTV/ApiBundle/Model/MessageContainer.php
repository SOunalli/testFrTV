<?php
/**
 * Created by PhpStorm.
 * User: SOunalli
 * Date: 04/11/2016
 * Time: 12:20
 */

namespace FranceTV\ApiBundle\Model\Api;

use JMS\Serializer\Annotation As JMS;


class MessageContainer
{
    /**
     * @var MessageContent
     * @JMS\Type("FranceTV\ApiBundle\Model\Api\MessageContent")
     */
    private $message;

    /**
     * @return MessageContent
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param MessageContent $message
     * @return $this
     */
    public function setMessage(MessageContent $message)
    {
        $this->message = $message;

        return $this;
    }

}