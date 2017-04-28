<?php
/**
 * Created by PhpStorm.
 * User: akyuz
 * Date: 22/12/2016
 * Time: 23:12
 */

namespace Vipa\CitationBundle\Controller;

use Vipa\CitationBundle\Form\Type\ExtraCitationSubmissionType;
use Vipa\CitationBundle\Helper\ExtraCitationHelper;
use Vipa\CoreBundle\Controller\VipaController;
use Vipa\JournalBundle\Entity\Article;
use Vipa\JournalBundle\Entity\Citation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExtraCitationController extends VipaController
{
    /**
     * Parses citation using Freecite
     * @param int $articleId
     * @return Response
     */
    public function parseAction(Request $request)
    {
        $rawCitations = $request->get('rawCitations');
        $dummyItemCount = $request->get('itemCount')+5;
        $article = new Article();
        foreach(range(1,$dummyItemCount) as $count){
            $article->addCitation(new Citation());
        }
        $em = $this->getDoctrine()->getManager();
        ExtraCitationHelper::prepareExtraCitations($rawCitations, $article, $em);
        $form = $this->createForm(
            new ExtraCitationSubmissionType($em),
            $article
        );
        return $this->render(
            'VipaCitationBundle:Citation:advanced_citations_form.html.twig',
            [
                'form' => $form->createView(),
                'dummyItemCount' => $dummyItemCount
            ]
        );
    }
}
