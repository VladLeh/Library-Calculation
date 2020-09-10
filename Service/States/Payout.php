<?php


namespace Calculation\Service\States;

use Calculation\Service\Course;
use Calculation\Utils\Calculation\CalculationInterface;
use Calculation\Utils\Exchange\PairInterface;


/**
 * Class Payout
 * @package Calculation
 */
class Payout implements CalculationInterface
{
    /**
     * @param PairInterface $pair
     */
    public static function calculateMin(PairInterface $pair): void
    {
        $paymentMin = $pair->getOutObject()->getService()->inFee()['min'];
        $payoutMin = $pair->getInObject()->getService()->inFee()['min'];

        self::calculateAmount($pair, $payoutMin);

        if ($paymentMin < $pair->getInObject()->getAmount()) {
            $pair->getOutObject()->setMin(ceil($pair->getInObject()->getAmount()));
            self::calculateAmount($pair, ceil($pair->getInObject()->getAmount()));
            $pair->getInObject()->setMin($pair->getInObject()->getAmount());
        } else {
            $pair->getOutObject()->setMin(ceil($paymentMin));
            self::calculateAmount($pair, ceil($paymentMin));
            $pair->getOutObject()->setMin($pair->getInObject()->getAmount());
        }
    }

    /**
     * @param PairInterface $pair
     * @param float|null $amount
     * @return void
     */
    public static function calculateAmount(PairInterface $pair, float $amount = null): void
    {
        $course = Course::calculate($pair);

        $paymentPercent = $pair->getInObject()->inFee()['percent'];
        $paymentConstant = $pair->getInObject()->inFee()['constant'];

        $payoutPercent = $pair->getOutObject()->outFee()['percent'];
        $payoutConstant = $pair->getOutObject()->outFee()['constant'];

        $currencyTmp = ($amount + $payoutConstant) / (1 - $payoutPercent / 100);
        $cryptocurrencyTmp = $currencyTmp * $course;

        $pair->getInObject()->setAmount(($cryptocurrencyTmp + $paymentConstant) / (1 - $paymentPercent / 100));
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void
    {
        $paymentMin = $pair->getOutObject()->getService()->inFee()['max'];
        $payoutMin = $pair->getInObject()->getService()->inFee()['max'];

        self::calculateAmount($pair, $payoutMin);

        if ($paymentMin < $pair->getInObject()->getAmount()) {
            $pair->getOutObject()->setMax(ceil($paymentMin));
            self::calculateAmount($pair, ceil($pair->getInObject()->getAmount()));
            $pair->getInObject()->setMax($pair->getInObject()->getAmount());
        } else {
            $pair->getOutObject()->setMax(ceil($pair->getInObject()->getAmount()));
            self::calculateAmount($pair, ceil($pair->getInObject()->getAmount()));
            $pair->getInObject()->setMax($pair->getInObject()->getAmount());
        }
    }
}