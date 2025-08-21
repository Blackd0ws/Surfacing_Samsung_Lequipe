<?php

declare(strict_types=1);

namespace src\Broadcast;

use src\Broadcast\Classes\BroadcastPrograms;
use src\ParentClasses\Comparator;
use src\Surfacing\SurfacingBroadcasts;

require dirname(__DIR__) . '/ParentClasses/Comparator.php';

/**
 * Classe permettant de comparer des programmes de diffusion ("Broadcast").
 *
 * Cette classe hérite de Comparator et implémente la logique spécifique pour comparer
 * des programmes existants avec des programmes surfacés.
 * @package Broadcast
 */
class BroadcastComparator extends Comparator
{
    /**
     * Liste des programmes sans correspondance sur le titre.
     *
     * @var array
     */
    private array $noTitleMatch=[];

    /**
     * Liste des programmes sans correspondance sur la date.
     *
     * @var array
     */
    private array $noDateMatch=[];

    /**
     * Liste des programmes sans correspondance sur le fournisseur (provider).
     *
     * @var array
     */
    private array $noProviderMatch=[];

    /**
     * Liste des programmes sans correspondance sur la description.
     *
     * @var array
     */
    private array $noDescriptionMatch=[];

    /**
     * Constructeur de la classe BroadcastComparator.
     * Initialise les programmes et les programmes surfacés.
     */
    public function __construct()
    {
        $this->programs=new BroadcastPrograms();
        $this->sPrograms=new SurfacingBroadcasts();
    }

    /**
     * Compare les programmes existants avec les programmes surfacés.
     *
     * Analyse les correspondances entre les titres, les dates, les fournisseurs et les descriptions.
     * Les programmes sans correspondance sont ajoutés aux listes d'erreurs respectives.
     *
     * @return void
     */
    public function compare(): void
    {
        foreach ($this->programs->getPrograms() as $program) {
            $titleMatch=false;
            $dateMatch=false;
            $providerMatch=false;
            $descriptionMatch=false;
            $compteur=0;

            foreach ($this->sPrograms->getPrograms() as $sProgram) {
                if (str_contains($program->getTitle(), $sProgram->getTitle())) {
                    $titleMatch=true;
                    $compteur++;
                    if (
                        (BroadcastPrograms::normalizeDate($program->getStartDate()) == BroadcastPrograms::normalizeDate($sProgram->getStartDate())) &&
                        (BroadcastPrograms::normalizeDate($program->getEndDate()) == BroadcastPrograms::normalizeDate($sProgram->getEndDate()))
                    ) {
                        $dateMatch=true;
                        if ($program->getProvider() === $sProgram->getProvider()) {
                            $providerMatch=true;
                            if ($program->getDescription() === $sProgram->getDescription()) {
                                $descriptionMatch=true;
                            }
                            if ($compteur == 2) {
                                break;
                            }
                        }
                    }
                }
            }

            if (!$titleMatch) {
                $this->noTitleMatch[]=$program;
                $this->errors++;
            } elseif (!$dateMatch) {
                $this->noDateMatch[]=$program;
                $this->errors++;
            } elseif (!$providerMatch) {
                $this->noProviderMatch[]=$program;
                $this->errors++;
            } elseif (!$descriptionMatch) {
                $this->noDescriptionMatch[]=$program;
                $this->errors++;
            }
        }
    }

    /**
     * Configure les listes de programmes existants et surfacés à comparer.
     *
     * @param array $surfacing Données des programmes surfacés.
     *
     * @return void
     */
    public function setPrograms(array $surfacing): void
    {
        $this->programs->setPrograms(parent::getEQPPrograms());
        $this->sPrograms->setPrograms($surfacing);
    }

    /**
     * Retourne la liste des programmes sans correspondance sur le titre.
     *
     * @return array Liste des programmes.
     */
    public function getNoTitleMatch(): array
    {
        return $this->noTitleMatch;
    }

    /**
     * Retourne la liste des programmes sans correspondance sur la date.
     *
     * @return array Liste des programmes.
     */
    public function getNoDateMatch(): array
    {
        return $this->noDateMatch;
    }

    /**
     * Retourne la liste des programmes sans correspondance sur le fournisseur.
     *
     * @return array Liste des programmes.
     */
    public function getNoProviderMatch(): array
    {
        return $this->noProviderMatch;
    }

    /**
     * Retourne la liste des programmes sans correspondance sur la description.
     *
     * @return array Liste des programmes.
     */
    public function getNoDescriptionMatch(): array
    {
        return $this->noDescriptionMatch;
    }

    /**
     * Enregistre les résultats de la comparaison dans un fichier de journalisation.
     *
     * Crée un fichier texte dans le répertoire spécifié et détaille les programmes sans correspondance.
     *
     * @param string $directoryName Nom du répertoire où enregistrer le fichier de journalisation.
     *
     * @return void
     */
    public function log(string $directoryName): void
    {
        $Logs=fopen($directoryName . "/BroadcastLogs.txt", "c");
        fwrite($Logs, "Programmes dont aucun titre ne correspond:\n");
        foreach ($this->getNoTitleMatch() as $unknown) {
            fwrite($Logs, $unknown . "\n");
        }
        fwrite($Logs, "\nProgrammes dont aucune date ne correspond:\n");
        foreach ($this->getNoDateMatch() as $unknown) {
            fwrite($Logs, $unknown . "\n");
        }
        fwrite($Logs, "\nProgrammes dont aucun provider_id ne correspond:\n");
        foreach ($this->getNoProviderMatch() as $unknown) {
            fwrite($Logs, $unknown . "\n");
        }
        fwrite($Logs, "\nProgrammes dont aucune description ne correspond:\n");
        foreach ($this->getNoDescriptionMatch() as $unknown) {
            fwrite($Logs, $unknown . "\n");
        }
        fclose($Logs);
    }
}