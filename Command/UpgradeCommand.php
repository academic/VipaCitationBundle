<?php

namespace OkulBilisim\AdvancedCitationBundle\Command;

use Doctrine\ORM\EntityManager;
use OkulBilisim\AdvancedCitationBundle\Entity\AdvancedCitation;
use OkulBilisim\AdvancedCitationBundle\Helper\AdvancedCitationHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpgradeCommand extends ContainerAwareCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('ojs:advanced-citation:upgrade')
            ->setDescription('Upgrades already existing citations to advanced ones')
        ;
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @param InputInterface $input An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int null or 0 if everything went fine, or an error code
     *
     * @throws \LogicException When this abstract method is not implemented
     *
     * @see setCode()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $citations = $entityManager->getRepository('OjsJournalBundle:Citation')->findAll();

        $index = 0;

        foreach ($citations as $citation) {
            $advancedCitation = $entityManager
                ->getRepository('AdvancedCitationBundle:AdvancedCitation')
                ->findOneBy(['citation' => $citation]);

            if (!$advancedCitation) {
                $output->writeln('Upgrading citation #' . $citation->getId());
                $advancedCitation = AdvancedCitationHelper::prepareAdvancedCitation($citation);
                $entityManager->persist($advancedCitation);

                if ($index % 10 == 0) {
                    $output->writeln('Saving...');
                    $entityManager->flush();
                }
            }

            $index++;
        }

        $entityManager->flush();
    }

}