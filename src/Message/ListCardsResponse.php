<?php

namespace Ampeco\OmnipayPayhub\Message;

use Ampeco\OmnipayPayhub\Models\Card;

class ListCardsResponse extends Response
{
    private $cards;

    /**
     * @return Card[]
     */
    public function getCards()
    {
        if (!empty($this->cards)) {
            return $this->cards;
        }

        return $this->cards = array_map(
            fn ($card) => new Card($card),
            $this->data['cardList'] ?? []
        );
    }

    public function setCards(array $cards): self
    {
        $this->cards = $cards;
        return $this;
    }
}
