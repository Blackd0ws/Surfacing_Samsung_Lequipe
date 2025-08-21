<?php

declare(strict_types=1);

namespace src\VOD;

use src\ParentClasses\Comparator;
use src\Surfacing\SurfacingVOD;
use src\VOD\Classes\VODPrograms;

require dirname(__DIR__) . '/ParentClasses/Comparator.php';

/**
 * Classe `VODComparator` pour comparer une liste de programmes VOD (Video On Demand)
 * avec une liste de programmes surfacés.
 *
 * Cette classe hérite de la classe `Comparator` et ajoute des fonctionnalités spécifiques
 * pour identifier les programmes VOD sans correspondance ainsi que les doublons.
 * @package VOD
 */
class VODComparator extends Comparator
{
    /**
     * Liste des programmes surfacés sans correspondance dans les programmes VOD.
     *
     * @var array
     */
    private array $noTitleMatch=[];

    /**
     * Liste des programmes surfacés qui apparaissent en doublon.
     *
     * @var array
     */
    private array $isDuplicate=[];

    /**
     * Constructeur de la classe VODComparator.
     *
     * Initialise les listes des programmes à comparer en instanciant
     * des objets `VODPrograms` et `SurfacingVOD`.
     */
    public function __construct()
    {
        $this->programs=new VODPrograms();
        $this->sPrograms=new SurfacingVOD();
    }

    /**
     * Compare les programmes surfacés avec les programmes VOD.
     *
     * Identifie les programmes sans correspondance (`noTitleMatch`) ainsi que
     * les programmes en doublon (`isDuplicate`) dans les listes surfacées.
     *
     * @return void
     */
    function compare(): void
    {
        foreach ($this->sPrograms as $sProgram) {
            $noTitleMatch=false;
            foreach ($this->programs as $program) {
                if ($program->getId() == $sProgram->getId()) {
                    $noTitleMatch=true;
                    break;
                }
            }
            if (!$noTitleMatch) {
                $this->noTitleMatch[]=$sProgram;
                $this->errors++;
            }

            // Recherche les doublons
            $compteur=0;
            foreach ($this->sPrograms as $program) {
                if ($program->getId() == $sProgram->getId()) {
                    $compteur++;
                }
            }
            if ($compteur > 1) {
                $this->isDuplicate[]=$sProgram;
                $this->errors++;
            }
        }
    }

    /**
     * Génère un fichier de log avec les programmes sans correspondance et les doublons.
     *
     * @param string $directoryName Chemin du répertoire dans lequel le fichier de log sera créé.
     *
     * @return void
     */
    function log(string $directoryName): void
    {
        $Logs=fopen($directoryName . "/VODLogs.txt", "c");
        fwrite($Logs, "=== Programmes aux Ids manquants ===\n\n");
        foreach ($this->noTitleMatch as $unknown) {
            fwrite($Logs, $unknown . "\n");
        }
        fwrite($Logs, "\n\n=== Programmes aux Doublons ===\n\n");
        foreach ($this->isDuplicate as $duplicated) {
            fwrite($Logs, $duplicated . "\n");
        }
    }

    /**
     * Définit les programmes VOD et les programmes surfacés à comparer.
     *
     * Charge les programmes à comparer en utilisant les données existantes.
     *
     * @param array $surfacing Données des programmes surfacés.
     *
     * @return void
     */
    function setPrograms(array $surfacing): void
    {
        $this->programs->setPrograms(parent::getEQPPrograms());
        $this->sPrograms->setPrograms($surfacing);
    }
}