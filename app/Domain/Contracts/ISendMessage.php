<?php

namespace App\Domain\Contracts;

interface ISendMessage
{
    public function sendMessage(): string;
}