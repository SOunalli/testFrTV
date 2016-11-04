<?php
/**
 * Created by PhpStorm.
 * User: SOunalli
 * Date: 04/11/2016
 * Time: 10:00
 */

namespace FranceTV\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as REST;
use FOS\RestBundle\Util\Codes;
use FranceTV\ApiBundle\Entity\Article;
use FranceTV\ApiBundle\Form\Api\ArticleType;

use FranceTV\ApiBundle\Model\Api\MessageContainer;
use FranceTV\ApiBundle\Model\Api\MessageContent;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class ArticleController.
 *
 * @REST\RouteResource("Article")
 */
class ArticleController extends AbstractApiController
{
    /**
     * Renvoie la liste des articles.
     *
     * @REST\Get("articles")
     *
     * @ApiDoc(
     *     section="1) Article",
     *     tags={ "done"="#10A54A" },
     *     statusCodes={
     *         200="Ok",
     *         500="NOK, Server error"
     *     },
     *     responseMap={
     *        200="array<FranceTV\ApiBundle\Entity\Article>",
     *        500="FranceTV\ApiBundle\Model\Api\MessageContainer"
     *     }
     *  )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cgetAction(Request $request)
    {
        $articles = $this->getDoctrine()->getRepository("FranceTVApiBundle:Article")->findAll();

        return $this->sendResponseSuccess($articles);
    }

    /**
     * Renvoie un article en fonction de son slug .
     *
     * @REST\Get("article/{slug}")
     *
     * @ApiDoc(
     *     description="get article",
     *     section="1) Article",
     *     tags={ "done"="#10A54A" },
     *     statusCodes={
     *         200="Ok",
     *         404="E > Aucune fiche aide trouvée.",
     *         500="NOK, Server error"
     *     },
     *     requirements={
     *          {"name"="slug","dataType"="string","description"="the artlicle's slug"}
     *     },
     *     responseMap={
     *        200="FranceTV\ApiBundle\Entity\Article",
     *        404="FranceTV\ApiBundle\Model\Api\MessageContainer",
     *        500="FranceTV\ApiBundle\Model\Api\MessageContainer"
     *     }
     *  )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction($slug)
    {
        $article = $this->getDoctrine()->getRepository("FranceTVApiBundle:Article")->findOneBy(['slug' => $slug]);

        if (!$article instanceof Article) {
            return $this->sendResponseError("Article not found", Codes::HTTP_NOT_FOUND);
        }

        return $this->sendResponseSuccess($article);
    }

    /**
         * Permet de créer un article.
     *
     * @ApiDoc(
     *     description="créer un article",
     *     section="1) Article",
     *     tags={ "done"="#10A54A" },
     *     statusCodes={
     *         200="Ok",
     *         400="Form Error",
     *         500="NOK, Server error"
     *     },
     *     input={"class"="FranceTV\ApiBundle\Form\Api\ArticleType"},
     *     responseMap={
     *        200="FranceTV\ApiBundle\Entity\Article",
     *        400="FranceTV\ApiBundle\Model\Api\MessageContainer",
     *        500="FranceTV\ApiBundle\Model\Api\MessageContainer"
     *     }
     *  )
     *
     * @REST\Post("articles")
     *
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Request $request)
    {
        $article  = new Article();
        $form = $this->createForm(new ArticleType(), $article);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($article);

            $em->flush();

            return $this->sendResponseSuccess($article);

        } else {
            return $this->sendResponseFormError($form);
        }
    }

    /**
     * Supprime un article en fonction de son slug .
     *
     * @REST\Delete("article/{slug}")
     *
     * @ApiDoc(
     *     description="remove article",
     *     section="1) Article",
     *     tags={ "done"="#10A54A" },
     *     statusCodes={
     *         200="Ok",
     *         404="E > Aucune fiche aide trouvée.",
     *         500="NOK, Server error"
     *     },
     *     requirements={
     *          {"name"="slug","dataType"="string","description"="the artlicle's slug"}
     *     },
     *     responseMap={
     *        200="FranceTV\ApiBundle\Model\Api\MessageContainer",
     *        404="FranceTV\ApiBundle\Model\Api\MessageContainer",
     *        500="FranceTV\ApiBundle\Model\Api\MessageContainer"
     *     }
     *  )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($slug)
    {
        $article = $this->getDoctrine()->getRepository("FranceTVApiBundle:Article")->findOneBy(['slug' => $slug]);

        if (!$article instanceof Article) {
            return $this->sendResponseError("Article not found", Codes::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($article);

        $em->flush();

        $response = [
            'message' => ["type" => "S", "text" => "Article successfully deleted"],
        ];

        return $this->sendResponseSuccess($response);
    }
}