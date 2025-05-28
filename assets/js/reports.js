// reports.js: Handles loading sales and performance analytics

$(function() {
    function loadReports() {
        $.get('/api/reports.php', function(data) {
            // Today's Appointments Count (always for all roles)
            if ($("#todayAppointments").length) {
                let num = data.appointments && data.appointments.num_appointments ? data.appointments.num_appointments : 0;
                $("#todayAppointments").html(num > 0 ? `${num} appointment${num > 1 ? 's' : ''} today.` : "No appointments to display for today.");
            }

            // Only for staff/admin: Sales Today and Staff Performance
            if (data.sales && $("#todaySales").length) {
                let sales = data.sales.total_sales ? data.sales.total_sales : 0;
                $("#todaySales").text(sales > 0 ? `£${sales}` : "No sales today.");
            }

            if (data.staff_performance && $("#staffPerformance").length) {
                let staffHtml = "";
                if (Array.isArray(data.staff_performance) && data.staff_performance.length > 0) {
                    data.staff_performance.forEach(function(staff) {
                        staffHtml += `<li>${staff.staff_name}: ${staff.num_appointments} completed</li>`;
                    });
                } else {
                    staffHtml = "<li>No staff performance data for today.</li>";
                }
                $("#staffPerformance").html(staffHtml);
            }
        });
    }

    loadReports();
});