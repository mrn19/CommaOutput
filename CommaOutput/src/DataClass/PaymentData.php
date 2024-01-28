<?php
namespace src\DataClass;

use DateTime;

class PaymentData
{
    // 利用日時
    private \DateTime $date;

    // 利用店舗
    private string $shop;

    // 利用額
    private int $amount;

    /**
     * コンストラクタ
     * @param \DateTime $date
     * @param string $shop
     * @param int $amount
     */
    public function __construct(\DateTime $date, string $shop, int $amount)
    {
        $this->date = $date;
        $this->shop = $shop;
        $this->amount = $amount;
    }

    /**
     * ソート用比較用メソッド
     * 日付昇順でソート
     *
     * @param PaymentData $a
     * @param PaymentData $b
     * @return boolean
     */
    static function cmp(PaymentData $a, PaymentData $b)
    {
        return $a->date > $b->date;
    }

    /**
     *
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     *
     * @return string
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     *
     * @return number
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     *
     * @param DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     *
     * @param string $shop
     */
    public function setShop($shop)
    {
        $this->shop = $shop;
    }

    /**
     *
     * @param number $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}

