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
     * commend constructor.
     * @param int $id
     * @param Book $book
     * @param int $quantity
     * @param float $total_prise
     * @param String $date_cmd
     * @param int $is_billed
     * @param int $is_validate
     */
    public function setData(int $id, Book $book, int $quantity, float $total_prise, string $date_cmd, int $is_billed, int $is_validate)
    {
        $this->id = $id;
        $this->book = $book;
        $this->quantity = $quantity;
        $this->total_prise = $total_prise;
        $this->date_cmd = $date_cmd;
        $this->is_billed = $is_billed;
        $this->is_validate = $is_validate;
        $this->bill_ref = "";
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

    /**
     * @return string
     */
    public function getBill_ref (): string 
    {
        return $this->bill_ref;
    }

    /**
     * @param string $bill_ref
     */
    public function setBill_ref (string $bill_ref): void
    {
        $this->bill_ref = $bill_ref;
    }

}