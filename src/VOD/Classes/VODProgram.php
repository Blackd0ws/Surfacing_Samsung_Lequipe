<?php

declare(strict_types=1);

namespace src\VOD\Classes;

use src\ParentClasses\Program;

require_once __DIR__ . '/../../ParentClasses/Program.php';

/**
 * Classe représentant un programme VOD (Video On Demand).
 *
 * Cette classe hérite de la classe `Program` et ajoute les propriétés
 * spécifiques telles que l'identifiant et le titre d'un programme VOD.
 * @package VOD
 * @subpackage Classes
 */
class VODProgram extends Program
{
    /**
     * Constructeur de la classe VODProgram.
     * Initialise les propriétés du programme VOD.
     *
     * @param int $id Identifiant unique du programme.
     * @param string $title Titre du programme.
     */
    public function __construct(int $id, string $title)
    {
        $this->id=$id;
        $this->title=$title;
    }
}