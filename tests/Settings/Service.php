<?php


namespace Calculation\tests\Settings;


use Calculation\Utils\Exchange\ServiceInterface;

class Service implements ServiceInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=20)
     * @Groups({"pair-unit:read", "calculator_collection_query", "pair:create"})
     */
    private string $name;

    /**
     * @var array
     * @ORM\Column(type="json")
     * @Groups({"pair-unit:read"})
     */
    private array $inFee = [];

    /**
     * @var array
     * @ORM\Column(type="json")
     * @Groups({"pair-unit:read"})
     */
    private array $outFee = [];

    /**
     * @var string
     * @ORM\Column(type="string", length=20)
     */
    private string $tag;

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
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getInFee(): array
    {
        return $this->inFee;
    }

    /**
     * @param array $inFee
     * @return \Calculation\tests\User\Service
     */
    public function setInFee(array $inFee): self
    {
        $this->inFee = $inFee;

        return $this;
    }

    /**
     * @return array
     */
    public function getOutFee(): array
    {
        return $this->outFee;
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