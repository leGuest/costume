<?php

namespace App\Controllers;
use App\Models\CostumeModel;
use App\Models\TipperModel;
use App\Models\TransactionModel;
use App\Models\TotalTokensCostumeModel;
use App\Models\TotalTokensTipperModel;
use Silex\Application;

class ReadCostumeController {

  public function __construct($app) {
    $this->app   = $app;
  }

  public function readAll() {
    $costumeModel   = new CostumeModel($this->app["pdo"]);
    $costumeResult  = [];
    $costumeList    = $costumeModel->getAll();
    foreach($costumeList as $costume) {
      $totalTokensCostumeModel = new TotalTokensCostumeModel($this->app["pdo"]);
      $totalTokens = $totalTokensCostumeModel->get($costume->id);
      if ($totalTokens !== false) {
        $totalTokens = $totalTokens->total;
      } else {
        $totalTokens = 0;
      }
      $costumeResult[] = [
        "name"          => $costume->name,
        "hash_id"       => $costume->hash_id,
        "image"         => $costume->image,
        "tokens"        => $totalTokens,
        "id_status"     => $costume->id_status
      ];
    }
    foreach($costumeResult as $key => $row) {
      $tokens[$key] = $row["tokens"];
    }
    \array_multisort($tokens, SORT_DESC, $costumeResult);
    return \array_map("unserialize", array_unique(array_map("serialize", $costumeResult)));
  }
}
