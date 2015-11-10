<?php

namespace OkulBilisim\AdvancedCitationBundle\EventListener;

use Ojs\JournalBundle\Event\CitationEditEvent;
use Ojs\JournalBundle\Event\CitationEvents;
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
     * CitationEventSubscriber constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            CitationEvents::CITATION_EDIT => 'onEditViewRequested',
        );
    }

    public function onEditViewRequested(CitationEditEvent $editEvent)
    {
        $parameters = [
            'id' => $editEvent->getCitationId(),
            'articleId' => $editEvent->getArticleId(),
            'journalId' => $editEvent->getJournalId()
        ];

        $url = $this->router->generate('okulbilisim_advancedcitation_edit', $parameters);
        $editEvent->setResponse(new RedirectResponse($url, 302));
    }
}