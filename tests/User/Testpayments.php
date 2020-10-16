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
    public $CourseGetRateIn;
    public $CourseGetRateOut;
    public $CoursePaymentSystemIn;
    public $CoursePaymentSystemOut;
    public $CourseServiceIn;
    public $CourseServiceOut;
    public $FeeMarkup;
    public $FeePrime;
    public $CoursePair;
    public $CourseOutObject;
    public $pair;
    public $course;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->CourseGetRateIn = (new Currency())
            ->setName('USD')
            ->setRate(1)
            ->setInRate(1.20)
            ->setMin(['min'=>1])
            ->setMax(6000)
            ->setOutRate(1.00);
        $this->CoursePaymentSystemIn = (new PaymentSystem())
            ->setName('VISA')
            ->setTag('VISA')
            ->setSubName('VISA')
            ->setPrice(0.050);
        $this->CourseServiceIn = (new Service())
            ->setName('ADVCASH')
            ->setInFee(['percent'=>0.01, 'constant'=>0.055,'limits'=>['min'=>1,'max'=>6000]])
            ->setOutFee(['percent'=>0.01, 'constant'=>0.055,'limits'=>['min'=>1,'max'=>6000]]);
        $this->FeeMarkup = (new Fee())
            ->setPercent(1.00)
            ->setMin(1)
            ->setMax(6000)
            ->setConstant(5);

        $this->CourseGetRateOut = (new Currency())
            ->setName('USDT')
            ->setRate(1)
            ->setInRate(1.10)
            ->setMin(['min'=>1])
            ->setMax(6000)
            ->setOutRate(1.0);
        $this->CoursePaymentSystemOut = (new PaymentSystem())
            ->setName('HUOBI')
            ->setTag('HUOBI')
            ->setSubName('HUOBI')
            ->setPrice(0.050);
        $this->CourseServiceOut = (new Service())
            ->setName('NODA')
            ->setInFee(['percent'=>0.08, 'constant'=>0.006,'limits'=>['min'=>1,'max'=>6000]])
            ->setOutFee(['percent'=>0.08, 'constant'=>0.006,'limits'=>['min'=>1,'max'=>6000]]);
        $this->FeePrime = (new Fee())
            ->setPercent(1.00)
            ->setMin(1)
            ->setMax(6000)
            ->setConstant(5);
    }
    public function testCourseObjectIn()
    {
        $PairUnitIn = new PairUnit();
        $PairUnitIn->setCurrency($this->CourseGetRateIn)->setPaymentSystem($this->CoursePaymentSystemIn)->setService($this->CourseServiceIn)->setMarkupfee($this->FeeMarkup)->setPrimefee($this->FeePrime);
        $this->pair = (new Pair())->setInObject($PairUnitIn)->setOutObject($PairUnitIn)->setPercent(10.0);
   //     dump(Course::calculate( $this->pair));

        $this->assertEquals(1.1988003, Course::calculate( $this->pair));
        $this->assertNotNull( Course::calculate( $this->pair));
    }

    public function testCourseObjectOut()
    {
        $PairUnitOut = new PairUnit();
        $PairUnitOut->setCurrency($this->CourseGetRateOut)->setPaymentSystem($this->CoursePaymentSystemOut)->setService($this->CourseServiceOut)->setMarkupfee($this->FeeMarkup)->setPrimefee($this->FeePrime);
        $this->pair = (new Pair())->setInObject($PairUnitOut)->setOutObject($PairUnitOut)->setPercent(10.0);
    //    dump(Course::calculate( $this->pair));

        $this->assertEquals( 1.10988927775, Course::calculate( $this->pair));
        $this->assertNotNull( Course::calculate( $this->pair));
    }

    public function testCalculateRatesPayments()
    {
        $PairUnitIn = new PairUnit();
        $PairUnitIn->setCurrency($this->CourseGetRateIn)->setPaymentSystem($this->CoursePaymentSystemIn)->setService($this->CourseServiceIn)->setMarkupfee($this->FeeMarkup)->setPrimefee($this->FeePrime);
        $pair = (new Pair())->setPayment()->setInObject($PairUnitIn)->setOutObject($PairUnitIn)->setPercent(10.0);
//        dump(Payment::calculateRates($pair));

        $this->assertEquals( 1.3189440792528033 , Payment::calculateRates($pair));
        $this->assertNotNull( Payment::calculateRates($pair));

    }
    public function testCalculateRatesPayout()
    {
        $PairUnitOut = new PairUnit();
        $PairUnitOut->setCurrency($this->CourseGetRateOut)->setPaymentSystem($this->CoursePaymentSystemOut)->setService($this->CourseServiceOut)->setMarkupfee($this->FeeMarkup)->setPrimefee($this->FeePrime);
        $pair = (new Pair())->setInObject($PairUnitOut)->setOutObject($PairUnitOut)->setPercent(10.0);
//        dump(Payout::calculateRates($pair));

        $this->assertEquals(1.2068570116417936, Payout::calculateRates($pair));
        $this->assertNotNull( Payout::calculateRates($pair));
    }

    public function testCalculateAmountPayments()
    {
        $PairUnitIn = new PairUnit();
        $PairUnitOut = new PairUnit();
        $PairUnitIn->setCurrency($this->CourseGetRateIn)->setPaymentSystem($this->CoursePaymentSystemIn)->setService($this->CourseServiceIn)->setMarkupfee($this->FeeMarkup)->setPrimefee($this->FeePrime);
        $PairUnitOut->setCurrency($this->CourseGetRateOut)->setPaymentSystem($this->CoursePaymentSystemOut)->setService($this->CourseServiceOut)->setMarkupfee($this->FeeMarkup)->setPrimefee($this->FeePrime);
        $pair = (new Pair())->setPercent(1.0)->setInObject($PairUnitIn)->setOutObject($PairUnitOut);

        Payout::calculateMin($pair);
//        dump($pair->getOutObject()->getMin());
        $this->assertEquals( 2.486034568046476, $pair->getInObject()->getMin());
        $this->assertNotEquals( 0, $pair->getInObject()->getMin());
        $this->assertNotNull($pair->getOutObject()->getMin());

        Payout::calculateMax($pair);
//        dump($pair->getOutObject()->getMax());
        $this->assertEquals( 8812.845616172724 , $pair->getInObject()->getMax());
        $this->assertNotEquals( 0, $pair->getInObject()->getMax());
        $this->assertNotNull($pair->getOutObject()->getMax());

        Payout::calculateAmount( $pair,  $amount = null);
//        dump($pair->getInObject()->getAmount());
        $this->assertEquals(2.486034568046476 , $pair->getInObject()->getAmount());
        $this->assertNotEquals( 0, $pair->getInObject()->getAmount());
        $this->assertNotNull($pair->getInObject()->getAmount());
    }
    public function testCalculateAmountPayouts()
    {
        $PairUnitIn = new PairUnit();
        $PairUnitOut = new PairUnit();
        $PairUnitIn->setCurrency($this->CourseGetRateIn)->setPaymentSystem($this->CoursePaymentSystemIn)->setService($this->CourseServiceIn);
        $PairUnitOut->setCurrency($this->CourseGetRateOut)->setPaymentSystem($this->CoursePaymentSystemOut)->setService($this->CourseServiceOut);
        $pair = (new Pair())->setPercent(10.0)->setInObject($PairUnitIn)->setOutObject($PairUnitOut);

        Payout::calculateMin($pair);
//        dump($pair->getOutObject()->getMin());
        $this->assertEquals(2.0 , $pair->getOutObject()->getMin());
        $this->assertNotEquals( 0, $pair->getOutObject()->getMin());
        $this->assertNotNull($pair->getOutObject()->getMin());

        Payout::calculateMax($pair);
//        dump($pair->getOutObject()->getMax());
        $this->assertEquals(6000.0, $pair->getOutObject()->getMax());
        $this->assertNotEquals( 0, $pair->getOutObject()->getMax());
        $this->assertNotNull($pair->getOutObject()->getMax());

        Payout::calculateAmount( $pair,  $amount = null);
//        dump($pair->getOutObject()->getAmount());
        $this->assertEquals(2.0, $pair->getOutObject()->getAmount());
        $this->assertNotEquals( 0, $pair->getOutObject()->getAmount());
        $this->assertNotNull($pair->getOutObject()->getAmount());
    }
}






