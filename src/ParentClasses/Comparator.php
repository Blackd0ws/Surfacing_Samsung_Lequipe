<?php

declare(strict_types=1);

namespace src\ParentClasses;

use src\Broadcast\Classes\BroadcastPrograms;
use src\Explore\Classes\ExplorePrograms;
use src\VOD\Classes\VODPrograms;

require_once __DIR__ . '/../ParentClasses/Programs.php';
require_once __DIR__ . '/../ParentClasses/SurfacingPrograms.php';

/**
 * Classe abstraite Comparator.
 *
 * Fournit une structure pour comparer des programmes surfacés avec des programmes existants.
 *
 * Cette classe est conçue pour être étendue avec des implémentations spécifiques
 * pour les comparaisons des différents types de programmes.
 * @package ParentClasses
 */
abstract class Comparator
{
    /**
     * Liste principale des programmes à comparer.
     *
     * @var Programs Instance contenant les programmes de la plateforme.
     */
    protected Programs $programs;

    /**
     * Liste des programmes surfacés à comparer.
     *
     * @var SurfacingPrograms Instance contenant les programmes surfacés.
     */
    protected SurfacingPrograms $sPrograms;

    /**
     * Nombre d'erreurs lors de la comparaison.
     *
     * @var int
     */
    protected int $errors=0;

    /**
     * Effectue la comparaison entre les programmes surfacés et les programmes existants.
     *
     * Méthode abstraite à implémenter dans les classes dérivées pour définir
     * une logique spécifique de comparaison.
     *
     * @return void
     */
    abstract public function compare(): void;

    /**
     * Gère l'enregistrement des résultats de la comparaison dans un dossier de logs.
     *
     * Méthode abstraite à implémenter dans les classes dérivées.
     *
     * @param string $directoryName Nom du dossier où enregistrer les logs.
     *
     * @return void
     */
    abstract public function log(string $directoryName): void;

    /**
     * Définit les programmes surfacés utilisés dans la comparaison.
     *
     * Méthode abstraite à implémenter dans les classes dérivées.
     *
     * @param array $surfacing Données des programmes surfacés.
     *
     * @return void
     */
    abstract public function setPrograms(array $surfacing): void;

    /**
     * Retourne le nombre d'erreurs survenues lors de la comparaison.
     *
     * @return int Le nombre d'erreurs.
     */
    public function getErrors(): int
    {
        return $this->errors;
    }

    /**
     * Récupère les programmes EQP (Enhanced Quality Programs) en fonction du type de programmes.
     *
     * Traite les programmes en fonction de leur type spécifique (Broadcast, Explore ou VOD).
     *
     * @return array Tableau contenant les programmes EQP.
     */
    public function getEQPPrograms(): array
    {
        $eqpPrograms=[];
        if ($this->programs instanceof BroadcastPrograms) {
            // Traitement spécifique pour les programmes de diffusion
        } else if ($this->programs instanceof ExplorePrograms) {
            // Traitement spécifique pour les programmes d'exploration
        } else if ($this->programs instanceof VODPrograms) {
            // Traitement spécifique pour les programmes VOD
        }

        /*
         * Cas possible : gestion des erreurs liées aux fichiers JSON.
         * Exemple :
         *
         * if (!file_exists($filePath)) {
         *     echo "<div class='error'>Erreur : Fichier introuvable - $filePath</div><br>";
         *     return [];
         * }
         *
         * $jsonContent = file_get_contents($filePath);
         * if ($jsonContent === false) {
         *     echo "<div class='error'>Erreur : Impossible de lire le fichier - $filePath</div><br>";
         *     return [];
         * }
         *
         * $data = json_decode($jsonContent, true);
         * if ($data === null) {
         *     echo "<div class='error'>Erreur : Impossible de décoder le JSON - $filePath</div><br>";
         *     return [];
         * }
         */

        return $eqpPrograms;
    }
}