<?php

declare(strict_types=1);

namespace src;

use src\Broadcast\BroadcastComparator;
use src\Explore\ExploreComparator;
use src\ParentClasses\Comparator;
use src\VOD\VODComparator;

require __DIR__ . '/ParentClasses/Comparator.php';

/**
 * Classe `Controller` pour orchestrer la comparaison entre différents types de programmes.
 *
 * Cette classe permet de coordonner les comparateurs de types de programmes (Broadcast, Explore, VOD),
 * de gérer les données surfacées, et d'enregistrer les journaux des résultats.
 */
class Controller
{
    /**
     * Comparateur pour les programmes de type Broadcast.
     *
     * @var Comparator
     */
    private Comparator $broadcastComparator;

    /**
     * Comparateur pour les programmes de type Explore.
     *
     * @var Comparator
     */
    private Comparator $exploreComparator;

    /**
     * Comparateur pour les programmes de type VOD.
     *
     * @var Comparator
     */
    private Comparator $vODComparator;

    /**
     * Données surfacées utilisées dans les comparateurs.
     *
     * @var array
     */
    private array $surfacingData;

    /**
     * Nombre total d'erreurs détectées lors des comparaisons.
     *
     * @var int
     */
    private int $totalErrors;

    /**
     * Constructeur de la classe Controller.
     *
     * Initialise les comparateurs pour les différents types de programmes.
     */
    public function __construct()
    {
        $this->broadcastComparator=new BroadcastComparator();
        $this->exploreComparator=new ExploreComparator();
        $this->vODComparator=new VODComparator();
    }

    /**
     * Récupère le nombre total d'erreurs détectées.
     *
     * @return int Le nombre total d'erreurs.
     */
    public function getTotalErrors(): int
    {
        return $this->totalErrors;
    }

    /**
     * Définit les données surfacées pour les comparateurs.
     *
     * Cette méthode doit être implémentée pour assembler, décoder ou récupérer
     * les données nécessaires aux comparateurs.
     *
     * @return void
     */
    public function setSurfacingData(): void
    {
        // Simulation: On récupère les données surfacées depuis un fichier local.
        // Cette méthode devra être complétée pour une récupération en ligne.
    }

    /**
     * Effectue les comparaisons en utilisant les données surfacées.
     *
     * Charge les programmes dans les comparateurs, exécute les comparaisons,
     * génère les journaux, et calcule le nombre d'erreurs.
     *
     * @return void
     */
    public function control(): void
    {
        // Charge les programmes dans les comparateurs
        $this->broadcastComparator->setPrograms($this->surfacingData);
        $this->exploreComparator->setPrograms($this->surfacingData);
        $this->vODComparator->setPrograms($this->surfacingData);

        // Exécute les comparaisons
        $this->broadcastComparator->compare();
        $this->exploreComparator->compare();
        $this->vODComparator->compare();

        // Enregistre les journaux
        $this->saveLogs();

        // Calcule le nombre total d'erreurs
        $this->totalErrors=$this->broadcastComparator->getErrors() +
            $this->exploreComparator->getErrors() +
            $this->vODComparator->getErrors();
    }

    /**
     * Enregistre les journaux des résultats dans un répertoire spécifique.
     *
     * Crée un sous-répertoire dans le dossier "Logs" avec une date et une heure,
     * et y enregistre les journaux générés par chaque comparateur.
     *
     * @return void
     */
    public function saveLogs(): void
    {
        $directoryName=dirname(__DIR__) . '/Logs/Test(' . date('Y-m-d H:i:s') . ')';
        mkdir($directoryName, 0755);
        $this->broadcastComparator->log($directoryName);
        $this->exploreComparator->log($directoryName);
        $this->vODComparator->log($directoryName);
    }
}