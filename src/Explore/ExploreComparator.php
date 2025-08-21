<?php /** @noinspection ALL */

declare(strict_types=1);

namespace src\Explore;

use src\Explore\Classes\ExplorePrograms;
use src\ParentClasses\Comparator;
use src\Surfacing\SurfacingExplores;

require dirname(__DIR__) . '/ParentClasses/Comparator.php';

/**
 * Classe permettant de comparer des programmes d'exploration ("Explore").
 *
 * Cette classe hérite de Comparator et implémente la logique spécifique pour comparer
 * des programmes existants avec des programmes surfacés.
 * @package Explore
 */
class ExploreComparator extends Comparator
{
    /**
     * Liste des programmes avec un identifiant non correspondant.
     *
     * @var array
     */
    private array $unknownId=[];

    /**
     * Liste des programmes avec un titre non correspondant.
     *
     * @var array
     */
    private array $unknownTitle=[];

    /**
     * Liste des programmes avec une description non correspondante.
     *
     * @var array
     */
    private array $unknownDescription=[];

    /**
     * Liste des programmes avec une date non correspondante.
     *
     * @var array
     */
    private array $unknownDate=[];

    /**
     * Constructeur de la classe ExploreComparator.
     * Initialise les programmes et les programmes surfacés.
     */
    public function __construct()
    {
        $this->programs=new ExplorePrograms();
        $this->sPrograms=new SurfacingExplores();
    }

    /**
     * Récupère la liste des programmes avec un identifiant non correspondant.
     *
     * @return array Liste des programmes non correspondants.
     */
    public function getUnknownId(): array
    {
        return $this->unknownId;
    }

    /**
     * Récupère la liste des programmes avec un titre non correspondant.
     *
     * @return array Liste des programmes non correspondants.
     */
    public function getUnknownTitle(): array
    {
        return $this->unknownTitle;
    }

    /**
     * Récupère la liste des programmes avec une description non correspondante.
     *
     * @return array Liste des programmes non correspondants.
     */
    public function getUnknownDescription(): array
    {
        return $this->unknownDescription;
    }

    /**
     * Récupère la liste des programmes avec une date non correspondante.
     *
     * @return array Liste des programmes non correspondants.
     */
    public function getUnknownDate(): array
    {
        return $this->unknownDate;
    }

    /**
     * Compare les programmes existants avec les programmes surfacés.
     *
     * Analyse les correspondances entre les identifiants, les titres, les descriptions et les dates.
     * Les programmes sans correspondance sont ajoutés aux listes d'erreurs respectives.
     *
     * @return void
     */
    function compare(): void
    {
        foreach ($this->sPrograms->getPrograms() as $sProgram) {
            $idMatch=false;
            $titleMatch=false;
            $descriptionMatch=false;
            $dateMatch=false;

            foreach ($this->programs->getPrograms() as $program) {
                if ($program->getId() == $sProgram->getId()) {
                    $idMatch=true;
                    if (
                        $sProgram->getStartDate()->format('Y-m-d H:i:s') == $program->getStartDate()->format('Y-m-d H:i:s') &&
                        $sProgram->getEndDate()->format('Y-m-d H:i:s') == $program->getEndDate()->format('Y-m-d H:i:s')
                    ) {
                        $dateMatch=true;
                        if ($sProgram->getTitle() == $program->getTitle()) {
                            $titleMatch=true;
                            if ($sProgram->getDescription() == $program->getDescription()) {
                                $descriptionMatch=true;
                                break;
                            } else {
                                $this->unknownDescription[]=$sProgram;
                                $this->errors++;
                            }
                        } else {
                            $this->unknownTitle[]=$sProgram;
                            $this->errors++;
                        }
                    } else {
                        $this->unknownDate[]=$sProgram;
                        $this->errors++;
                    }
                }
            }
            if (!$idMatch) {
                $this->unknownId[]=$sProgram;
                $this->errors++;
            }
        }
    }

    /**
     * Enregistre les résultats de la comparaison dans un fichier de journalisation.
     *
     * Crée un fichier texte dans le répertoire spécifié et détaille les programmes
     * sans correspondance selon différentes catégories (Ids, Titres, Dates, Descriptions).
     *
     * @param string $directoryName Nom du répertoire où enregistrer le fichier de journalisation.
     *
     * @return void
     */
    function log(string $directoryName): void
    {
        $Logs=fopen($directoryName . "/ExploreLogs.txt", "c");

        fwrite($Logs, "=== Programmes aux Ids absents ===\n\n");
        foreach ($this->getUnknownId() as $unknown) {
            fwrite($Logs, $unknown . "\n");
        }

        fwrite($Logs, "\n\n=== Programmes aux Dates Différentes ===\n\n");
        foreach ($this->getUnknownDate() as $unknown) {
            fwrite($Logs, $unknown . "\n");
        }

        fwrite($Logs, "\n\n=== Programmes aux Titres Différents ===\n\n");
        foreach ($this->getUnknownTitle() as $unknown) {
            fwrite($Logs, $unknown . "\n");
        }

        fwrite($Logs, "\n\n=== Programmes aux Descriptions Différentes ===\n\n");
        foreach ($this->getUnknownDescription() as $unknown) {
            fwrite($Logs, $unknown . "\n");
        }

        fclose($Logs);
    }

    /**
     * Configure les listes de programmes existants et surfacés à comparer.
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