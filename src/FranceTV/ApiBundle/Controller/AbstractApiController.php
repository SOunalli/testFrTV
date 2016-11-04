<?php
/**
 * Created by PhpStorm.
 * User: SOunalli
 * Date: 04/11/2016
 * Time: 10:00
 */

namespace FranceTV\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\FormInterface;

/**
 * Class AbstractApiController.
 */
abstract class AbstractApiController extends FOSRestController
{

    /**
     * @param string $message
     * @param int $httpCode
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function sendResponseSuccessMessage($message = "", $httpCode = Codes::HTTP_OK, array $parameters = [])
    {
        $message = $this->get("translator")->trans($message);
        return $this->sendResponse(["message" =>["type" => "S", "text" => $message]], $httpCode);
    }

    /**
     * @param string $message
     * @param int $httpCode
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function sendResponseWarrningMessage($message = "", $httpCode = Codes::HTTP_OK, array $parameters = [])
    {
        $message = $this->get("translator")->trans($message);
        return $this->sendResponse(["message" =>["type" => "W", "text" => $message]], $httpCode);
    }

    /**
     * send a success response with data.
     *
     * @param array $data
     * @param int   $httpCode
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function sendResponseSuccess($data = array(), $httpCode = Codes::HTTP_OK)
    {
        return $this->sendResponse($data, $httpCode);
    }

    /**
     * Envoi une réponse HTTP avec son code (200 par défaut) en JSON.
     *
     * @param array $data     tableau de données
     * @param int   $httpCode code http
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function sendResponse($data = array(), $httpCode = Codes::HTTP_OK)
    {
        $view = $this->view($data, $httpCode);

        $acceptHeader = $this->get('request_stack')->getCurrentRequest()->headers->get('Accept');
        $format = ($acceptHeader === 'application/xml') ? 'xml' : 'json';
        $view->setFormat($format);

        return $this->handleView($view);
    }

    /**
     * Send many errors.
     *
     * @param array $data
     * @param int   $httpCode
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @deprecated throw an Exception and see our ExceptionListener
     */
    protected function sendResponseErrors($data = array(), $httpCode = Codes::HTTP_INTERNAL_SERVER_ERROR)
    {
        return $this->sendResponse($data, $httpCode);
    }

    /**
     * send one error : message + code.
     *
     * @param string $message           message in response JSON
     * @param int    $internalErrorCode Error code in response JSON
     * @param int    $httpCode          HTTP Error code
     * @param array  $parametres
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    protected function sendResponseError(
        $message,
        $httpCode = Codes::HTTP_INTERNAL_SERVER_ERROR,
        array $parameters = []
    ) {
        $response = ["message" =>["type" => "E", "text" => $this->get('translator')->trans($message, $parameters)]];

        return $this->sendResponse(
            $response,
            $httpCode
        );
    }


    /**
     * @param FormInterface $form
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function sendResponseFormError(FormInterface $form)
    {
        $errors = $this->getErrors($form);

        if (($form->getData() == null || $form->isEmpty()) && empty($target)) {
            array_unshift($errors, ['message' => $this->get('translator')->trans('Form is empty')]);
        }

        if (empty($errors)) {
            $errors[] = 'invalid form!';
        }

        return $this->sendResponseError(implode('\n ', $errors), Codes::HTTP_BAD_REQUEST);
    }

    /**
     * @param FormInterface $form
     * @param string        $target
     *
     * @return array
     */
    protected function getErrors(FormInterface $form, $target = '')
    {
        $errors = array();
        $translator = $this->get('translator');

        $formErrorIterator = $form->getErrors();
        foreach ($formErrorIterator as $error) {
            if (!empty($target)) {
                $message = $translator->trans($error->getMessage(), $error->getMessageParameters());
                $errors[] = $message; //. 'target: '. $target;
            }
        }
        foreach ($form->all() as $key => $child) {
            $errors = array_merge($errors, $this->getErrors($child, (empty($target) ? '' : $translator->trans($target, [], 'target_names').', ').$key));
        }

        return $errors;
    }

}
