<?php

namespace Main\CalendarBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author Andrei Mocanu
 */
class EventRepository extends EntityRepository
{
    /**
     * Find all events between dates
     *
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array
     */
    public function findAllBetweenDates(\DateTime $startDate, \DateTime $endDate)
    {
        $qb = $this->createQueryBuilder('e');
        return $qb
            ->where($qb->expr()->between('e.date', ':startDate', ':endDate'))
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getResult();
    }
}