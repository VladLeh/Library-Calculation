<?php


namespace Calculation\Service\States;


use Calculation\Service\Course;
use Calculation\Utils\Calculation\CalculationInterface;
use Calculation\Utils\Exchange\PairInterface;

/**
 * Class Payment
 * @package Calculation
 */
class Payment implements CalculationInterface
{

    /**
     * @param PairInterface $pair
     */
    public static function calculateMin(PairInterface $pair): void
    {
        $paymentMin = $pair->getInObject()->getService()->inFee()['limits']['min'];
        $payoutMin = $pair->getOutObject()->getService()->inFee()['limits']['min'];

        $tmp = self::calculateAmount($payoutMin, $pair);

        if ($paymentMin < $tmp) {
            $pair->getInObject()->setMin(ceil($tmp));
            $tmp2 = self::calculateAmount(ceil($tmp), $pair);
            $pair->getOutObject()->setMin($tmp2);
        } else {
            $pair->getInObject()->setMin(ceil($paymentMin));
            $tmp2 = self::calculateAmount(ceil($paymentMin), $pair);
            $pair->getOutObject()->setMin($tmp2);
        }
    }

    /**
     * @param float $amount
     * @param PairInterface $pair
     * @return float
     */
    public static function calculateAmount(float $amount, PairInterface $pair): float
    {
        $course = Course::calculate($pair);

        $paymentPercent = $pair->getInObject()->inFee()['percent'];
        $paymentConstant = $pair->getInObject()->inFee()['constant'];

        $payoutPercent = $pair->getOutObject()->outFee()['percent'];
        $payoutConstant = $pair->getOutObject()->outFee()['constant'];

        $currencyTmp = $amount - ($amount * $paymentPercent) / 100 - $paymentConstant;
        $cryptocurrencyTmp = $currencyTmp / $course;

        return $cryptocurrencyTmp * (1 - $payoutPercent / 100) - $payoutConstant;
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void
    {
        $paymentMin = $pair->getInObject()->getService()->inFee()['limits']['max'];
        $payoutMin = $pair->getOutObject()->getService()->inFee()['limits']['max'];

        $tmp = self::calculateAmount($payoutMin, $pair);

        if ($paymentMin < $tmp) {
            $pair->getInObject()->setMax(ceil($paymentMin));
            $tmp2 = self::calculateAmount(ceil($paymentMin), $pair);
            $pair->getOutObject()->setMax($tmp2);
        } else {
            $pair->getInObject()->setMax(ceil($tmp));
            $tmp2 = self::calculateAmount(ceil($tmp), $pair);
            $pair->getOutObject()->setMax($tmp2);
        }
    }
}
