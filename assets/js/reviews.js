// reviews.js: Handles submitting and displaying customer reviews

$(function() {
    function loadReviews() {
        $.get('api/reviews.php', function(data) {
            let html = "";
            data.forEach(function(rev) {
                html += `<tr>
                    <td>${rev.rating} / 5</td>
                    <td>${rev.comment}</td>
                    <td>${rev.created_at}</td>
                </tr>`;
            });
            $("#reviewsTable tbody").html(html);
        });
    }

    loadReviews();

    // Submit review
    $("#addReviewForm").on("submit", function(e) {
        e.preventDefault();
        const data = {
            appointment_id: $("#revAppointmentId").val(),
            staff_id: $("#revStaffId").val(),
            rating: $("#revRating").val(),
            comment: $("#revComment").val()
        };
        $.ajax({
            url: 'api/reviews.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function() {
                alert('Review submitted!');
                loadReviews();
                $("#addReviewForm")[0].reset();
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error || 'Failed to submit review');
            }
        });
    });
});