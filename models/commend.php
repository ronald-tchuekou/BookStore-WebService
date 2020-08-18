<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */
namespace models;
/**
 * Class commend
 */
class Commend
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var Book
     */
    private $book;
    /**
     * @var int
     */
    private $quantity;
    /**
     * @var float
     */
    private $total_prise;
    /**
     * @var String
     */
    private $date_cmd;
    /**
     * @var int
     */
    private $is_billed;
    /**
     * @var int
     */
    private $is_validate;

    /**
     * commend constructor.
     * @param int $id
     * @param Book $book
     * @param int $quantity
     * @param float $total_prise
     * @param String $date_cmd
     * @param int $is_billed
     * @param int $is_validate
     */
    public function __construct($id, Book $book, $quantity, $total_prise, $date_cmd, $is_billed, $is_validate)
    {
        $this->id = $id;
        $this->book = $book;
        $this->quantity = $quantity;
        $this->total_prise = $total_prise;
        $this->date_cmd = $date_cmd;
        $this->is_billed = $is_billed;
        $this->is_validate = $is_validate;
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
     * @return Book
     */
    public function getBook(): Book
    {
        return $this->book;
    }

    /**
     * @param Book $book
     */
    public function setBook(Book $book)
    {
        $this->book = $book;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return float
     */
    public function getTotalPrise()
    {
        return $this->total_prise;
    }

    /**
     * @param float $total_prise
     */
    public function setTotalPrise($total_prise)
    {
        $this->total_prise = $total_prise;
    }

    /**
     * @return String
     */
    public function getDateCmd()
    {
        return $this->date_cmd;
    }

    /**
     * @param String $date_cmd
     */
    public function setDateCmd($date_cmd)
    {
        $this->date_cmd = $date_cmd;
    }

    /**
     * @return int
     */
    public function isIsBilled()
    {
        return $this->is_billed;
    }

    /**
     * @param int $is_billed
     */
    public function setIsBilled($is_billed)
    {
        $this->is_billed = $is_billed;
    }

    /**
     * @return int
     */
    public function isIsValidate(): int
    {
        return $this->is_validate;
    }

    /**
     * @param int $is_validate
     */
    public function setIsValidate(int $is_validate): void
    {
        $this->is_validate = $is_validate;
    }

}