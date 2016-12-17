<?php

namespace Ojs\AdvancedCitationBundle\Controller;

use Ojs\AdvancedCitationBundle\Entity\AdvancedCitation;
use Ojs\AdvancedCitationBundle\Form\Type\AdvancedCitationType;
use Ojs\AdvancedCitationBundle\Form\Type\ArticleSubmissionType;
use Ojs\AdvancedCitationBundle\Helper\AdvancedCitationHelper;
use Ojs\CoreBundle\Controller\OjsController;
use Ojs\JournalBundle\Entity\Article;
use Ojs\JournalBundle\Entity\Citation;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdvancedCitationController extends OjsController
{
    /**
     * Displays a form to create a new AdvancedCitation entity.
     * @param int $articleId
     * @return Response
     */
    public function newAction($articleId)
    {
        $journal = $this->get('ojs.journal_service')->getSelectedJournal();
        $this->throw404IfNotFound($journal);

        if (!$this->isGranted('EDIT', $journal, 'articles')) {
            throw new AccessDeniedException("You not authorized for this page!");
        }

        $entity = new AdvancedCitation();
        $form = $this->createCreateForm($entity, $articleId);

        $data = [
            'entity' => $entity,
            'form'   => $form->createView(),
        ];

        return $this->render('OjsJournalBundle:Citation:new.html.twig', $data);
    }

    /**
     * Creates a new AdvancedCitation entity.
     * @param Request $request
     * @param Integer $articleId
     * @return Response
     */
    public function createAction(Request $request, $articleId)
    {
        /** @var Article $article */
        $journal = $this->get('ojs.journal_service')->getSelectedJournal();
        $article = $this->getDoctrine()->getRepository('OjsJournalBundle:Article')->find($articleId);

        $this->throw404IfNotFound($journal);
        $this->throw404IfNotFound($article);

        if (!$this->isGranted('EDIT', $journal, 'articles')) {
            throw new AccessDeniedException("You not authorized for this page!");
        }

        $entity = new AdvancedCitation();
        $form = $this->createCreateForm($entity, $articleId);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $citation = new Citation();

            $raw = empty($entity->getCitationRaw())
                ? strval($entity)
                : $entity->getCitationRaw();

            $citation->setRaw($raw);
            $citation->setType($entity->getType());

            $article->getCitations()->add($citation);
            $entity->setCitation($citation);

            $em = $this->getDoctrine()->getManager();
            $em->persist($citation);
            $em->persist($entity);
            $em->persist($article);
            $em->flush();

            $parameters = ['id' => $citation->getId(), 'journalId' => $journal->getId(), 'articleId' => $articleId];
            return $this->redirect($this->generateUrl('ojs_journal_citation_show', $parameters));
        }

        $data = [
            'entity' => $entity,
            'form'   => $form->createView(),
        ];

        return $this->render('OjsJournalBundle:Citation:new.html.twig', $data);
    }

    /**
     * Creates a form to create a Citation entity.
     *
     * @param AdvancedCitation $entity The entity
     * @param Integer $articleId
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AdvancedCitation $entity, $articleId)
    {
        $journal = $this->get('ojs.journal_service')->getSelectedJournal();

        $parameters = ['journalId' => $journal->getId(), 'articleId' => $articleId];
        $action = $this->generateUrl('ojs_advancedcitation_create', $parameters);

        $options = [
            'action' => $action,
            'method' => 'POST',
        ];

        $form = $this->createForm(new AdvancedCitationType(), $entity, $options);
        $form->add('submit', 'submit', ['label' => 'Create']);

        return $form;
    }

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
            throw $this->createNotFoundException('Unable to find AdvancedCitation entity.');
        }

        $editForm = $this->createEditForm($entity, $articleId);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $params = array('id' => $id, 'journalId' => $journal->getId(), 'articleId' => $articleId);
            $url = $this->generateUrl('ojs_advancedcitation_edit', $params);
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
        $action = $this->generateUrl('ojs_advancedcitation_update', $params);

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
