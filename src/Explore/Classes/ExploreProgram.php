<?php

declare(strict_types=1);

namespace src\Explore\Classes;
use src\ParentClasses\Program;

require_once __DIR__ . '/../../ParentClasses/Program.php';

/**
 * Classe représentant un programme d'exploration ("Explore").
 *
 * Cette classe hérite de la classe `Program` et ajoute des propriétés spécifiques
 * telles que la description, la date de début et la date de fin.
 * @package Explore
 * @subpackage Classes
 */
class ExploreProgram extends Program
{
    /**
     * Description du programme.
     *
     * @var string
     */
    private string $description;

    /**
     * Date et heure de début de diffusion du programme.
     *
     * @var DateTime
     */
    private DateTime $startDate;

    /**
     * Date et heure de fin de diffusion du programme.
     *
     * @var DateTime
     */
    private DateTime $endDate;

    /**
     * Constructeur de la classe ExploreProgram.
     * Initialise les propriétés du programme d'exploration.
     *
     * @param int $id Identifiant unique du programme.
     * @param string $title Titre du programme.
     * @param string $description Description du programme.
     * @param DateTime $startDate Date et heure du début de diffusion.
     * @param DateTime $endDate Date et heure de fin de diffusion.
     */
    public function __construct(
        int      $id,
        string   $title,
        string   $description,
        DateTime $startDate,
        DateTime $endDate
    )
    {
        $this->id=$id;
        $this->title=$title;
        $this->description=$description;
        $this->startDate=$startDate;
        $this->endDate=$endDate;
    }

    /**
     * Récupère la description du programme.
     *
     * @return string La description du programme.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Récupère la date et l'heure de début de diffusion du programme.
     *
     * @return DateTime La date et l'heure de début.
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * Récupère la date et l'heure de fin de diffusion du programme.
     *
     * @return DateTime La date et l'heure de fin.
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }
}