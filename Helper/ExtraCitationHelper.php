<?php

namespace Ojs\CitationBundle\Helper;

use Doctrine\Common\Persistence\ObjectManager;
use Ojs\JournalBundle\Entity\Article;
use Ojs\JournalBundle\Entity\Citation;
use Ojs\CitationBundle\Entity\AdvancedCitation;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ExtraCitationHelper
{
    public static function prepareExtraCitations($raw, Article $article, ObjectManager $entityManager)
    {
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

    private static function handleField($field)
    {
        if (is_array($field)) {
            return implode(',', $field);
        }

        return $field;
    }

    public static function prepareExtraCitation(Citation $citation, AdvancedCitation $extraCitation = null)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $parsedCitation = array();
        $parsedCitation['author'] = "";
        $parsedCitation['title'] = "";
        $parsedCitation['pages'] = "";
        $parsedCitation['editor'] = "";
        $parsedCitation['publisher'] = "";
        $parsedCitation['location'] = "";
        $parsedCitation['language'] = "";
        $parsedCitation['type'] = "";
        $parsedCitation['crossref'] = "";

        $url="http://freecite.library.brown.edu/citations/create";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"citation= ".$citation->getRaw());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: text/xml"));
        $head = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $simple = $head;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $simple, $vals, $index);
        xml_parser_free($p);

        foreach($vals as $key => $value)
        {
            if($value["tag"]=="TITLE")
            {
                $doi_urlencode = urlencode($value["value"]);
                $parsedCitation['title'] = $value["value"];
            }
            if($value["tag"]=="AUTHOR")
            {
                $parsedCitation['author'] .= $value["value"]." and ";
            }
            if($value["tag"]=="PAGES")
            {
                $parsedCitation['pages'] = $value["value"];
            }
            if($value["tag"]=="YEAR")
            {
                $parsedCitation['year'] = $value["value"];
            }
            if($value["tag"]=="RFT:STITLE")
            {
                $parsedCitation['journal'] = $value["value"];
            }
            if($value["tag"]=="VOLUME")
            {
                $parsedCitation['volume'] = $value["value"];
            }
            if($value["tag"]=="type")
            {
                $parsedCitation['volume'] = $value["value"];
            }

        }

        if(isset($doi_urlencode)) {
            $url = "http://api.crossref.org/works?query=" . $doi_urlencode . "&rows=1";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $head = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            $doi_element = json_decode($head);
            $parsedCitation['editor'] = "";
            $parsedCitation['publisher'] = $doi_element->{"message"}->{"items"}[0]->{"publisher"};
            $parsedCitation['location'] = "";
            $parsedCitation['language'] = "";
            $parsedCitation['type'] = $doi_element->{"message"}->{"items"}[0]->{"type"};
            $parsedCitation['crossref'] = $doi_element->{"message"}->{"items"}[0]->{"DOI"};
        }

        if ($extraCitation == null) {
            $extraCitation = new AdvancedCitation();
        }
        $parsedCitation['editor'] = "anaammm";
        $extraCitation->setType(!empty($parsedCitation['type']) ? ExtraCitationHelper::handleField($parsedCitation['type']) : null);
        $extraCitation->setCitation($citation);
        $extraCitation->setCitationRaw($citation->getRaw());

        if(is_array($parsedCitation)){
            foreach($parsedCitation as $citationField => $citationFieldValue){
                $handleField = ExtraCitationHelper::handleField($citationFieldValue);
                if($accessor->isWritable($extraCitation, $citationField)){
                    $accessor->setValue($extraCitation, $citationField, $handleField);
                }
                if($citationField == 'date' && !in_array('year', $parsedCitation)){
                    $accessor->setValue($extraCitation, 'year', $handleField);
                }
            }
        }

        return $extraCitation;
    }


}

