<?php

namespace Ojs\CitationBundle\Tests\Controller;

class ExtraCitationControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testFreeCite(){
        $url="http://freecite.library.brown.edu/citations/create";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"citation= Udvarhelyi, I.S.,
         Gatsonis, C.A., Epstein, A.M., Pashos, C.L., Newhouse, J.P. and McNeil, B.J. 
         Acute Myocardial Infarction in the Medicare population: process of care and 
         clinical outcomes. Journal of the American Medical Association, 1992; 18:2530-2536.");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: text/xml"));
        $head = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $simple = $head;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $simple, $vals, $index);
        xml_parser_free($p);
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

        $parsedCitation['author'] = substr($parsedCitation['author'],0,sizeof($parsedCitation['author'])-6);
        $string = "I S Udvarhelyi and C A Gatsonis and A M Epstein and C L Pashos and J P Newhouse and B J McNeil";
        self::assertEquals("Acute Myocardial Infarction in the Medicare population: process of care and\nclinical outcomes",$parsedCitation["title"]);
        self::assertEquals($string,$parsedCitation['author']);
        self::assertEquals("2530--2536",$parsedCitation["pages"]);
        self::assertEquals("1992",$parsedCitation["year"]);
        self::assertEquals("Journal of the American Medical Association",$parsedCitation["journal"]);
        self::assertEquals("18",$parsedCitation["volume"]);
    }
    public function testDOI(){
        $url = "http://api.crossref.org/works?query=Acute+Myocardial+Infarction+in+the+Medicare+population&rows=1";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $head = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $doi_element = json_decode($head);
        $parsedCitation = $doi_element->{"message"}->{"items"}[0]->{"DOI"};

        self::assertEquals("10.1001/jama.1992.03490180062027",$parsedCitation);


    }

}