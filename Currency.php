<?php

declare(strict_types=1);
require "DB.php";


class Currency
{
    const string CB_RATE_API_URL = 'https://cbu.uz/uz/arkhiv-kursov-valyut/json/';
    private GuzzleHttp\Client $client;
    private PDO               $pdo;

    public function __construct()
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => self::CB_RATE_API_URL]);
        $this->pdo  = DB::connect();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRates()
    {
        return json_decode($this->client->get('')->getBody()->getContents());
    }

    public function getUsd()
    {
        return $this->getRates()[0];
    }

    public function convert($chatId, string $status)
    {
        $now    = date('Y-m-d H:i:s');
        $stmt = $this->pdo->prepare("INSERT INTO users (chat_id, status, created_at) VALUES (:chatId, :status, :createdAt)");
        $stmt->bindParam(':chatId', $chatId);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':createdAt', $now);
        $stmt->execute();
    }
    public function Natija($amount, $chatId)
    {
        $rate = $this->getUsd()->Rate;

        $query = "SELECT status FROM users WHERE chat_id = :chatId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':chatId', $chatId);
        $stmt->execute();

        $status = $stmt->fetchColumn();

        if ($status) {
            list($originalCurrency, $targetCurrency) = explode("2", $status);

            if ($originalCurrency == 'usd') {
                $result = $amount * $rate;
            } elseif ($targetCurrency == 'uzs') {
                $result = $amount / $rate;
            }

            $result = number_format($result, 0, '', '.');

            if ($originalCurrency == 'usd') {
                return $result . " $targetCurrency";
            } elseif ($targetCurrency == 'uzs') {
                return $result . " $targetCurrency";
            }
        } else {
            return "topilmadi...!  chat_id: $chatId";
        }
    }
}
