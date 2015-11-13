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
     * @ORM\Column(type="text", nullable=true)
     */
    private $author;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $editor;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $pages;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $publisher;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $location;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $language;

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
            $this->getLanguage()
        ];

        $properties = array_filter($properties);

        if (!empty($properties)) {
            return implode(',');
        }

        return '';
    }
}