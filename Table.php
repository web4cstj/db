<?php
namespace Web4cstj\DB;
use PDO;
class Table
{
    static public $table = null;
    static public $champs = [];
    static public function all($champs = '*', $order = '')
    {
        $pdo = Database::connect();
        if (is_array($champs)) {
            $champs = implode(',', $champs);
        }
        if ($order) {
            $order = " ORDER BY $order";
        }
        $sql = "SELECT {$champs} FROM " . static::$table . "$order";
        $stmt = $pdo->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        $stmt->execute();
        $resultat = $stmt->fetchAll();
        return $resultat;
    }
    static public function find($id)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM " . static::$table . " WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        $stmt->execute();
        $resultat = $stmt->fetch();
        return $resultat;
    }
    public function save() {
        $pdo = Database::connect();
        if ($this->id) {
            $set = [];
            foreach (static::$champs as $champ => $etiquette) {
                $set = "$champ=>$champ";
            }
            $set = "SET ".implode(', ', $set);
            $stmt = $pdo->prepare("UPDATE " . static::$table . " $set WHERE id=:id");
            $this->bind($stmt, 'id');
        } else {
            $champs = implode(', ', array_keys(static::$champs));
            $values = ':'. implode(', :', array_keys(static::$champs));
            $stmt = $pdo->prepare("INSERT INTO " . static::$table . " ($champs) VALUES ($values)");
        }
        $this->bind($stmt, array_keys(static::$champs));
        $stmt->execute();
        return $this;
    }
    public function bind($stmt, $champs) {
        if (!is_array($champs)) {
            $champs = [$champs];
        }
        foreach ($champs as $champ) {
            $stmt->bindParam(":$champ", $this->$champ);
        }
        return $this;
    }
}
