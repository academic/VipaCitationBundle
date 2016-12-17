<?php

namespace Ojs\CitationBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Ojs\CoreBundle\Events\TypeEvent;
use Ojs\JournalBundle\Event\Article\ArticleEvents;
use Ojs\JournalBundle\Event\CitationEditEvent;
use Ojs\JournalBundle\Event\CitationEvents;
use Ojs\CitationBundle\Form\Type\ArticleSubmissionType;
use Ojs\JournalBundle\Event\CitationNewEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class CitationEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * CitationEventSubscriber constructor.
     * @param Router $router
     * @param EntityManager $manager
     */
    public function __construct(Router $router, EntityManager $manager)
    {
        $this->router = $router;
        $this->manager = $manager;
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            CitationEvents::CITATION_NEW => 'onNewViewRequested',
            CitationEvents::CITATION_EDIT => 'onEditViewRequested',
            ArticleEvents::INIT_SUBMIT_FORM => 'onSubmissionFormRequested',
        );
    }

    public function onNewViewRequested(CitationNewEvent $editEvent)
    {
        $parameters = [
            'articleId' => $editEvent->getArticleId(),
            'journalId' => $editEvent->getJournalId()
        ];

        $url = $this->router->generate('ojs_citation_new', $parameters);
        $editEvent->setResponse(new RedirectResponse($url, 302));
    }

    public function onEditViewRequested(CitationEditEvent $editEvent)
    {
        $parameters = [
            'id' => $editEvent->getCitationId(),
            'articleId' => $editEvent->getArticleId(),
            'journalId' => $editEvent->getJournalId()
        ];

        $url = $this->router->generate('ojs_citation_edit', $parameters);
        $editEvent->setResponse(new RedirectResponse($url, 302));
    }

    public function onSubmissionFormRequested(TypeEvent $event)
    {
        $event->setType(new ArticleSubmissionType($this->manager));
    }
}
