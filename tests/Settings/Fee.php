<?php


namespace Calculation\tests\Settings;


use Calculation\Utils\Exchange\FeeInterface;


class Fee implements FeeInterface
{
    /**
     * @return float
     */
    public function getMax(): float
    {
        return $this->max;
    }
    /**
     * @return float
     */
    public function getMin(): float
    {
        return $this->min;
    }
    /**
     * @return float
     */
    public function  getConstant(): float
    {
        return $this->constant;
    }

    /**
     * @return float
     */
    public function  getPercent(): float
    {
        return $this->percent;
    }


    public function setPercent(float $percent): self
    {
        $this->percent = $percent;

        return $this;
    }

    public function setConstant(float $constant): self
    {
        $this->constant = $constant;

        return $this;
    }
    public function setMin(float $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function setMax(float $max): self
    {
        $this->max = $max;

        return $this;
    }

    public function setPrime(float $primeFee): self
    {
        $this->primeFee = $primeFee;

        return $this;
    }
    public function setMarkup(float $markupFee): self
    {
        $this->markupFee = $markupFee;

        return $this;
    }

}