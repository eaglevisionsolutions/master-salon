<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once '../includes/csrf.php';

class AppointmentModel {
    public static function getDbInstance() {
        return getDb();
    }

    public static function getServices() {
        $db = getDb();
        $stmt = $db->query("SELECT * FROM services");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getStaff() {
        $db = getDb();
        $stmt = $db->query("SELECT id, name FROM users WHERE role = 'staff'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCustomerAppointments($customerId) {
        $db = getDb();
        $stmt = $db->prepare("SELECT a.*, s.name as service, u.name as staff FROM appointments a 
            JOIN services s ON a.service_id = s.id 
            LEFT JOIN users u ON a.staff_id = u.id 
            WHERE a.customer_id = ? ORDER BY a.date, a.time");
        $stmt->execute([$customerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function bookAppointment($customerId, $serviceId, $staffId, $dateTime, $notes = null) {
        $db = getDb();
        $date = date('Y-m-d', strtotime($dateTime));
        $time = date('H:i:s', strtotime($dateTime));
        $stmt = $db->prepare("INSERT INTO appointments (customer_id, service_id, staff_id, date, time, notes, status) VALUES (?, ?, ?, ?, ?, ?, 'booked')");
        return $stmt->execute([$customerId, $serviceId, $staffId, $date, $time, $notes]);
    }

    public static function rescheduleAppointment($appointmentId, $customerId, $newDateTime) {
        $db = getDb();
        $date = date('Y-m-d', strtotime($newDateTime));
        $time = date('H:i:s', strtotime($newDateTime));
        $stmt = $db->prepare("UPDATE appointments SET date = ?, time = ? WHERE id = ? AND customer_id = ?");
        return $stmt->execute([$date, $time, $appointmentId, $customerId]);
    }

    public static function cancelAppointment($appointmentId, $customerId) {
        $db = getDb();
        $stmt = $db->prepare("UPDATE appointments SET status = 'cancelled' WHERE id = ? AND customer_id = ?");
        return $stmt->execute([$appointmentId, $customerId]);
    }

    // --- Added methods for API integration ---

    public static function getTodaysAppointments($role, $userId, $today) {
        $db = getDb();
        if ($role === 'admin' || $role === 'staff') {
            $stmt = $db->prepare(
                "SELECT a.id, CONCAT(a.date, ' ', a.time) as scheduled_at, s.name as service, u.name as customer
                 FROM appointments a
                 JOIN services s ON a.service_id = s.id
                 JOIN users u ON a.customer_id = u.id
                 WHERE a.date = ?
                 ORDER BY a.time ASC"
            );
            $stmt->execute([$today]);
        } else {
            $stmt = $db->prepare(
                "SELECT a.id, CONCAT(a.date, ' ', a.time) as scheduled_at, s.name as service
                 FROM appointments a
                 JOIN services s ON a.service_id = s.id
                 WHERE a.customer_id = ? AND a.date = ?
                 ORDER BY a.time ASC"
            );
            $stmt->execute([$userId, $today]);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllAppointments($role, $userId) {
        $db = getDb();
        if ($role === 'admin' || $role === 'staff') {
            $stmt = $db->query(
                "SELECT a.*, u.name as customer, s.name as service, st.name as staff 
                 FROM appointments a
                 JOIN users u ON a.customer_id = u.id
                 JOIN services s ON a.service_id = s.id
                 LEFT JOIN users st ON a.staff_id = st.id
                 ORDER BY a.date DESC, a.time DESC LIMIT 50"
            );
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $db->prepare(
                "SELECT a.*, s.name as service, st.name as staff 
                 FROM appointments a
                 JOIN services s ON a.service_id = s.id
                 LEFT JOIN users st ON a.staff_id = st.id
                 WHERE a.customer_id=? ORDER BY a.date DESC, a.time DESC LIMIT 50"
            );
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public static function createAppointment($customerId, $staffId, $serviceId, $dateTime, $notes) {
        $db = getDb();
        $date = date('Y-m-d', strtotime($dateTime));
        $time = date('H:i:s', strtotime($dateTime));
        $stmt = $db->prepare(
            "INSERT INTO appointments (customer_id, staff_id, service_id, date, time, notes, status) VALUES (?, ?, ?, ?, ?, ?, 'booked')"
        );
        return $stmt->execute([$customerId, $staffId, $serviceId, $date, $time, $notes]);
    }

    public static function updateAppointment($role, $appointmentId, $staffId, $serviceId, $dateTime, $notes, $userId) {
        $db = getDb();
        $date = date('Y-m-d', strtotime($dateTime));
        $time = date('H:i:s', strtotime($dateTime));
        if ($role === 'customer') {
            $stmt = $db->prepare(
                "UPDATE appointments SET staff_id=?, service_id=?, date=?, time=?, notes=? WHERE id=? AND customer_id=?"
            );
            return $stmt->execute([$staffId, $serviceId, $date, $time, $notes, $appointmentId, $userId]);
        } else {
            $stmt = $db->prepare(
                "UPDATE appointments SET staff_id=?, service_id=?, date=?, time=?, notes=? WHERE id=?"
            );
            return $stmt->execute([$staffId, $serviceId, $date, $time, $notes, $appointmentId]);
        }
    }

    public static function deleteAppointment($role, $appointmentId, $userId) {
        $db = getDb();
        if ($role === 'customer') {
            $stmt = $db->prepare("DELETE FROM appointments WHERE id=? AND customer_id=?");
            return $stmt->execute([$appointmentId, $userId]);
        } else {
            $stmt = $db->prepare("DELETE FROM appointments WHERE id=?");
            return $stmt->execute([$appointmentId]);
        }
    }

    public static function getReminders($userId, $role) {
        $db = getDb();
        if ($role === 'admin' || $role === 'staff') {
            $stmt = $db->prepare("SELECT * FROM reminders WHERE user_id = ? OR user_id IS NULL ORDER BY date");
            $stmt->execute([$userId]);
        } else {
            $stmt = $db->prepare("SELECT * FROM reminders WHERE user_id = ? ORDER BY date");
            $stmt->execute([$userId]);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>