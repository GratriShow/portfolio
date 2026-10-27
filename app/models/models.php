<?php

$db = require 'bdd.php';
function where(string $table, array $conditions = []): array
{
    global $db;

    $sql = "SELECT * FROM $table";

    if ($conditions) {
        $clauses = array_map(
            fn($column) => "$column = :$column",
            array_keys($conditions)
        );

        $sql .= ' WHERE ' . implode(' AND ', $clauses);
    }

    $stmt = $db->prepare($sql);
    $stmt->execute($conditions);

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
function all(string $table): array
{
    return where($table);
}

function find(string $table, int $id): ?array
{
    return where($table, ['id' => $id])[0] ?? null;
}

function create(string $table, array $datas): int
{
    global $db;

    $cols = implode(', ', array_keys($datas));
    $values = ':' . implode(', :', array_keys($datas));

    $stmt = $db->prepare("INSERT INTO `$table` ($cols) VALUES ($values)");
    $stmt->execute($datas);

    return (int) $db->lastInsertId();
}

function update(string $table, array $datas): bool
{
    global $db;

    if (!isset($datas['id'])) {
        throw new \InvalidArgumentException('ID manquant pour la mise à jour');
    }

    $id = $datas['id'];
    unset($datas['id']);

    $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($datas)));

    $sql = "UPDATE `$table` SET $set WHERE id = :id";
    $stmt = $db->prepare($sql);

    return $stmt->execute([...$datas, 'id' => $id]);
}

function delete(string $table, int $id): bool
{
    global $db;

    $sql = "DELETE FROM `$table` WHERE id = :id";
    $stmt = $db->prepare($sql);
    
    return $stmt->execute(['id' => $id]);
}