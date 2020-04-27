<?php declare(strict_types=1);

namespace Gamebetr\Cards;

/**
 * Interface HandInterface.
 *
 * Base contract for Hands.
 */
interface HandInterface
{
    /**
     * Add a card to the hand.
     *
     * @param \Gamebetr\Cards\CardInterface $card
     *   The card to add.
     *
     * @return int
     *   The number of cards in the hand.
     */
    public function addCard(CardInterface $card): int;

    /**
     * Check if the Hand has been locked.
     *
     * @return bool
     *   TRUE if the Hand has been marked with stand.
     */
    public function isLocked(): bool;

    /**
     * Get a card from the hand.
     *
     * @param int $index
     *   The index of the card.
     *
     * @return \Gamebetr\Cards\CardInterface|null
     *   The Card or NULL if the index wasn't valid.
     */
    public function getCard(int $index): ?CardInterface;

    /**
     * Get the cards from the hand.
     *
     * @return \Gamebetr\Cards\CardInterface[]
     */
    public function getCards(): array;

    /**
     * Lock the hand from modifications.
     */
    public function lock(): void;

    /**
     * Unlock the hand and allow modifications.
     *
     * Use with caution because this can break other logic.
     */
    public function unlock(): void;

    /**
     * Remove a Card from the hand.
     *
     * @param int $index
     *   The index of the Card to remove.
     *
     * @return bool|\Gamebetr\Cards\CardInterface
     *   The removed Card, or FALSE if we couldn't remove the card.
     */
    public function removeCard(int $index);

    /**
     * Reset the hand.
     *
     * @return int
     *   The number of cards that was in the hand.
     */
    public function reset(): int;

    /**
     * Get the total value of the hand.
     *
     * @return int
     *   The hand's value.
     */
    public function sum(): int;
}
