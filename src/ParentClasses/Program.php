<?php

declare(strict_types=1);

namespace src\ParentClasses;
/**
 * Classe abstraite représentant un programme de base.
 * Cette classe sert de modèle pour différents types de programmes (VOD, Broadcast, Explore).
 * @package ParentClasses
 */
abstract class Program
{
    /**
     * Identifiant unique du programme
     *
     * @var int
     */
    protected int $id;

    /**
     * Titre du programme
     *
     * @var string
     */
    protected string $title;

    /**
     * Récupère l'identifiant du programme
     *
     * @return int L'identifiant unique du programme
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Récupère le titre du programme
     *
     * @return string Le titre du programme
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}