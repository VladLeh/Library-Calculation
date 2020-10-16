<?php


namespace Calculation\tests\Settings;


use Calculation\Utils\Exchange\CurrencyInterface;
use Calculation\Utils\Exchange\FeeInterface;
use Calculation\Utils\Exchange\PairUnitInterface;
use Calculation\Utils\Exchange\PaymentSystemInterface;
use Calculation\Utils\Exchange\ServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Collection;
use Calculation\tests\Settings\Fee;

class PairUnit implements PairUnitInterface
{
    public const NOTHING           = 0;
    public const FLAG_EXCHANGEABLE = 1;


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"pair-unit:read"})
     */
    private int $id;

    /**
     * @var CurrencyInterface
     * @ORM\ManyToOne(targetEntity=Currency::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"pair-unit:read", "calculator_collection_query", "pair:create", "invoice_item_query"})
     */
    private CurrencyInterface $currency;

    /**
     * @var PaymentSystemInterface
     * @ORM\ManyToOne(targetEntity=PaymentSystem::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"pair-unit:read", "calculator_collection_query", "pair:create", "invoice_item_query"})
     */
    private PaymentSystemInterface $paymentSystem;

    /**
     * @var ServiceInterface
     * @ORM\ManyToOne(targetEntity=Service::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"pair-unit:read", "calculator_collection_query", "pair:create", "invoice_item_query"})
     */
    private ServiceInterface $service;

    /**
     * @var float
     * @Groups({"pair-unit:read", "calculator_collection_query"})
     */
    private float $amount = 0;

    /**
     * @var float
     * @Groups({"pair-unit:read", "calculator_collection_query"})
     */
    private float $min = 0;

    /**
     * @var float
     * @Groups({"pair-unit:read", "calculator_collection_query"})
     */
    private float $max = 0;

    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     * @Groups({"pair-unit:read", "calculator_collection_query"})
     */
    private string $direction;

    /**
     * @var PersistentCollection
     * @ORM\ManyToMany(targetEntity=Pair::class, mappedBy="pairUnits")
     */
    private $pairs;

    /**
     * @var array
     * @ORM\Column(type="json")
     */
    private array $fee = [];

    /**
     * @var ?PairUnitTab
     * @ORM\ManyToOne(targetEntity=PairUnitTab::class, inversedBy="pairUnit")
     */
    private ?PairUnitTab $pairUnitTabs;

    /**
     * PairUnit constructor.
     */
    public function __construct()
    {
        $this->flags = self::NOTHING;
        $this->fee = [
            "percent"  => 0,
            "constant" => 0,
            "limits"   => [
                "min" => 0,
                "max" => 0
            ]
        ];
        $this->pairs = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \App\Entity\Currency
     */
    public function getCurrency(): CurrencyInterface
    {
        return $this->currency;
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

    /**
     * @return PaymentSystemInterface
     */
    public function getPaymentSystem(): PaymentSystemInterface
    {
        return $this->paymentSystem;
    }

    /**
     * @param PaymentSystemInterface $paymentSystem
     * @return $this
     */
    public function setPaymentSystem(PaymentSystemInterface $paymentSystem): self
    {
        $this->paymentSystem = $paymentSystem;

        return $this;
    }

    /**
     * @return ServiceInterface
     */
    public function getService(): ServiceInterface
    {
        return $this->service;
    }

    /**
     * @param ServiceInterface $service
     * @return $this
     */
    public function setService(ServiceInterface $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @param FeeInterface $Markupfee
     * @return $this
     */
    public function setMarkupfee(FeeInterface $Markupfee): self
    {
        $this->Markupfee= $Markupfee;

        return $this;
    }
    /**
     * @param FeeInterface $Primefee
     * @return $this
     */
    public function setPrimefee(FeeInterface $Primefee): self
    {
        $this->Primefee = $Primefee;

        return $this;
    }


    /**
     * @return bool
     * @Groups({"pair-unit:list:read", "pair-unit:item:read"})
     */
    public function isExchangeable(): bool
    {
        return $this->isFlagSet(self::FLAG_EXCHANGEABLE);
    }

    /**
     * @param bool $status
     * @return PairUnit
     * @Groups({"pair-unit-exchangeable:update"})
     */
    public function setExchangeable(bool $status): PairUnit
    {
        $this->setFlag(self::FLAG_EXCHANGEABLE, $status);

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return PairUnit
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return float
     */
    public function getMin(): float
    {
        return $this->min;
    }

    /**
     * @param float $min
     * @return PairUnit
     */
    public function setMin(float $min): self
    {
        $this->min = $min;

        return $this;
    }

    /**
     * @return float
     */
    public function getMax(): float
    {
        return $this->max;
    }

    /**
     * @param float $max
     * @return PairUnit
     */
    public function setMax(float $max): self
    {
        $this->max = $max;

        return $this;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     * @return $this
     */
    public function setDirection(string $direction): self
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * @return Collection|\App\Entity\Pair[]
     */
    public function getPairs(): Collection
    {
        return $this->pairs;
    }

    /**
     * @param Pair $pair
     * @return $this
     */
    public function addPair(Pair $pair): self
    {
        if (!$this->pairs->contains($pair)) {
            $this->pairs[] = $pair;
            $pair->addPairUnit($this);
        }

        return $this;
    }

    /**
     * @param Pair $pair
     * @return $this
     */
    public function removePair(Pair $pair): self
    {
        if ($this->pairs->contains($pair)) {
            $this->pairs->removeElement($pair);
            $pair->removePairUnit($this);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getFee(): array
    {
        return $this->fee;
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
     * @return PairUnitTab|null
     */
    public function getPairUnitTabs(): ?PairUnitTab
    {
        return $this->pairUnitTabs;
    }

    /**
     * @param PairUnitTab|null $pairUnitTabs
     * @return $this
     */
    public function setPairUnitTabs(?PairUnitTab $pairUnitTabs): self
    {
        $this->pairUnitTabs = $pairUnitTabs;

        return $this;
    }

    public function getPrimeFee(): FeeInterface
    {
        // TODO: Implement getPrimeFee() method.
    }

    public function getMarkupFee(): FeeInterface
    {
        // TODO: Implement getMarkupFee() method.
    }
}