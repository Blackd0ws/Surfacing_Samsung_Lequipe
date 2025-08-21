<?php

namespace src\Surfacing;

use src\ParentClasses\Program;

require_once __DIR__ . '/../ParentClasses/Program.php';
/**
 * @package Surfacing
 */
class SurfVOD extends Program
{
    public function __construct(int $id, string $title)
    {
        $this->id=$id;
        $this->title=$title;
    }

    public function __toString(): string
    {
        return sprintf('SurfVOD(id: %d, title: %s)', $this->id, $this->title);
    }
}