<?php


namespace App\Lib;


class ProductEntity
{
    protected $prod_id;
    protected $prod_name;
    protected $prod_price;

    /**
     * @return mixed
     */
    public function getProdId()
    {
        return $this->prod_id;
    }

    /**
     * @param mixed $prod_id
     * @return ProductEntity
     */
    public function setProdId($prod_id)
    {
        $this->prod_id = $prod_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProdName()
    {
        return $this->prod_name;
    }

    /**
     * @param mixed $prod_name
     * @return ProductEntity
     */
    public function setProdName($prod_name)
    {
        $this->prod_name = $prod_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProdPrice()
    {
        return $this->prod_price;
    }

    /**
     * @param mixed $prod_price
     * @return ProductEntity
     */
    public function setProdPrice($prod_price)
    {
        $this->prod_price = $prod_price;
        return $this;
    }

}
