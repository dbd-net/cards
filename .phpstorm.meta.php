<?php declare(strict_types=1);

namespace PHPSTORM_META {

    expectedArguments(
        \Gamebetr\Cards\Card::__construct(),
        0,
        \Gamebetr\Cards\CardInterface::FACE_ACE,
        \Gamebetr\Cards\CardInterface::FACE_JACK,
        \Gamebetr\Cards\CardInterface::FACE_JOKER,
        \Gamebetr\Cards\CardInterface::FACE_KING,
        \Gamebetr\Cards\CardInterface::FACE_QUEEN,
    );

    expectedArguments(
        \Gamebetr\Cards\Card::__construct(),
        1,
        \Gamebetr\Cards\CardInterface::SUIT_CLUB,
        \Gamebetr\Cards\CardInterface::SUIT_DIAMOND,
        \Gamebetr\Cards\CardInterface::SUIT_HEART,
        \Gamebetr\Cards\CardInterface::SUIT_SPADE,
        \Gamebetr\Cards\CardInterface::TYPE_PROVABLE,
    );
}
