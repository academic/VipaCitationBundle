<?php

namespace BulutYazilim\AdvancedCitationBundle\Helper;

use Doctrine\Common\Persistence\ObjectManager;
use GuzzleHttp\Client;
use Ojs\JournalBundle\Entity\Article;
use Ojs\JournalBundle\Entity\Citation;
use BulutYazilim\AdvancedCitationBundle\Entity\AdvancedCitation;
use Symfony\Component\PropertyAccess\PropertyAccess;

class AdvancedCitationHelper
{
    public static function prepareAdvancedCitations($raw, Article $article, ObjectManager $entityManager)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $explodeCitationsRaw = array_filter(explode("\n",$raw));

        if (!empty($explodeCitationsRaw)) {
            $rowCounter = 1;

            foreach ($explodeCitationsRaw as $citationRaw) {

                $citation = new Citation();
                $citation->setOrderNum($rowCounter);
                $citation->setRaw($citationRaw);
                $article->addCitation($citation);

                $entityManager->persist($citation);
                $rowCounter++;
            }
        }
    }

    public static function prepareAdvancedCitation(Citation $citation, AdvancedCitation $advancedCitation = null)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $client = new Client(['base_uri' => 'http://parser.dergipark.gov.tr']);
        $response = $client->request('GET', '/', ['query' => ['q' => $citation->getRaw()]]);

        if ($response->getStatusCode() == 200) {
            $json = $response->getBody()->getContents();
            $decodedCitation = json_decode($json, true);
            $parsedCitation = null;

            if (!empty($decodedCitation)) {
                $parsedCitation = $decodedCitation[0][1];
            } else if (!empty($citation->getRaw())) {
                $explodeCitation = explode(',', $citation->getRaw());
                $parsedCitation['author'] = $explodeCitation[0];
                $parsedCitation['title'] = $explodeCitation[1];
                $parsedCitation['pages'] = $explodeCitation[2];
                $parsedCitation['editor'] = $explodeCitation[3];
                $parsedCitation['publisher'] = $explodeCitation[4];
                $parsedCitation['location'] = $explodeCitation[5];
                $parsedCitation['language'] = $explodeCitation[6];
                $parsedCitation['type'] = $citation->getType();
            }

            if ($advancedCitation == null) {
                $advancedCitation = new AdvancedCitation();
            }

            $citation->setType(!empty($parsedCitation['type']) ? AdvancedCitationHelper::handleField($parsedCitation['type']) : null);
            $advancedCitation->setCitation($citation);
            $advancedCitation->setCitationRaw($citation->getRaw());
            if(is_array($parsedCitation)){
                foreach($parsedCitation as $citationField => $citationFieldValue){
                    $handleField = AdvancedCitationHelper::handleField($citationFieldValue);
                    if($accessor->isWritable($advancedCitation, $citationField)){
                        $accessor->setValue($advancedCitation, $citationField, $handleField);
                    }
                }
            }

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
