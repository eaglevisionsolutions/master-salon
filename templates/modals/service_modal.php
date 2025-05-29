<?php
require_once __DIR__ . '/../includes/db.php';

class ServiceModel {
    public static function getAll() {
        $db = getDb();
        $stmt = $db->query("SELECT * FROM services ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDb();
        $stmt = $db->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function add($name, $description, $price, $duration_minutes, $active = true) {
        $db = getDb();
        $stmt = $db->prepare("INSERT INTO services (name, description, price, duration_minutes, active) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $description, $price, $duration_minutes, $active]);
    }

    public static function edit($id, $name, $description, $price, $duration_minutes, $active = true) {
        $db = getDb();
        $stmt = $db->prepare("UPDATE services SET name=?, description=?, price=?, duration_minutes=?, active=? WHERE id=?");
        return $stmt->execute([$name, $description, $price, $duration_minutes, $active, $id]);
    }

    public static function remove($id) {
        $db = getDb();
        $stmt = $db->prepare("DELETE FROM services WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>