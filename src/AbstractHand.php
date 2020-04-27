<?php declare(strict_types=1);

namespace Gamebetr\Cards;

/**
 * Class AbstractHand.
 *
 * Class to help manage sets of cards and determine what actions are allowed.
 */
abstract class AbstractHand implements HandInterface
{

    /**
     * The cards in the hand.
     *
     * @var \Gamebetr\Cards\CardInterface[] $card
     */
    protected $cards = [];

    /**
     * If the hand has been locked from edits.
     *
     * @var bool
     */
    protected $is_locked = false;

    /**
     * {@inheritdoc}
     */
    public function addCard(CardInterface $card): int
    {
        if ($this->isLocked() === false) {
            $this->cards[] = $card;
        }

        return count($this->cards);
    }

    /**
     * {@inheritdoc}
     */
    public function isLocked(): bool
    {
        return $this->is_locked === true;
    }

    /**
     * {@inheritdoc}
     */
    public function getCard(int $index): ?CardInterface
    {
        return $this->cards[$index] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * {@inheritdoc}
     */
    public function lock(): void
    {
        $this->is_locked = true;
    }

    /**
     * {@inheritdoc}
     */
    public function unlock(): void
    {
        $this->is_locked = false;
    }

    /**
     * {@inheritdoc}
     */
    public function removeCard(int $index)
    {
        if (empty($this->cards[$index]) || $this->isLocked()) {
            return false;
        }

        return array_splice($this->cards, $index, 1)[0];
    }

    /**
     * {@inheritdoc}
     */
    public function reset(): int
    {
        $this->is_locked = false;

        $count = count($this->cards);

        $this->cards = [];

        return $count;
    }

    /**
     * {@inheritdoc}
     */
    public function sum(): int
    {
        $sum = 0;

        foreach ($this->cards as $card) {
            $sum += $card->value();
        }

        return $sum;
    }

}
