<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 04/11/2016
 * Time: 10:50
 */

namespace FranceTV\ApiBundle\Controller\Doc;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ApiDocController extends Controller
{
    /**
     * @Route("", name="nelmio_api_doc_index")
     *
     * @param string $view
     *
     * @return Response
     */
    public function indexAction($view = ApiDoc::DEFAULT_VIEW)
    {
        $extractedDoc = $this->get('nelmio_api_doc.extractor.api_doc_extractor')->all($view);
        $htmlContent = $this->get('nelmio_api_doc.formatter.html_formatter')->format($extractedDoc);

        return new Response($htmlContent, 200, array('Content-Type' => 'text/html'));
    }
}