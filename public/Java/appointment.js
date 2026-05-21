/**
 * appointment.js
 *
 * ORIGINAL PROBLEM:
 *   Date and time were passed via localStorage from the booking calendar page.
 *   This broke cross-device and cross-browser functionality, and was not
 *   reliable as a data source.
 *
 * FIX:
 *   The booking calendar JS now fills hidden form fields (#selected_date
 *   and #selected_time) before submitting the booking form. This script
 *   only does client-side validation to ensure those fields are populated.
 */

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("appointmentForm");
    const dateField = document.getElementById("selected_date");
    const timeField = document.getElementById("selected_time");

    if (!form) return;

    form.addEventListener("submit", function (e) {
        const date = dateField ? dateField.value : "";
        const time = timeField ? timeField.value : "";

        if (!date || !time) {
            e.preventDefault();
            alert(
                "Please go back and select a date and time slot before submitting.",
            );
            return;
        }

        // Values are already in the hidden fields — form submits normally to the server
    });
});
