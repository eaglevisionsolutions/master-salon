// reports.js: Handles loading sales and performance analytics

$(function() {
    function loadReports() {
        $.get('api/reports.php', function(data) {
            // Example: render reports
            $("#todaySales").text(data.sales.total_sales || 0);
            $("#todayAppointments").text(data.appointments.num_appointments || 0);
            let staffHtml = "";
            data.staff_performance.forEach(function(staff) {
                staffHtml += `<li>Staff ID ${staff.staff_id}: ${staff.num_appointments} appointments</li>`;
            });
            $("#staffPerformance").html(staffHtml);
        });
    }

    loadReports();
});