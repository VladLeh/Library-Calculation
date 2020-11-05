<?php


namespace Calculation\tests\Settings;



use Calculation\Utils\Exchange\CurrencyInterface;
use Calculation\Utils\Exchange\PairInterface;
use Calculation\Utils\Exchange\PairUnitInterface;
use Calculation\Utils\Exchange\PaymentSystemInterface;
use Doctrine\Common\Collections\ArrayCollection;


class Pair implements PairInterface
{
    public const NOTHING = 0;
    public const FLAG_PAYIN = 1;
    public const FLAG_PAYOUT = 2;

    public const PAYMENT = "payment";
    public const PAYOUT = "payout";


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var ?PairUnitInterface
     * @Groups({"calculator_collection_query", "invoice_item_query"})
     */
    private ?PairUnitInterface $inObject = null;

    /**
     * @var ?PairUnitInterface
     * @Groups({"calculator_collection_query", "invoice_item_query"})
     */
    private ?PairUnitInterface $outObject = null;

    /**
     * @var PersistentCollection
     * @ORM\ManyToMany(targetEntity=PairUnit::class, inversedBy="pairs")
     * @Groups({"pair:read", "pair_mutation", "pair_collection_query", "calculator_collection_query", "collection_query"})
     */
    private $pairUnits;

    /**
     * @var float
     * @ORM\Column(type="float")
     * @Groups({"pair:write", "pair:read", "pair_mutation", "pair_collection_query", "collection_query", "item_query"})
     */
    private float $inPercent;

    /**
     * @var float
     * @ORM\Column(type="float")
     * @Groups({"pair:write", "pair:read", "pair_mutation", "pair_collection_query", "collection_query", "item_query", "requisition_collection_query"})
     */
    private float $outPercent;
    private $percent;
    private $payment;

    /**
     * Pair constructor.
     */
    public function __construct()
    {
        $this->flags = self::NOTHING;
        $this->pairUnits = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     * @Groups({"pair:list:read", "pair:item:read"})
     */
    public function isPayin(): bool
    {
        return $this->isFlagSet(self::FLAG_PAYIN);
    }

    /**
     * @param bool $status
     * @return \App\Entity\PairUnitInterface
     * @Groups({"pair-direction:update"})
     */
    public function setPayin(bool $status): \Calculation\tests\User\PairUnitInterface
    {
        $this->setFlag(self::FLAG_PAYIN, $status);

        return $this;
    }

    /**
     * @return bool
     * @Groups({"pair:list:read", "pair:item:read"})
     */
    public function isPayout(): bool
    {
        return $this->isFlagSet(self::FLAG_PAYOUT);
    }

//    /**
//     * @param bool $status
//     * @return $this
//     * @Groups({"pair-direction:update"})
//     */
//    public function setPayout(bool $status): Pair
//    {
//        $this->setFlag(self::FLAG_PAYOUT, $status);
//
//        return $this;
//    }

    /**
     * @return PairUnitInterface
     */
    public function getInObject(): PairUnitInterface
    {
        return $this->inObject;
    }

    /**
     * @param ?PairUnitInterface $inObject
     * @return $this
     */
    public function setInObject(?PairUnitInterface $inObject): self
    {
        $this->inObject = $inObject;

        return $this;
    }

    /**
     * @return PairUnitInterface
     */
    public function getOutObject(): PairUnitInterface
    {
        return $this->outObject;
    }

    /**
     * @param ?PairUnit $outObject
     * @return $this
     */
    public function setOutObject(?PairUnitInterface $outObject): self
    {
        $this->outObject = $outObject;

        return $this;
    }

    /**
     * @return Collection|PairUnit[]
     */
    public function getPairUnits(): Collection
    {
        return $this->pairUnits;
    }

    /**
     * @param PairUnit $pairUnit
     * @return $this
     */
    public function addPairUnit(PairUnitInterface $pairUnit): self
    {
        if (!$this->pairUnits->contains($pairUnit)) {
            $this->pairUnits[] = $pairUnit;
        }

        return $this;
    }

    /**
     * @param PairUnit $pairUnit
     * @return $this
     */
    public function removePairUnit(PairUnitInterface $pairUnit): self
    {
        if ($this->pairUnits->contains($pairUnit)) {
            $this->pairUnits->removeElement($pairUnit);
        }

        return $this;
    }

    /**
     * @return float
     */
    public function getInPercent(): float
    {
        return $this->inPercent;
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

    public function getPercent(): float
    {
        return $this->percent;
    }

    public function setPercent(float $percent): self
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * @param CurrencyInterface $currency
     * @return \Calculation\tests\User\PairUnit
     */
    public function setCurrency(CurrencyInterface $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function setInRate(float $inrate): self
    {
        $this->inrate = $inrate;

        return $this;
    }

    public function setPaymentSystem(PaymentSystemInterface $paymentSystem): self
    {
        $this->paymentSystem = $paymentSystem;

        return $this;
    }



    /**
     * @return PairUnit
     */
    public function getPayment(): PairUnitInterface
    {
        return $this->payment;
    }

    /**
     * @param PairUnit $payment
     * @return $this
     */
    public function setPayment(PairUnit $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * @return PairUnit
     */
    public function getPayout(): PairUnitInterface
    {
        return $this->payout;
    }

    /**
     * @param PairUnit $payout
     * @return $this
     */
    public function setPayout(PairUnit $payout): self
    {
        $this->payout = $payout;

        return $this;
    }


}