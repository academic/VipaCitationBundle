<?php
/**
 * Created by PhpStorm.
 * User: akyuz
 * Date: 22/12/2016
 * Time: 23:12
 */

namespace Ojs\CitationBundle\Controller;

use Ojs\CitationBundle\Form\Type\ExtraCitationSubmissionType;
use Ojs\CitationBundle\Helper\ExtraCitationHelper;
use Ojs\CoreBundle\Controller\OjsController;
use Ojs\JournalBundle\Entity\Article;
use Ojs\JournalBundle\Entity\Citation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExtraCitationController extends OjsController
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
            'OjsCitationBundle:Citation:advanced_citations_form.html.twig',
            [
                'form' => $form->createView(),
                'dummyItemCount' => $dummyItemCount
            ]
        );
    }
}
