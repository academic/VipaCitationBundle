<?php

namespace OkulBilisim\AdvancedCitationBundle\EventListener;

use Ojs\JournalBundle\Service\JournalService;
use Ojs\JournalBundle\Event\MenuEvent;
use Ojs\JournalBundle\JournalEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LeftMenuListener implements EventSubscriberInterface
{
    /** @var  JournalService */
    private $journalService;

    /**
     * LeftMenuListener constructor.
     * @param JournalService $journalService
     */
    public function __construct(JournalService $journalService)
    {
        $this->journalService = $journalService;
    }


    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            JournalEvents::LEFT_MENU_INITIALIZED => 'onLeftMenuInitialized',
        );
    }

    /**
     * @param MenuEvent $menuEvent
     */
    public function onLeftMenuInitialized(MenuEvent $menuEvent)
    {
        $journal = $this->journalService->getSelectedJournal();
        $journalId = $journal->getId();

        $menuItem = $menuEvent->getMenuItem();
        $menuItem->addChild(
            'Bootstrap Menu',
            [
                'route' => 'okulbilisim_advanced_citation_default_index',
                'routeParameters' => ['journalId' => $journalId, 'name' => 'OJS'],
                'extras' => ['icon' => '']
            ]
        );
    }

}
