<?php


namespace Calculation\tests\Settings;


use Calculation\Utils\Exchange\CurrencyInterface;


class Currency implements CurrencyInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=5)
     * @Groups({"currency:read", "pair-unit:read", "calculator_collection_query", "invoice_item_query", "invoice_item_query"})
     */
    private string $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=5)
     * @Groups({"currency:read", "pair-unit:read", "calculator_collection_query", "invoice_item_query", "invoice_item_query"})
     */
    private string $subname;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private float $rate;

    /**
     * @var string
     * @ORM\Column(type="string", length=8)
     * @Groups({"currency:read", "pair-unit:read", "pair:create"})
     */
    private string $tag;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private float $inRate;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private float $price;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private float $outRate;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return \Calculation\tests\User\Currency
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @param string $subname
     * @return $this
     */
    public function setSubName(string $subname): self
    {
        $this->subname = $subname;

        return $this;
    }
    /**
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     * @return $this
     */
    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @param float $amount
     * @return $this
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     * @return $this
     */
    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return float
     */
    public function getInRate(): float
    {
        return $this->inRate;
    }

    /**
     * @param float $inRate
     * @return $this
     */
    public function setInRate(float $inRate): self
    {
        $this->inRate = $inRate;

        return $this;
    }

    /**
     * @return float
     */
    public function getOutRate(): float
    {
        return $this->outRate;
    }

    /**
     * @param float $outRate
     * @return $this
     */
    public function setOutRate(float $outRate): self
    {
        $this->outRate = $outRate;

        return $this;
    }
    /**
     * @param array $inFee
     * @return $this
     */
    public function setInFee(array $inFee): self
    {
        $this->inFee = $inFee;

        return $this;
    }
    /**
     * @param array $outFee
     * @return $this
     */
    public function setOutFee(array $outFee): self
    {
        $this->outFee = $outFee;

        return $this;
    }
    /**
     * @param array $fee
     * @return $this
     */
    public function setFee(array $fee): self
    {
        $this->fee = $fee;

        return $this;
    }
    /**
     * @param array $min
     * @return $this
     */
    public function setMin(array $min): self
    {
        $this->min = $min;

        return $this;
    }
    /**
     * @param float $max
     * @return $this
     */
    public function setMax(float $max): self
    {
        $this->max = $max;

        return $this;
    }
    /**
     * @param float $inPercent
     * @return $this
     */
    public function setInPercent(float $inPercent): self
    {
        $this->inPercent = $inPercent;

        return $this;
    }
    /**
     * @param float $outPercent
     * @return $this
     */
    public function setOutPercent(float $outPercent): self
    {
        $this->outPercent = $outPercent;

        return $this;
    }
/**
* @return float|null
*/
    public function getPaymentRate(): float
    {
        return $this->paymentRate;
    }

/**
* @param float $paymentRate
* @return $this
*/
    public function setPaymentRate(float $paymentRate): self
    {
        $this->paymentRate = $paymentRate;

        return $this;
    }

/**
* @return float|null
*/
    public function getPayoutRate(): float
    {
        return $this->payoutRate;
    }

/**
* @param float $payoutRate
* @return $this
*/
    public function setPayoutRate(float $payoutRate): self
    {
        $this->payoutRate = $payoutRate;

        return $this;
    }
}