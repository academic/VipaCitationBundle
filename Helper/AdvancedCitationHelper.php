<?php

namespace OkulBilisim\AdvancedCitationBundle\Helper;

use Doctrine\Common\Persistence\ObjectManager;
use GuzzleHttp\Client;
use Ojs\JournalBundle\Entity\Article;
use Ojs\JournalBundle\Entity\Citation;
use OkulBilisim\AdvancedCitationBundle\Entity\AdvancedCitation;

class AdvancedCitationHelper
{
    public static function prepareAdvancedCitations($raw, Article $article, ObjectManager $entityManager)
    {
        $client = new Client(['base_uri' => 'http://parser.dergipark.gov.tr']);
        $response = $client->request('GET', '/', ['query' => ['q' => $raw]]);
        $decoded = json_decode($response->getBody()->getContents(), true);


        if (!empty($decoded)) {
            $rowCounter = 1;

            foreach ($decoded as $row) {
                $parsedCitation = $row[1];
                $rawCitation = $row[2];

                $citation = new Citation();
                $citation->setOrderNum($rowCounter);
                $citation->setRaw(!empty($rawCitation['raw']) ? AdvancedCitationHelper::handleField($rawCitation['raw']) : null);
                $citation->setType(!empty($parsedCitation['type']) ? AdvancedCitationHelper::handleField($parsedCitation['type']) : null);
                $article->addCitation($citation);

                $advancedCitation = new AdvancedCitation();
                $advancedCitation
                    ->setCitation($citation)
                    ->setAuthor(!empty($parsedCitation['author']) ? AdvancedCitationHelper::handleField($parsedCitation['author']) : null)
                    ->setTitle(!empty($parsedCitation['title']) ? AdvancedCitationHelper::handleField($parsedCitation['title']) : null)
                    ->setEditor(!empty($parsedCitation['editor']) ? AdvancedCitationHelper::handleField($parsedCitation['editor']) : null)
                    ->setPages(!empty($parsedCitation['pages']) ? AdvancedCitationHelper::handleField($parsedCitation['pages']) : null)
                    ->setPublisher(!empty($parsedCitation['publisher']) ? AdvancedCitationHelper::handleField($parsedCitation['publisher']) : null)
                    ->setLocation(!empty($parsedCitation['location']) ? AdvancedCitationHelper::handleField($parsedCitation['location']) : null)
                    ->setType(!empty($parsedCitation['type']) ? AdvancedCitationHelper::handleField($parsedCitation['type']) : null)
                    ->setLanguage(!empty($parsedCitation['language']) ? AdvancedCitationHelper::handleField($parsedCitation['language']) : null);

                $entityManager->persist($citation);
                $entityManager->persist($advancedCitation);
                $rowCounter++;
            }
        }
    }

    public static function parseRawCitations($rawCitations)
    {
        $client = new Client(['base_uri' => 'http://parser.dergipark.gov.tr']);
        $response = $client->request('GET', '/', ['query' => ['q' => $rawCitations]]);
        $decoded = json_decode($response->getBody()->getContents(), true);
        $advancedCitationEntities = [];

        if (!empty($decoded)) {
            $rowCounter = 1;

            foreach ($decoded as $row) {
                $parsedCitation = $row[1];
                $rawCitation = $row[2];

                $citation = new Citation();
                $citation->setOrderNum($rowCounter);
                $citation->setRaw(!empty($rawCitation['raw']) ? AdvancedCitationHelper::handleField($rawCitation['raw']) : null);
                $citation->setType(!empty($parsedCitation['type']) ? AdvancedCitationHelper::handleField($parsedCitation['type']) : null);

                $advancedCitation = new AdvancedCitation();
                $advancedCitation
                    ->setCitation($citation)
                    ->setAuthor(!empty($parsedCitation['author']) ? AdvancedCitationHelper::handleField($parsedCitation['author']) : null)
                    ->setTitle(!empty($parsedCitation['title']) ? AdvancedCitationHelper::handleField($parsedCitation['title']) : null)
                    ->setEditor(!empty($parsedCitation['editor']) ? AdvancedCitationHelper::handleField($parsedCitation['editor']) : null)
                    ->setPages(!empty($parsedCitation['pages']) ? AdvancedCitationHelper::handleField($parsedCitation['pages']) : null)
                    ->setPublisher(!empty($parsedCitation['publisher']) ? AdvancedCitationHelper::handleField($parsedCitation['publisher']) : null)
                    ->setLocation(!empty($parsedCitation['location']) ? AdvancedCitationHelper::handleField($parsedCitation['location']) : null)
                    ->setType(!empty($parsedCitation['type']) ? AdvancedCitationHelper::handleField($parsedCitation['type']) : null)
                    ->setLanguage(!empty($parsedCitation['language']) ? AdvancedCitationHelper::handleField($parsedCitation['language']) : null);

                $entityManager->persist($citation);
                $entityManager->persist($advancedCitation);
                $advancedCitationEntities[] = $advancedCitation;
            }
        }
        return $advancedCitationEntities;
    }

    public static function prepareAdvancedCitation(Citation $entity, AdvancedCitation $advancedCitation = null)
    {
        $client = new Client(['base_uri' => 'http://parser.dergipark.gov.tr']);
        $response = $client->request('GET', '/', ['query' => ['q' => $entity->getRaw()]]);

        if ($response->getStatusCode() == 200) {
            $json = $response->getBody()->getContents();
            $decoded = json_decode($json, true);
            $parsedCitation = null;

            if (!empty($decoded)) {
                $parsedCitation = $decoded[0][1];
            } else if (!empty($entity->getRaw())) {
                $raw = explode(',', $entity->getRaw());
                $parsedCitation['author'] = $raw[0];
                $parsedCitation['title'] = $raw[1];
                $parsedCitation['pages'] = $raw[2];
                $parsedCitation['editor'] = $raw[3];
                $parsedCitation['publisher'] = $raw[4];
                $parsedCitation['location'] = $raw[5];
                $parsedCitation['language'] = $raw[6];
                $parsedCitation['type'] = $entity->getType();
            }

            if ($advancedCitation === null) {
                $advancedCitation = new AdvancedCitation();
            }

            $advancedCitation
                ->setCitation($entity)
                ->setAuthor(!empty($parsedCitation['author']) ? AdvancedCitationHelper::handleField($parsedCitation['author']) : null)
                ->setTitle(!empty($parsedCitation['title']) ? AdvancedCitationHelper::handleField($parsedCitation['title']) : null)
                ->setEditor(!empty($parsedCitation['editor']) ? AdvancedCitationHelper::handleField($parsedCitation['editor']) : null)
                ->setPages(!empty($parsedCitation['pages']) ? AdvancedCitationHelper::handleField($parsedCitation['pages']) : null)
                ->setPublisher(!empty($parsedCitation['publisher']) ? AdvancedCitationHelper::handleField($parsedCitation['publisher']) : null)
                ->setLocation(!empty($parsedCitation['location']) ? AdvancedCitationHelper::handleField($parsedCitation['location']) : null)
                ->setType(!empty($parsedCitation['type']) ? AdvancedCitationHelper::handleField($parsedCitation['type']) : null)
                ->setLanguage(!empty($parsedCitation['language']) ? AdvancedCitationHelper::handleField($parsedCitation['language']) : null);

            return $advancedCitation;
        }

        return null;
    }

    private static function handleField($field)
    {
        if (is_array($field)) {
            return implode(',', $field);
        }

        return $field;
    }
}