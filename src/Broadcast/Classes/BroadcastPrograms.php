<?php

declare(strict_types=1);

namespace src\Broadcast\Classes;

use src\ParentClasses\Programs;

require_once __DIR__ . '/../../ParentClasses/Programs.php';

/**
 * Classe représentant une collection de programmes de diffusion.
 *
 * Cette classe hérite de Programs et ajoute des fonctionnalités spécifiques
 * pour gérer les programmes de diffusion.
 * @package Broadcast
 * @subpackage Classes
 */
class BroadcastPrograms extends Programs
{
    /**
     * Constructeur de la classe BroadcastPrograms.
     * Initialise la liste des programmes en appelant le constructeur parent.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Normalise une date fournie en chaîne de caractères en instance de DateTime.
     *
     * Accepte une date au format "YYYY-MM-DDTHH:MM:SS" ou "YYYY-MM-DD HH:MM:SS" et retourne une instance DateTime.
     *
     * @param string $dateString Chaîne contenant une date au format valide.
     *
     * @return DateTime Instance DateTime correspondant à la date normalisée.
     */
    public static function normalizeDate(string $dateString): DateTime
    {
        if (str_contains($dateString, 'T')) {
            return new DateTime($dateString);
        } else {
            return DateTime::createFromFormat('Y-m-d H:i:s', $dateString);
        }
    }

    /**
     * Définit les programmes en fonction des données fournies.
     *
     * Parcourt les données reçues, valide les informations nécessaires pour chaque élément,
     * et ajoute les programmes valides à la liste interne.
     *
     * @param array $data Tableau de données contenant les informations des programmes.
     *                    Chaque élément doit inclure les clés suivantes :
     *                      - 'id' : Identifiant du programme.
     *                      - 'title' : Titre du programme.
     *                      - 'start_date' : Date de début (format string).
     *                      - 'end_date' : Date de fin (format string).
     *                      - 'provider_id' : Identifiant du fournisseur.
     *                      - 'description' : Description du programme.
     *                      - 'image_url' : URL de l'image associée au programme.
     *
     * @return void
     */
    public function setPrograms(array $data): void
    {
        foreach ($data as $item) {
            if (isset($item['id'], $item['title'], $item['start_date'], $item['end_date'], $item['provider_id'], $item['description'], $item['image_url'])) {
                $this->addProgram(new BroadcastProgram(
                    (int)$item['id'],
                    $item['title'],
                    $this->normalizeDate($item['start_date']),
                    $this->normalizeDate($item['end_date']),
                    $item['description'],
                    $item['provider_id']
                ));
            }
        }
        $this->filterPrograms();
    }

    /**
     * Filtre les programmes pour ne conserver que ceux qui sont diffusés dans les 28 prochaines heures.
     *
     * Parcourt la liste des programmes et supprime ceux qui ne respectent pas le critère.
     *
     * @return void
     */
    public function filterPrograms(): void
    {
        foreach ($this->programs as $key=>$broadcast) {
            if (!$broadcast->isIn28Hours()) {
                unset($this->programs[$key]);
            }
        }
    }
}