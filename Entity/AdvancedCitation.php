<?php

namespace OkulBilisim\AdvancedCitationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ojs\JournalBundle\Entity\Citation;

/**
 * @ORM\Entity
 * @ORM\Table(name="advanced_citation")
 */
class AdvancedCitation
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Citation
     * @ORM\OneToOne(targetEntity="Ojs\JournalBundle\Entity\Citation")
     * @ORM\JoinColumn(name="citation_id", referencedColumnName="id")
     */
    private $citation;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $author;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $editor;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $pages;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $publisher;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $location;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $language;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $address;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $annote;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $booktitle;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $chapter;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $crossref;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $edition;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $eprint;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $howpublished;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $key;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $month;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $note;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $number;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $organization;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $school;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $series;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $url;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $volume;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $year;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $journal;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Citation
     */
    public function getCitation()
    {
        return $this->citation;
    }

    /**
     * @param Citation $citation
     * @return AdvancedCitation
     */
    public function setCitation($citation)
    {
        $this->citation = $citation;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return AdvancedCitation
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return AdvancedCitation
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * @param string $editor
     * @return AdvancedCitation
     */
    public function setEditor($editor)
    {
        $this->editor = $editor;
        return $this;
    }

    /**
     * @return string
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param string $pages
     * @return AdvancedCitation
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param string $publisher
     * @return AdvancedCitation
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return AdvancedCitation
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return AdvancedCitation
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return AdvancedCitation
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return AdvancedCitation
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getAnnote()
    {
        return $this->annote;
    }

    /**
     * @param string $annote
     * @return AdvancedCitation
     */
    public function setAnnote($annote)
    {
        $this->annote = $annote;
        return $this;
    }

    /**
     * @return string
     */
    public function getBooktitle()
    {
        return $this->booktitle;
    }

    /**
     * @param string $booktitle
     * @return AdvancedCitation
     */
    public function setBooktitle($booktitle)
    {
        $this->booktitle = $booktitle;
        return $this;
    }

    /**
     * @return string
     * @return AdvancedCitation
     */
    public function getChapter()
    {
        return $this->chapter;
    }

    /**
     * @param string $chapter
     * @return AdvancedCitation
     */
    public function setChapter($chapter)
    {
        $this->chapter = $chapter;
        return $this;
    }

    /**
     * @return string
     */
    public function getCrossref()
    {
        return $this->crossref;
    }

    /**
     * @param string $crossref
     * @return AdvancedCitation
     */
    public function setCrossref($crossref)
    {
        $this->crossref = $crossref;
        return $this;
    }

    /**
     * @return string
     */
    public function getEdition()
    {
        return $this->edition;
    }

    /**
     * @param string $edition
     * @return AdvancedCitation
     */
    public function setEdition($edition)
    {
        $this->edition = $edition;
        return $this;
    }

    /**
     * @return string
     */
    public function getEprint()
    {
        return $this->eprint;
    }

    /**
     * @param string $eprint
     * @return AdvancedCitation
     */
    public function setEprint($eprint)
    {
        $this->eprint = $eprint;
        return $this;
    }

    /**
     * @return string
     */
    public function getHowpublished()
    {
        return $this->howpublished;
    }

    /**
     * @param string $howpublished
     * @return AdvancedCitation
     */
    public function setHowpublished($howpublished)
    {
        $this->howpublished = $howpublished;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return AdvancedCitation
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param string $month
     * @return AdvancedCitation
     */
    public function setMonth($month)
    {
        $this->month = $month;
        return $this;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     * @return AdvancedCitation
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return AdvancedCitation
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param string $organization
     * @return AdvancedCitation
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
        return $this;
    }

    /**
     * @return string
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * @param string $school
     * @return AdvancedCitation
     */
    public function setSchool($school)
    {
        $this->school = $school;
        return $this;
    }

    /**
     * @return string
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * @param string $series
     * @return AdvancedCitation
     */
    public function setSeries($series)
    {
        $this->series = $series;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return AdvancedCitation
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param string $volume
     * @return AdvancedCitation
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
        return $this;
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param string $year
     * @return AdvancedCitation
     */
    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return string
     */
    public function getJournal()
    {
        return $this->journal;
    }

    /**
     * @param string $journal
     * @return AdvancedCitation
     */
    public function setJournal($journal)
    {
        $this->journal = $journal;
        return $this;
    }

    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    function __toString()
    {
        $properties = [
            $this->getAuthor(),
            $this->getTitle(),
            $this->getPages(),
            $this->getEditor(),
            $this->getPublisher(),
            $this->getLocation(),
            $this->getLanguage(),
            $this->getAddress(),
            $this->getAnnote(),
            $this->getBooktitle(),
            $this->getChapter(),
            $this->getCrossref(),
            $this->getEdition(),
            $this->getEprint(),
            $this->getHowpublished(),
            $this->getAnnote(),
            $this->getKey(),
            $this->getYear(),
            $this->getUrl(),
            $this->getSeries(),
            $this->getMonth(),
            $this->getNote(),
            $this->getOrganization(),
            $this->getSchool(),
            $this->getVolume()
        ];

        $properties = array_filter($properties);

        if (count($properties)>0) {
            return implode(',', $properties);
        }

        return '';
    }
}