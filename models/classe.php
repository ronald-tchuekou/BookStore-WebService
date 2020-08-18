<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */
namespace models;
/**
 * Class classe
 */
class Classe
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $libelle;
    /**
     * @var string
     */
    private $cycle;

    /**
     * classe constructor.
     * @param int $id
     * @param string $name
     * @param string $libelle
     * @param string $cycle
     */
    public function __construct($id, $name, $libelle, $cycle)
    {
        $this->id = $id;
        $this->name = $name;
        $this->libelle = $libelle;
        $this->cycle = $cycle;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * @return string
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * @param string $cycle
     */
    public function setCycle($cycle)
    {
        $this->cycle = $cycle;
    }

}