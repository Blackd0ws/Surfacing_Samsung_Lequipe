<?php

declare(strict_types=1);

namespace src\Surfacing;

use src\ParentClasses\Program;

require_once __DIR__ . '/../ParentClasses/Program.php';
/**
 * @package Surfacing
 */
class SurfExplore extends Program
{
    private DateTime $startDate;
    private DateTime $endDate;
    private string $description;

    public function __construct(int $id, string $title, DateTime $startDate, DateTime $endDate, string $description)
    {
        $this->id=$id;
        $this->title=$title;
        $this->startDate=$startDate;
        $this->endDate=$endDate;
        $this->description=$description;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function toString(): string
    {
        return sprintf(
            "ID: %d\nTitle: %s\nStart Date: %s\nEnd Date: %s\nDescription: %s",
            $this->id,
            $this->title,
            $this->startDate->format('Y-m-d H:i:s'),
            $this->endDate->format('Y-m-d H:i:s'),
            $this->description
        );
    }
}