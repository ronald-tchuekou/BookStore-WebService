<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */
namespace models;

/**
 * Class facture
 */
class Bill
{
    /**
     * @var string
     */
    private $ref;
    /**
     * @var array
     */
    private $commends;
    /**
     * @var user
     */
    private $user;
    /**
     * @var shippingAddress
     */
    private $shippingAddress;
    /**
     * @var string
     */
    private $shipping_date;
    /**
     * @var string
     */
    private $state;
    /**
     * @var float
     */
    private $total_prise;
    /**
     * @var string
     */
    private $shipping_type;
    /**
     * @var string
     */
    private $payment_type;
    /**
     * @var float
     */
    private $shipping_cost;

    /**
     * bill constructor.
     * @param string $ref
     * @param array $commends
     * @param user $user
     * @param shippingAddress $shippingAddress
     * @param string $shipping_date
     * @param string $state
     * @param float $total_prise
     * @param string $shipping_type
     * @param string $payment_type
     * @param float $shipping_cost
     */
    public function __construct($ref, $commends, user $user, shippingAddress $shippingAddress, $shipping_date, $state,
                                $total_prise, string $shipping_type, $payment_type, $shipping_cost) {
        $this->ref = $ref;
        $this->commends = $commends;
        $this->user = $user;
        $this->shippingAddress = $shippingAddress;
        $this->shipping_date = $shipping_date;
        $this->state = $state;
        $this->total_prise = $total_prise;
        $this->shipping_type = $shipping_type;
        $this->payment_type = $payment_type;
        $this->shipping_cost = $shipping_cost;
    }

    /**
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    }

    /**
     * @return array
     */
    public function getCommends()
    {
        return $this->commends;
    }

    /**
     * @param array $commends
     */
    public function setCommends($commends)
    {
        $this->commends = $commends;
    }

    /**
     * @return user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param user $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return shippingAddress
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @param shippingAddress $shippingAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return string
     */
    public function getShippingDate()
    {
        return $this->shipping_date;
    }

    /**
     * @param string $shipping_date
     */
    public function setShippingDate($shipping_date)
    {
        $this->shipping_date = $shipping_date;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
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
     * @return string
     */
    public function getShippingType(): string
    {
        return $this->shipping_type;
    }

    /**
     * @param string $shipping_type
     */
    public function setShippingType(string $shipping_type): void
    {
        $this->shipping_type = $shipping_type;
    }

    /**
     * @return string
     */
    public function getPaymentType(): string
    {
        return $this->payment_type;
    }

    /**
     * @param string $payment_type
     */
    public function setPaymentType(string $payment_type): void
    {
        $this->payment_type = $payment_type;
    }

    /**
     * @return float
     */
    public function getShippingCost(): float
    {
        return $this->shipping_cost;
    }

    /**
     * @param float $shipping_cost
     */
    public function setShippingCost(float $shipping_cost): void
    {
        $this->shipping_cost = $shipping_cost;
    }

}