<?php

declare(strict_types=1);

namespace src\VOD\Classes;

use src\ParentClasses\Programs;

require_once __DIR__ . '/../../ParentClasses/Programs.php';

/**
 * Classe représentant une collection de programmes VOD (Video On Demand).
 *
 * Cette classe hérite de la classe `Programs` et fournit des méthodes spécifiques
 * pour gérer des programmes de type VOD.
 * @package VOD
 * @subpackage Classes
 */
class VODPrograms extends Programs
{
    /**
     * Constructeur de la classe VODPrograms.
     *
     * Initialise la collection de programmes en utilisant le constructeur parent.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Définit et ajoute les programmes VOD dans la collection à partir des données fournies.
     *
     * Parcourt les données d'entrée, crée une instance de `VODProgram` pour chaque programme
     * valide, et ajoute les programmes à la collection.
     *
     * @param array $data Tableau contenant les données des programmes.
     *                    Les données attendues doivent inclure les clés :
     *                    - `hits.hits`: Contient la liste des programmes.
     *                    - Chaque programme doit avoir :
     *                      - `_id`: Identifiant du programme.
     *                      - `_source.title`: Titre du programme.
     *
     * @return void
     */
    public function setPrograms(array $data): void
    {
        if ($data != null) {
            foreach ($data['hits']['hits'] as $program) {
                if (isset($program['_id']) && isset($program['_source'])) {
                    $this->addProgram(new VODProgram($program['_id'], $program['_source']['title']));
                }
            }
        }
    }
}