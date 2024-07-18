<?php

declare(strict_types=1);
require "DB.php";

class Dashboard
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function getAllExchanges(): false|array
    {
        return $this->pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
    }
}
