<?php declare(strict_types=1);

namespace Gamebetr\Cards;

use NumberFormatter;
use OutOfBoundsException;

/**
 * Standard playing card implementation.
 *
 * @author Steven Wichers <me@stevenwichers.com>
 */
class Card implements CardInterface
{
    /**
     * @var int The number of faces in a deck.
     */
    protected const NUMBER_OF_FACES = 13;

    /**
     * @var int The original value provided at creation.
     */
    protected $originalValue;

    /**
     * @var int The card face.
     */
    protected $faceId;

    /**
     * @var int The Card suit.
     */
    protected $suitId;

    /**
     * Card constructor.
     *
     * Defaults to creating Cards from a provable source.
     *
     * @param int $faceId
     *   The Card face ID or a provable number when $suitId is TYPE_PROVABLE.
     * @param int $suitId
     *   The Card suit ID or the TYPE_PROVABLE flag.
     */
    public function __construct(int $faceId, int $suitId = self::TYPE_PROVABLE)
    {
        $this->originalValue = $faceId;

        if (self::TYPE_PROVABLE === $suitId) {
            $suitId = $this->suitFromProvable($faceId);
            $faceId = $this->faceFromProvable($faceId);
        }

        if (!$this->isValidSuit($suitId)) {
            throw new OutOfBoundsException(
                sprintf('Invalid card suit (%d).', $suitId)
            );
        }

        if (!$this->isValidFace($faceId)) {
            throw new OutOfBoundsException(
                sprintf('Card (%d) is out of range.', $faceId)
            );
        }

        $this->faceId = $faceId;
        $this->suitId = $suitId;
    }

    /**
     * Calculate a suit from a provable roll.
     *
     * @param int $provableValue
     *   The original provable value.
     *
     * @return int
     *   The suit ID to use.
     */
    protected function suitFromProvable(int $provableValue): int
    {
        $number_of_suits = count($this->getSuitNames());

        $suit_id = $provableValue % $number_of_suits;
        if ($provableValue < 0) {
            // If the original suit was 0 (CLUB) then that was correct.
            // Otherwise, we need to adjust our math because the calculation
            // gets reversed for negatives.
            // -3, -2, -1, 0, 1, 2, 3
            // Should be:
            //  1,  2,  3, 0, 1, 2, 3
            $suit_id = $suit_id === 0 ?
                0 :
                $number_of_suits + $provableValue % $number_of_suits;
        }

        return $suit_id;
    }

    /**
     * Calculate a card face from a provable roll.
     *
     * @param int $provableValue
     *   The original provable value.
     *
     * @return int
     *   The face ID to use.
     */
    protected function faceFromProvable(int $provableValue): int
    {
        if ($provableValue < 0) {
            return static::FACE_JOKER;
        }
        // Offset by 2 because $provableValue starts at 0, but cards start at 2.
        return $provableValue / count($this->getSuitNames()) % static::NUMBER_OF_FACES + 2;
    }

    /**
     * Validate that a suit exists with the given ID.
     *
     * @param int $suitId
     *   The suit value to check for validity.
     *
     * @return bool
     *   TRUE of this is a valid suit value.
     */
    protected function isValidSuit(int $suitId): bool
    {
        return in_array($suitId, array_keys($this->getSuitNames()));
    }

    /**
     * Validate that a face exists with the given ID.
     *
     * @param int $faceId
     *   The face value to check for validity.
     *
     * @return bool
     *   TRUE if this is a valid card face.
     */
    protected function isValidFace($faceId): bool
    {
        return in_array($faceId, array_keys($this->getCardNames()));
    }

    /**
     * Get a list of suit names.
     *
     * @return array
     *   An array of suit names indexed by their IDs.
     */
    protected function getSuitNames(): array
    {
        return [
            static::SUIT_SPADE => 'spades',
            static::SUIT_HEART => 'hearts',
            static::SUIT_CLUB => 'clubs',
            static::SUIT_DIAMOND => 'diamonds',
        ];
    }

    /**
     * Get a list of card face names.
     *
     * @return array
     *   An array of face names indexed by their IDs.
     */
    protected function getCardNames(): array
    {
        $names = [
            static::FACE_JOKER => 'joker',
            static::FACE_JACK => 'jack',
            static::FACE_QUEEN => 'queen',
            static::FACE_KING => 'king',
            static::FACE_ACE => 'ace',
        ];

        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        for ($i = 2; $i <= 10; $i++) {
            $names[$i] = $formatter->format($i);
        }

        ksort($names);

        return $names;
    }

    /**
     * {@inheritdoc}
     */
    public static function init(int $faceId, int $suitId = self::TYPE_PROVABLE): Card
    {
        return new static($faceId, $suitId);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->fullName();
    }

    /**
     * {@inheritdoc}
     */
    public function fullName(): string
    {
        return sprintf('%s of %s', $this->name(), $this->suitName());
    }

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return $this->getCardNames()[$this->faceId];
    }

    /**
     * {@inheritdoc}
     */
    public function suitName(): string
    {
        return $this->getSuitNames()[$this->suitId];
    }

    /**
     * {@inheritdoc}
     */
    public function rankName(): string
    {
        return $this->name();
    }

    /**
     * {@inheritdoc}
     */
    public function value(): int
    {
        if ($this->isJoker()) {
            return 0;
        } elseif ($this->isRoyalty()) {
            return 10;
        } elseif ($this->isAce()) {
            return 11;
        }

        return $this->faceId;
    }

    /**
     * {@inheritdoc}
     */
    public function isJoker(): bool
    {
        return $this->faceId === static::FACE_JOKER;
    }

    /**
     * {@inheritdoc}
     */
    public function isRoyalty(): bool
    {
        return in_array(
            $this->faceId,
            [
                static::FACE_JACK,
                static::FACE_QUEEN,
                static::FACE_KING,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isAce(): bool
    {
        return $this->faceId === static::FACE_ACE;
    }

    /**
     * {@inheritdoc}
     */
    public function greaterThan(Card $card, bool $useSuitValue = false): bool
    {
        return $this->compare($card, $useSuitValue) == 1;
    }

    /**
     * {@inheritdoc}
     */
    public function rank(): int
    {
        if ($this->isJoker()) {
            return -1;
        }

        return $this->faceId - 2;
    }

    /**
     * {@inheritdoc}
     */
    public function suit(): int
    {
        return $this->suitId;
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginalFaceValue(): int {
        return $this->originalValue;
    }

    /**
     * {@inheritdoc}
     */
    public function getProvable(): int
    {
        $number_of_suits = count($this->getSuitNames());
        // Jokers are just negatively indexed by their suit name.
        if ($this->faceId < 0) {
            return -$number_of_suits + $this->suitId;
        }

        // Adjust face values by -2 because provables start at 0 and not 2.
        return ($this->faceId - 2) * $number_of_suits + $this->suitId;
    }

    /**
     * {@inheritdoc}
     */
    public function lessThan(Card $card, bool $useSuitValue = false): bool
    {
        return $this->compare($card, $useSuitValue) == -1;
    }

    /**
     * {@inheritdoc}
     */
    public function equalTo(Card $card, bool $useSuitValue = false): bool
    {
        return $this->compare($card, $useSuitValue) == 0;
    }

    /**
     * Compares a Card against this Card for equality.
     *
     * @param Card $card
     *   The Card to compare against.
     * @param bool $useSuitValue
     *   TRUE to factor in suits when comparing equal Cards.
     *
     * @return int
     *   -1 if the Card is less than, 0 if it is the same, or 1 if it is greater than.
     */
    protected function compare(Card $card, bool $useSuitValue = false): int
    {
        $comp = $this->rank() <=> $card->rank();
        if ($comp === 0 && $useSuitValue) {
            return $this->suit() <=> $card->suit();
        }

        return $comp;
    }

}
