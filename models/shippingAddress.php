<?php
/**
 * Copyright (c) - 2020 by RonCoder
 */
namespace models;
/**
 * Class shippingAddress
 */
class ShippingAddress
{
  
    /**
     * shippingAddress constructor.
     * @param string $ref_adl
     * @param string $receiver_name
     * @param string $phone_number
     * @param string $district
     * @param string $street
     * @param string $more_description
     * @param int $is_default
     */
    public function setData(string $ref_adl, string $receiver_name, string $phone_number, string $district, string $street, string $more_description, int $is_default)
    {
        $this->ref_adl = $ref_adl;
        $this->receiver_name = $receiver_name;
        $this->phone_number = $phone_number;
        $this->district = $district;
        $this->street = $street;
        $this->more_description = $more_description;
        $this->is_default = $is_default;
    }

    /**
     * @return string
     */
    public function getRefAdl()
    {
        return $this->ref_adl;
    }

    /**
     * @param string $ref_adl
     */
    public function setRefAdl($ref_adl)
    {
        $this->ref_adl = $ref_adl;
    }

    /**
     * @return string
     */
    public function getReceiverName()
    {
        return $this->receiver_name;
    }

    /**
     * @param string $receiver_name
     */
    public function setReceiverName($receiver_name)
    {
        $this->receiver_name = $receiver_name;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @param string $phone_number
     */
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param string $district
     */
    public function setDistrict($district)
    {
        $this->district = $district;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getMoreDescription()
    {
        return $this->more_description;
    }

    /**
     * @param string $more_description
     */
    public function setMoreDescription($more_description)
    {
        $this->more_description = $more_description;
    }

    /**
     * @return int
     */
    public function isIsDefault()
    {
        return $this->is_default;
    }

    /**
     * @param int $is_default
     */
    public function setIsDefault($is_default)
    {
        $this->is_default = $is_default;
    }


}