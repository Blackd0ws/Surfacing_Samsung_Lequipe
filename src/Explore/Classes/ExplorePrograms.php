<?php

declare(strict_types=1);

namespace src\Explore\Classes;

use src\ParentClasses\Programs;

require_once __DIR__ . '/../../ParentClasses/Programs.php';
require_once __DIR__ . '/../../ParentClasses/Program.php';

/**
 * Classe représentant une collection de programmes d'exploration ("Explore").
 *
 * Cette classe hérite de la classe `Programs` et permet d'ajouter des programmes
 * spécifiques d'exploration à partir de données structurées.
 * @package Explore
 * @subpackage Classes
 */
class ExplorePrograms extends Programs
{
    /**
     * Constructeur de la classe ExplorePrograms.
     * Initialise la collection de programmes en appelant le constructeur parent.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Définit et ajoute les programmes dans la collection à partir des données fournies.
     *
     * Parcourt les données données dans un format spécifique, extrait les informations
     * des programmes et les ajoute à la collection après les avoir instanciés.
     *
     * @param array $data Tableau contenant les données des programmes.
     *                    Les données attendues doivent inclure les clés :
     *                    - `hits.hits`: Contient les programmes.
     *                    - Chaque programme doit avoir :
     *                      - `_id`: Identifiant du programme.
     *                      - `_source`: Contenant `title`, `description`,
     *                        `broadcast_start_date`, et `broadcast_end_date`.
     *
     * @return void
     */
    public function setPrograms(array $data): void
    {
        if ($data != null) {
            foreach ($data['hits']['hits'] as $program) {
                if (isset($program['_id']) && isset($program['_source'])) {
                    try {
                        $this->addProgram(new ExploreProgram(
                            $program['_id'],
                            $program['_source']['title'],
                            $program['_source']['description'],
                            new DateTime($program['_source']['broadcast_start_date']),
                            new DateTime($program['_source']['broadcast_end_date'])
                        ));
                    } catch (Exception $e) {
                        echo $e->getTraceAsString();
                    }
                }
            }
        }
    }
}