<?php

declare(strict_types=1);

namespace src\Broadcast\Classes;
use src\ParentClasses\Program;

require_once __DIR__ . '/../../ParentClasses/Program.php';

/**
 * Classe représentant un programme de diffusion (Broadcast).
 *
 * Cette classe hérite de la classe abstraite Program et ajoute des attributs spécifiques
 * comme la date de début, la date de fin, la description et l'identifiant de la vidéo.
 * @package Broadcast
 * @subpackage Classes
 */
class BroadcastProgram extends Program
{
    /**
     * Constructeur de la classe BroadcastProgram.
     * Initialise les propriétés du programme de diffusion.
     *
     * @param int $id Identifiant unique du programme.
     * @param string $title Titre du programme.
     * @param DateTime $startDate Date et heure du début de diffusion.
     * @param DateTime $endDate Date et heure de fin de diffusion.
     * @param string $description Description du programme.
     * @param string $video_id Identifiant unique de la vidéo.
     */
    public function __construct(
        int              $id,
        string           $title,
        private DateTime $startDate,
        private DateTime $endDate,
        private string   $description,
        private string   $video_id
    )
    {
        $this->id=$id;
        $this->title=$title;
    }

    /**
     * Récupère la date et l'heure du début de diffusion.
     *
     * @return DateTime La date et l'heure de début.
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * Récupère la date et l'heure de fin de diffusion.
     *
     * @return DateTime La date et l'heure de fin.
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
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
     * Récupère l'identifiant unique de la vidéo associée.
     *
     * @return string L'identifiant de la vidéo.
     */
    public function getVideoId(): string
    {
        return $this->video_id;
    }

    /**
     * Détermine si le programme est diffusé dans les 28 prochaines heures.
     *
     * Compare la date actuelle avec la date de début et de fin du programme.
     *
     * @return bool Retourne true si le programme est diffusé dans les 28 heures, false sinon.
     */
    public function isIn28Hours(): bool
    {
        $currentTime=new DateTime();
        $limitTime=(clone $currentTime)->add(new DateInterval('PT28H'));
        return (($this->startDate >= ($currentTime->format('Y-m-d H:i:s'))) && ($this->endDate <= ($limitTime->format('Y-m-d H:i:s'))));
    }
}