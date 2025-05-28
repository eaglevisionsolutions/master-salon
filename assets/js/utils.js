// utils.js: Common utility functions for all modules

function formatDate(dateStr) {
    // Returns date in YYYY-MM-DD HH:mm format
    let d = new Date(dateStr);
    return d.getFullYear() + '-' +
        ('0' + (d.getMonth() + 1)).slice(-2) + '-' +
        ('0' + d.getDate()).slice(-2) + ' ' +
        ('0' + d.getHours()).slice(-2) + ':' +
        ('0' + d.getMinutes()).slice(-2);
}

// Example usage: $("#someDateField").val(formatDate('2025-05-28T15:45:00Z'));