<?php declare(strict_types=1);

namespace Gamebetr\Cards;

/**
 * Provides the implementation contract for Cards.
 *
 * @author Steven Wichers <me@stevenwichers.com>
 */
interface CardInterface
{
    /**
     * @var int Face of Ace.
     */
    public const FACE_ACE = 14;

    /**
     * @var int Face of Jack.
     */
    public const FACE_JACK = 11;

    /**
     * @var int Face of Joker.
     */
    public const FACE_JOKER = -1;

    /**
     * @var int Face of King.
     */
    public const FACE_KING = 13;

    /**
     * @var int Face of Queen.
     */
    public const FACE_QUEEN = 12;

    /**
     * @var int Suit of Club.
     */
    public const SUIT_CLUB = 0;

    /**
     * @var int Suit of Diamond.
     */
    public const SUIT_DIAMOND = 1;

    /**
     * @var int Suit of Heart.
     */
    public const SUIT_HEART = 2;

    /**
     * @var int Suit of Spade.
     */
    public const SUIT_SPADE = 3;

    /**
     * @var int An indicator that the Card we are creating is from a provable random roll.
     */
    public const TYPE_PROVABLE = -100;

    /**
     * Cast the Card to a usable string.
     *
     * @return string
     *   The string representation of the Card.
     */
    public function __toString(): string;

    /**
     * Get the full name of the Card.
     *
     * @return string
     *   The Card's full name.
     *
     * @example ace of spades
     */
    public function fullName(): string;

    /**
     * Get the text version of the Card's name.
     *
     * @return string
     *   The text version of the Card name.
     */
    public function name(): string;

    /**
     * Get the text version of the Card's suit.
     *
     * @return string
     *   The text version of the Card suit.
     */
    public function suitName(): string;

    /**
     * Get the text version of the Card's rank.
     *
     * @return string
     *   The text version of the Card rank.
     */
    public function rankName(): string;

    /**
     * Get the Card's value.
     *
     * @return int
     *   The calculated value of the Card.
     */
    public function value(): int;

    /**
     * Check if the Card's face is a Joker.
     *
     * @return bool
     *   TRUE if the Card is a Joker.
     */
    public function isJoker(): bool;

    /**
     * Check if the Card's face is a Jack, Queen, or King.
     *
     * @return bool
     *   TRUE if the Card is a Jack, Queen, or King.
     */
    public function isRoyalty(): bool;

    /**
     * Check if the Card's face is an Ace.
     *
     * @return bool
     *   TRUE if the Card is an Ace.
     */
    public function isAce(): bool;

    /**
     * Compare a Card to this one for higher rank (and suit).
     *
     * @param CardInterface $card
     *   The Card to compare ranks against.
     * @param bool $useSuitValue
     *   TRUE to factor suit order into the comparison.
     *
     * @return bool
     *   TRUE if if this Card is higher ranked than the given Card.
     */
    public function greaterThan(CardInterface $card, bool $useSuitValue = false): bool;

    /**
     * Get the Card's ranking.
     *
     * @return int
     *   The Card's rank.
     */
    public function rank(): int;

    /**
     * Get the Card's suit.
     *
     * @return int
     *   The Card's suit.
     */
    public function suit(): int;

    /**
     * Compare a Card to this one for lower rank (and suit).
     *
     * @param CardInterface $card
     *   The Card to compare ranks against.
     * @param bool $useSuitValue
     *   TRUE to factor suit order into the comparison.
     *
     * @return bool
     *   TRUE if if this Card is lower ranked than the given Card.
     */
    public function lessThan(CardInterface $card, bool $useSuitValue = false): bool;

    /**
     * Compare a Card to this one for equal rank (and suit).
     *
     * @param CardInterface $card
     *   The Card to compare ranks against.
     * @param bool $useSuitValue
     *   TRUE to factor suit order into the comparison.
     *
     * @return bool
     *   TRUE if the cards are the same, FALSE otherwise.
     */
    public function equalTo(CardInterface $card, bool $useSuitValue = false): bool;

    /**
     * Get the original value that was passed in as the face.
     *
     * @return int
     *   The original face value.
     */
    public function getOriginalFaceValue(): int;

    /**
     * Get the provable number that represents this card.
     *
     * @return int
     *   The provable number that corresponds to this card.
     */
    public function getProvable(): int;

}
