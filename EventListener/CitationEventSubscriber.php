<?php

namespace BulutYazilim\AdvancedCitationBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Ojs\CoreBundle\Events\TypeEvent;
use Ojs\JournalBundle\Event\Article\ArticleEvents;
use Ojs\JournalBundle\Event\CitationEditEvent;
use Ojs\JournalBundle\Event\CitationEvents;
use BulutYazilim\AdvancedCitationBundle\Form\Type\ArticleSubmissionType;
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
            CitationEvents::CITATION_EDIT => 'onEditViewRequested',
            ArticleEvents::INIT_SUBMIT_FORM => 'onSubmissionFormRequested',
        );
    }

    public function onEditViewRequested(CitationEditEvent $editEvent)
    {
        $parameters = [
            'id' => $editEvent->getCitationId(),
            'articleId' => $editEvent->getArticleId(),
            'journalId' => $editEvent->getJournalId()
        ];

        $url = $this->router->generate('bulutyazilim_advancedcitation_edit', $parameters);
        $editEvent->setResponse(new RedirectResponse($url, 302));
    }

    public function onSubmissionFormRequested(TypeEvent $event)
    {
        $event->setType(new ArticleSubmissionType($this->manager));
    }
}
