<?php


namespace Calculation\tests\Settings;


use Calculation\Utils\Exchange\PaymentSystemInterface;

class PaymentSystem implements PaymentSystemInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"payment-system:read"})
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=20)
     * @Groups({"payment-system:read", "pair-unit:read", "calculator_collection_query", "invoice_item_query"})
     */
    private string $name;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private float $price;

    /**
     * @var string
     * @ORM\Column(type="string", length=20)
     */
    private string $subName;

    /**
     * @var string
     * @ORM\Column(type="string", length=20)
     * @Groups({"payment-system:read", "pair-unit:read", "calculator_collection_query"})
     */
    private string $tag;

    /**
     * PaymentSystem constructor.
     */
    public function __construct()
    {
        $this->price = 0;
    }

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
     * @return \App\Entity\PaymentSystem
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return \Calculation\tests\User\PaymentSystem
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubName(): string
    {
        return $this->subName;
    }

    /**
     * @param string $subName
     * @return $this
     */
    public function setSubName(string $subName): self
    {
        $this->subName = $subName;

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
}