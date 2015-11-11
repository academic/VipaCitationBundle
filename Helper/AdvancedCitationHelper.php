<?php

namespace OkulBilisim\AdvancedCitationBundle\Helper;

use GuzzleHttp\Client;
use Ojs\JournalBundle\Entity\Citation;
use OkulBilisim\AdvancedCitationBundle\Entity\AdvancedCitation;

class AdvancedCitationHelper
{
    public static function prepareAdvancedCitation(Citation $entity, AdvancedCitation $advancedCitation = null)
    {
        $client = new Client(['base_uri' => 'http://parser.dergipark.gov.tr']);
        $response = $client->request('GET', '/', ['query' => ['q' => $entity->getRaw()]]);

        if ($response->getStatusCode() == 200) {
            $json = $response->getBody()->getContents();
            $parsedCitation = json_decode($json, true)[0][1];

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