<?php

declare(strict_types=1);

namespace src\Surfacing;

use src\ParentClasses\Program;

require_once __DIR__ . '/../ParentClasses/Program.php';
/**
 * @package Surfacing
 */
class SurfBroadcast extends Program
{
    public function __construct(string $title, private DateTime $startDate, private DateTime $endDate, private string $video_id, private string $description)
    {
        $this->id=0;
        $this->title=$title;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    public function getVideoId(): string
    {
        return $this->video_id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isIn28Hours(): bool
    {
        $currentTime=new DateTime();
        $limitTime=(clone $currentTime)->add(new DateInterval('PT28H'));
        return (($this->startDate >= ($currentTime->format('Y-m-d H:i:s'))) && ($this->endDate <= ($limitTime->format('Y-m-d H:i:s'))));
    }

    public function __toString(): string
    {
        return sprintf(
            "Broadcast: %s\nStart: %s\nEnd: %s\nVideo ID: %s\nDescription: %s",
            $this->title,
            $this->startDate->format('Y-m-d H:i:s'),
            $this->endDate->format('Y-m-d H:i:s'),
            $this->video_id,
            $this->description
        );
    }
}