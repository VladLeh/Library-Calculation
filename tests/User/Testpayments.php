<?php


namespace Calculation\tests\User;

use Calculation\Service\Course;
use Calculation\Service\States\Payment;
use Calculation\Service\States\Payout;
use Calculation\tests\Settings\Fee;
use PHPUnit\Framework\TestCase;
use Calculation\tests\Settings\Currency;
use Calculation\tests\Settings\Service;
use Calculation\tests\Settings\PaymentSystem;
use Calculation\tests\Settings\PairUnit;
use Calculation\tests\Settings\Pair;

class TestCalculator extends TestCase
{
    public $CourseGetRatePayment;
    public $CourseGetRatePayout;
    public $CoursePaymentSystemPayment;
    public $CoursePaymentSystemPayout;
    public $CourseServicePayment;
    public $CourseServicePayout;
    public $FeeMarkupPayment;
    public $FeePrimePayment;
    public $FeeMarkupPayout;
    public $FeePrimePayout;
    public $CoursePair;
    public $CourseOutObject;
    public $pair;
    public $course;
//3 - 8(13)
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->CourseGetRatePayment = (new Currency())
            ->setName('UAH')
            ->setRate(28.304026)
            ->setPaymentRate(28.304026)
            ->setPayoutRate(28.304026);
        $this->CoursePaymentSystemPayment = (new PaymentSystem())
            ->setName('VISA')
            ->setTag('VISA')
            ->setSubName('VISA')
            ->setPrice(0);
        $this->CourseServicePayment = (new Service())
            ->setName('UAPAY');
        $this->FeeMarkupPayment = (new Fee())
            ->setPercent(5)
            ->setMin(0)
            ->setMax(0)
            ->setConstant(1);
        $this->FeePrimePayment = (new Fee())
            ->setPercent(0.8)
            ->setMin(280)
            ->setMax(14999)
            ->setConstant(5);


        $this->CourseGetRatePayout = (new Currency())
            ->setName('ETH')
            ->setRate(376)
            ->setPaymentRate(376)
            ->setPayoutRate(376);
        $this->CoursePaymentSystemPayout = (new PaymentSystem())
            ->setName('HUOBI')
            ->setTag('HUOBI')
            ->setSubName('HUOBI')
            ->setPrice(0);
        $this->CourseServicePayout = (new Service())
            ->setName('NODA');
        $this->FeePrimePayout = (new Fee())
            ->setPercent(0.2)
            ->setMin(10)
            ->setMax(1000000)
            ->setConstant(4);
        $this->FeeMarkupPayout = (new Fee())
            ->setPercent(5)
            ->setMin(0)
            ->setMax(0)
            ->setConstant(1);
    }
    public function testCourseFiat()
    {
        $PairUnitPayment = new PairUnit();
        $PairUnitPayment->setCurrency($this->CourseGetRatePayment)->setPaymentSystem($this->CoursePaymentSystemPayment);

        $PairUnitPayout = new PairUnit();
        $PairUnitPayout->setCurrency($this->CourseGetRatePayment)->setPayoutSystem($this->CoursePaymentSystemPayment);

        $this->pair = (new Pair())->setPayment($PairUnitPayment)->setPayout($PairUnitPayout)->setPercent(1);

//        dump(Course::calculate( $this->pair));
        $this->assertNotNull( Course::calculate($this->pair));
        $this->assertGreaterThanOrEqual(0 ,  Course::calculate($this->pair));
        $this->assertEquals( 0.99, Course::calculate($this->pair));
    }

    public function testCourseCurrency()
    {
        $PairUnitPayment = new PairUnit();
        $PairUnitPayment->setCurrency($this->CourseGetRatePayout)->setPaymentSystem($this->CoursePaymentSystemPayout);

        $PairUnitPayout = new PairUnit();
        $PairUnitPayout->setCurrency($this->CourseGetRatePayout)->setPayoutSystem($this->CoursePaymentSystemPayout);

        $this->pair = (new Pair())->setPayment($PairUnitPayment)->setPayout($PairUnitPayout)->setPercent(1);

//        dump(Course::calculate( $this->pair));
        $this->assertNotNull( Course::calculate($this->pair));
        $this->assertGreaterThanOrEqual(0 ,  Course::calculate($this->pair));
        $this->assertEquals( 0.99, Course::calculate($this->pair));
    }

    public function testCalculateRatesCurrency()
    {
        $PairUnitPayment = new PairUnit();
        $PairUnitPayment->setCurrency($this->CourseGetRatePayout)->setPaymentSystem($this->CoursePaymentSystemPayout)->setMarkupfee($this->FeeMarkupPayout)->setPrimefee($this->FeePrimePayout);

        $PairUnitPayout = new PairUnit();
        $PairUnitPayout->setCurrency($this->CourseGetRatePayout)->setPaymentSystem($this->CoursePaymentSystemPayout)->setMarkupfee($this->FeeMarkupPayout)->setPrimefee($this->FeePrimePayout);

        $pair = (new Pair())->setPayment($PairUnitPayment)->setPayout($PairUnitPayout)->setPercent(1);
//       dump(Payout::calculateRates($pair));

        $this->assertNotNull( Payout::calculateRates($pair));
        $this->assertGreaterThanOrEqual(0 , Payout::calculateRates($pair));
        $this->assertEquals( 0.8897169599999999 , Payout::calculateRates($pair));
    }

    public function testCalculateRatesFiat()
    {
        $PairUnitPayment = new PairUnit();
        $PairUnitPayment->setCurrency($this->CourseGetRatePayment)->setPaymentSystem($this->CoursePaymentSystemPayment)->setMarkupfee($this->FeeMarkupPayment)->setPrimefee($this->FeePrimePayment);

        $PairUnitPayout = new PairUnit();
        $PairUnitPayout->setCurrency($this->CourseGetRatePayment)->setPaymentSystem($this->CoursePaymentSystemPayment)->setMarkupfee($this->FeeMarkupPayment)->setPrimefee($this->FeePrimePayment);

        $pair = (new Pair())->setPayment($PairUnitPayment)->setPayout($PairUnitPayout)->setPercent(5);
//       dump(Payment::calculateRates($pair));

        $this->assertNotNull( Payment::calculateRates($pair));
        $this->assertGreaterThanOrEqual(0 , Payment::calculateRates($pair));
        $this->assertEquals( 1.0633958000000001 , Payment::calculateRates($pair));
    }

    public function testCalculateAmountFiat()
    {
        $PairUnitPayment = new PairUnit();
        $PairUnitPayout = new PairUnit();
        $PairUnitPayment->setCurrency($this->CourseGetRatePayment)->setPaymentSystem($this->CoursePaymentSystemPayment)->setService($this->CourseServicePayment)->setMarkupfee($this->FeeMarkupPayment)->setPrimefee($this->FeePrimePayment);
        $PairUnitPayout->setCurrency($this->CourseGetRatePayment)->setPaymentSystem($this->CoursePaymentSystemPayment)->setService($this->CourseServicePayment)->setMarkupfee($this->FeeMarkupPayment)->setPrimefee($this->FeePrimePayment);
        $pair = (new Pair())->setPercent(5)->setPayment($PairUnitPayment)->setPayout($PairUnitPayout);

        Payout::calculateMin($pair);
//      dump($pair->getPayment()->getMin());
        $this->assertNotNull($pair->getPayment()->getMin());
        $this->assertGreaterThanOrEqual(0 , $pair->getPayment()->getMin());
        $this->assertEquals( 347.8865493754536, $pair->getPayment()->getMin());

        Payout::calculateMax($pair);
//        dump($pair->getPayment()->getMax());
        $this->assertNotNull($pair->getPayment()->getMax());
        $this->assertGreaterThanOrEqual(0 , $pair->getPayment()->getMax());
        $this->assertEquals( 17218.19005503942 , $pair->getPayment()->getMax());

//       dump($pair->getPayment()->getAmount());
        $this->assertNotNull($pair->getPayment()->getAmount());
        $this->assertGreaterThanOrEqual(0 , $pair->getPayment()->getAmount());
        $this->assertEquals(17218.19005503942 , $pair->getPayment()->getAmount());
    }

    public function testCalculateAmountCurrency()
    {
        $PairUnitPayment = new PairUnit();
        $PairUnitPayout = new PairUnit();
        $PairUnitPayment->setCurrency($this->CourseGetRatePayout)->setPaymentSystem($this->CoursePaymentSystemPayout)->setService($this->CourseServicePayout)->setMarkupfee($this->FeeMarkupPayout)->setPrimefee($this->FeePrimePayout);
        $PairUnitPayout->setCurrency($this->CourseGetRatePayout)->setPaymentSystem($this->CoursePaymentSystemPayout)->setService($this->CourseServicePayout)->setMarkupfee($this->FeeMarkupPayout)->setPrimefee($this->FeePrimePayout);
        $pair = (new Pair())->setPercent(1)->setPayment($PairUnitPayment)->setPayout($PairUnitPayout);

        Payout::calculateMin($pair);
//        dump($pair->getPayout()->getMin());
        $this->assertNotNull($pair->getPayout()->getMin());
        $this->assertGreaterThanOrEqual(0 , $pair->getPayout()->getMin());
        $this->assertEquals(22.0 , $pair->getPayout()->getMin());


        Payout::calculateMax($pair);
//        dump($pair->getPayout()->getMax());
        $this->assertNotNull($pair->getPayout()->getMax());
        $this->assertGreaterThanOrEqual(0 , $pair->getPayout()->getMax());
        $this->assertEquals(1000000.0, $pair->getPayout()->getMax());

        Payout::calculateAmount( $pair,  $amount = null);
//        dump($pair->getPayout()->getAmount());
        $this->assertNotNull($pair->getPayout()->getAmount());
        $this->assertGreaterThanOrEqual(0 , $pair->getPayout()->getAmount());
        $this->assertEquals(22.0, $pair->getPayout()->getAmount());
    }
}





