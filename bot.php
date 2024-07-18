<?php

declare(strict_types=1);


require "BOTHandler.php";
require "Currency.php";

$bot = new BotHandler;
$currency = new Currency;

if (isset($update->message)) {
    $message = $update->message;
    $chatId = $message->chat->id;
    $text = $message->text;

    if ($text === '/start') {
        $bot->handleStartCommand($chatId);
        return;
    } elseif ($text === '/convert') {
        $bot->handleStartCommand($chatId);
        return;
    } elseif (is_numeric($text)) {
        $bot->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => "So'rov qabul qilindi Natijasi tez orada....!"
            ]
        ]);
        $result = $currency->Natija($text,$chatId);

        $bot->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => "Natija: " . $result
            ]
        ]);
        return;
    } else {
        $bot->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => "Pul convertatsiya qilmoqchi bolsangiz \n/convert komandasini kiriting"
            ]
        ]);
    }
}

if ($update->callback_query) {
    $callbackQuery = $update->callback_query;
    $callbackData  = $callbackQuery->data;
    $chatId        = $callbackQuery->message->chat->id;
    $messageId     = $callbackQuery->message->message_id;

    list($birinchi_valyuta, $ikkinchi_valyuta) = explode("2", $callbackData);

    $currency->convert(strval($chatId), $callbackData);

    $bot->client->post('sendMessage', [
        'form_params' => [
            'chat_id' => $chatId,
            'text'    => "Almashlamoqchi bo'lgan summangizni faqat raqamlarda kiriting"
        ]
    ]);
    return;
}
