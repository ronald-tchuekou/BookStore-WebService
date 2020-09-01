<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */

/**
 * Class Book
 */
class Book {
   
    /**
     * Book constructor.
     * @param int $id identifiant du liver.
     * @param string $title Titre du liver.
     * @param string $author Auteur du liver.
     * @param string $editor Edition du livre.
     * @param string $image1_front Image du livre.
     * @param string $book_state Etat du liver.
     * @param string $cycle Cycle au quel appartient le liver.
     * @param string $classe classe au quel appartient le liver.
     * @param float $unit_prise Prix unitaire du livre.
     * @param int $stock_quantity Quantité en stocke.
     */
    public function setData(int $id, string $title, string $author, string $editor, string $image1_front, string $book_state, string $cycle, string $classe, float $unit_prise, int $stock_quantity)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->editor = $editor;
        $this->image1_front = $image1_front;
        $this->book_state = $book_state;
        $this->cycle = $cycle;
        $this->classe = $classe;
        $this->unit_prise = $unit_prise;
        $this->stock_quantity = $stock_quantity;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * @param string $editor
     */
    public function setEditor($editor)
    {
        $this->editor = $editor;
    }

    /**
     * @return string
     */
    public function getImage1Front()
    {
        return $this->image1_front;
    }

    /**
     * @param string $image1_front
     */
    public function setImage1Front($image1_front)
    {
        $this->image1_front = $image1_front;
    }

    /**
     * @return string
     */
    public function getBookState()
    {
        return $this->book_state;
    }

    /**
     * @param string $book_state
     */
    public function setBookState($book_state)
    {
        $this->book_state = $book_state;
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

    /**
     * @return string
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * @param string $classe
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;
    }

    /**
     * @return float
     */
    public function getUnitPrise()
    {
        return $this->unit_prise;
    }

    /**
     * @param float $unit_prise
     */
    public function setUnitPrise($unit_prise)
    {
        $this->unit_prise = $unit_prise;
    }

    /**
     * @return int
     */
    public function getStockQuantity()
    {
        return $this->stock_quantity;
    }

    /**
     * @param int $stock_quantity
     */
    public function setStockQuantity($stock_quantity)
    {
        $this->stock_quantity = $stock_quantity;
    }

}