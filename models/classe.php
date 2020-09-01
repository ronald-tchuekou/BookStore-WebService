<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

/**
 * Class classe
 */
class Classe
{
  
    /**
     * classe constructor.
     * @param int $id
     * @param string $name
     * @param string $libelle
     * @param string $cycle
     */
    public function setData(int $id, string $name, string $libelle, string $cycle)
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