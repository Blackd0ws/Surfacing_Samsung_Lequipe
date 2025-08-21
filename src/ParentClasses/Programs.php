<?php

declare(strict_types=1);

namespace src\ParentClasses;

/**
 * Classe abstraite représentant une collection de programmes.
 *
 * Cette classe fournit une structure pour stocker, ajouter, et gérer des programmes.
 * Les classes qui héritent de celle-ci doivent implémenter la méthode `setPrograms`.
 * @package ParentClasses
 */
abstract class Programs
{
    /**
     * Liste des programmes.
     *
     * @var Program[] Tableau contenant les instances des programmes.
     */
    protected array $programs;

    /**
     * Constructeur de la classe Programs.
     * Initialise la liste des programmes à un tableau vide.
     */
    public function __construct()
    {
        $this->programs=[];
    }

    /**
     * Ajoute un programme à la liste des programmes.
     *
     * @param Program $program Le programme à ajouter.
     *
     * @return void
     */
    protected function addProgram(Program $program): void
    {
        $this->programs[]=$program;
    }

    /**
     * Renvoie les données JSON sous forme de tableau associatif.
     *
     * @param string $jsonDoc Document JSON à convertir en tableau.
     *
     * @return array|null Tableau associatif contenant les données JSON ou null en cas d'erreur.
     */
    protected function getData(string $jsonDoc)
    {
        return json_decode($jsonDoc, true);
    }

    /**
     * Définit les programmes en fonction des données fournies.
     *
     * Méthode abstraite devant être implémentée par les classes dérivées.
     *
     * @param array $data Tableau de données permettant d'initaliser les programmes.
     *
     * @return void
     */
    abstract function setPrograms(array $data): void;

    /**
     * Récupère la liste des programmes.
     *
     * @return Program[] Tableau contenant les programmes.
     */
    public function getPrograms(): array
    {
        return $this->programs;
    }

    /**
     * Génère une représentation textuelle de la liste des programmes.
     *
     * @return string Chaîne contenant les représentations textuelles des programmes, séparées par des retours à la ligne.
     */
    public function __toString(): string
    {
        $items=[];
        foreach ($this->programs as $program) {
            $items[]=$program->__toString();
        }
        return implode("\n", $items);
    }
}