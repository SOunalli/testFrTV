<?php
/**
 * Created by PhpStorm.
 * User: SOunalli
 * Date: 04/11/2016
 * Time: 13:01
 */

namespace FranceTV\ApiBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Translation\TranslatorInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service(id="frtv.api_exception_listener")
 * @DI\Tag(name="kernel.event_listener", attributes = {"event" = "kernel.exception"})
 * Class ApiExceptionListener
 * @package FranceTV\ApiBundle\EventListener
 */
class ApiExceptionListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var TranslatorInterface
     */
    private $translator;


    /**
     * ApiExceptionListener constructor.
     * @DI\InjectParams(params={
     *      "logger"                    = @DI\Inject("logger"),
     *      "translator"               = @DI\Inject("translator")
     * })
     * @param LoggerInterface $logger
     * @param TranslatorInterface $translator
     */
    public function __construct(LoggerInterface $logger, TranslatorInterface $translator)
    {
        $this->logger = $logger;
        $this->translator = $translator;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();

        // Customize your response object to display the exception details
        $response = new JsonResponse();

        $baseUrl = $event->getRequest()->getPathInfo();

        $isDevEnv = substr($event->getRequest()->getBaseUrl(), 0, strlen('/app_dev.php')) == '/app_dev.php' ;

//        if (!$isDevEnv) {
//            $message = 'An error was occurred!';
//        } else {
//            $message = $exception->getMessage();
//        }

        $message = $exception->getMessage();
        $error = [
            'message' => ["type" => "E", "text" => $this->translator->trans($message)],
        ];

        $response->setData($error);

        if ($exception instanceof HttpExceptionInterface) {
            // HttpExceptionInterface is a special type of exception that
            // holds status code and header details
            $response->setStatusCode($exception->getStatusCode());

            $response->headers->replace($exception->getHeaders());
        } else {
            // Otherwise give a generic error
            $response->setStatusCode(JsonResponse::HTTP_OK);
        }

        // Send the modified response object to the event
        $event->setResponse($response);
    }
}
