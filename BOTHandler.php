<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


class BotHandler
{
    const TOKEN = "7279583274:AAFi8wAbq7WtquAV-ECXTdi6j7kMwC5XXts";
    const API   = "https://api.telegram.org/bot";

    public Client $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => self::API . self::TOKEN . "/"]);
    }

    public function handleStartCommand(int $chatId): void
    {

        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id'      => $chatId,
                'text'         => 'Assalomu alaykum Almashtirmoqchi bo\'lgan pulingizni tanlang:',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'USD -> UZS', 'callback_data' => 'usd2uzs'],
                            ['text' => 'UZS -> USD', 'callback_data' => 'uzs2usd']
                        ],
                    ]
                ])
            ]
        ]);
    }
}