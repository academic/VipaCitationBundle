<?php

namespace OkulBilisim\AdvancedCitationBundle\Controller;

use Ojs\CoreBundle\Controller\OjsController;
use Ojs\JournalBundle\Entity\Article;
use Ojs\JournalBundle\Entity\Citation;
use OkulBilisim\AdvancedCitationBundle\Entity\AdvancedCitation;
use OkulBilisim\AdvancedCitationBundle\Form\Type\AdvancedCitationType;
use OkulBilisim\AdvancedCitationBundle\Form\Type\ArticleSubmissionType;
use OkulBilisim\AdvancedCitationBundle\Helper\AdvancedCitationHelper;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdvancedCitationController extends OjsController
{
    /**
     * @param int $id
     * @param int $articleId
     * @return Response
     */
    public function editAction($id, $articleId)
    {
        $journal = $this->get('ojs.journal_service')->getSelectedJournal();
        $this->throw404IfNotFound($journal);

        if (!$this->isGranted('EDIT', $journal, 'articles')) {
            throw new AccessDeniedException("You not authorized for this page!");
        }

        $em = $this->getDoctrine()->getManager();
        $entity = $em
            ->getRepository('AdvancedCitationBundle:AdvancedCitation')
            ->findOneBy(['citation' => $id]);

        if(!$entity){
            $entity = $this->setupAdvancedCitation($id);
        }

        $editForm = $this->createEditForm($entity, $articleId);

        return $this->render(
            'OjsJournalBundle:Citation:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
            )
        );
    }

    /**
     * Edits an existing Citation entity.
     *
     * @param Request $request
     * @param $id
     * @param integer $articleId
     * @return RedirectResponse|Response
     */
    public function updateAction(Request $request, $id, $articleId)
    {
        $journal = $this->get('ojs.journal_service')->getSelectedJournal();
        $this->throw404IfNotFound($journal);

        if (!$this->isGranted('EDIT', $journal, 'articles')) {
            throw new AccessDeniedException("You not authorized for this page!");
        }

        $em = $this->getDoctrine()->getManager();
        $entity = $em
            ->getRepository('AdvancedCitationBundle:AdvancedCitation')
            ->findOneBy(['citation' => $id]);

        if (!$entity) {
            $entity = $this->setupAdvancedCitation($id);
        }

        $editForm = $this->createEditForm($entity, $articleId);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $params = array('id' => $id, 'journalId' => $journal->getId(), 'articleId' => $articleId);
            $url = $this->generateUrl('okulbilisim_advancedcitation_edit', $params);
            return $this->redirect($url);
        }

        return $this->render(
            'OjsJournalBundle:Citation:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a Citation entity.
     *
     * @param AdvancedCitation $entity The entity
     * @param int $articleId Citation's Article's ID
     *
     * @return Form The form
     */
    private function createEditForm(AdvancedCitation $entity, $articleId)
    {
        $id = $entity->getCitation()->getId();
        $journal = $this->get('ojs.journal_service')->getSelectedJournal();
        $params = array('id' => $id, 'journalId' => $journal->getId(), 'articleId' => $articleId);
        $action = $this->generateUrl('okulbilisim_advancedcitation_update', $params);

        $form = $this->createForm(
            new AdvancedCitationType(),
            $entity,
            array(
                'action' => $action,
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    public function citationsToFormAction(Request $request)
    {
        $rawCitations = $request->get('rawCitations');
        $dummyItemCount = $request->get('itemCount')+5;
        $article = new Article();
        foreach(range(1,$dummyItemCount) as $count){
            $article->addCitation(new Citation());
        }
        $em = $this->getDoctrine()->getManager();
        AdvancedCitationHelper::prepareAdvancedCitations($rawCitations, $article, $em);
        $form = $this->createForm(
            new ArticleSubmissionType($em),
            $article
        );
        return $this->render(
            'AdvancedCitationBundle:AdvancedCitation:advanced_citations_form.html.twig',
            [
                'form' => $form->createView(),
                'dummyItemCount' => $dummyItemCount
            ]
        );
    }

    /**
     * @param $citationId
     * @return AdvancedCitation
     */
    private function setupAdvancedCitation($citationId)
    {
        $em = $this->getDoctrine()->getManager();
        $citation = $em->getRepository('OjsJournalBundle:Citation')->find($citationId);
        $prepareAdvancedCitation = AdvancedCitationHelper::prepareAdvancedCitation($citation, null);
        $em->persist($prepareAdvancedCitation);
        $em->flush();
        return $prepareAdvancedCitation;
    }
}
