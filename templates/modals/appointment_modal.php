<?php
require_once 'db.php'; // Adjust path as needed

class AppointmentModel {
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

    public static function getAllAppointments() {
        $db = getDb();
        $stmt = $db->query("SELECT a.*, u.name as customer, s.name as service, st.name as staff 
            FROM appointments a 
            JOIN users u ON a.customer_id = u.id 
            JOIN services s ON a.service_id = s.id 
            LEFT JOIN users st ON a.staff_id = st.id
            ORDER BY a.date, a.time");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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