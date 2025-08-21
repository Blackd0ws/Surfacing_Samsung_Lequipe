<?php

declare(strict_types=1);

namespace src\ParentClasses;

/**
 * Classe abstraite représentant un ensemble de programmes surfacés.
 *
 * Cette classe sert de base pour gérer et manipuler une liste de programmes,
 * permettant d'ajouter, définir ou récupérer ces programmes.
 * @package ParentClasses
 */
abstract class SurfacingPrograms
{
    /**
     * Liste des programmes surfacés.
     *
     * @var Program[] Tableau de programmes.
     */
    protected array $programs;

    /**
     * Constructeur de la classe.
     * Initialise un tableau vide pour les programmes.
     */
    public function __construct()
    {
        $this->programs=[];
    }

    /**
     * Ajoute un programme à la liste des programmes surfacés.
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
     * Définit les programmes surfacés à partir des données fournies.
     *
     * Méthode abstraite devant être implémentée par les classes dérivées.
     *
     * @param array $data Données des programmes à ajouter.
     *
     * @return void
     */
    abstract function setPrograms(array $data): void;

    /**
     * Récupère la liste des programmes surfacés.
     *
     * @return Program[] Tableau contenant les programmes surfacés.
     */
    public function getPrograms(): array
    {
        return $this->programs;
    }

    /**
     * Retourne une représentation textuelle des programmes sous forme de chaîne.
     *
     * @return string Une chaîne formattée représentant tous les programmes.
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