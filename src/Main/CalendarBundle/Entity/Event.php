<?php
namespace Main\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Main\BaseBundle\Entity\DataSetterTrait;

/**
 * @ORM\Entity(repositoryClass="Main\CalendarBundle\Repository\EventRepository")
 * @ORM\Table(name="events")
 * @author Andrei Mocanu
 */
class Event
{
    use DataSetterTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="smallint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $title;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
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
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date->format('Y-m-d');
    }

    /**
     * @param string|\DateTime $date
     * @return $this
     */
    public function setDate($date)
    {
        if (!$date instanceof \DateTime) {
            $date = new \DateTime($date);
        }
        $this->date = $date;

        return $this;
    }
}