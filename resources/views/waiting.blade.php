<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Appointment Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .1);
            max-width: 420px;
            width: 90%;
        }

        .icon {
            font-size: 50px;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 10px;
            color: #333;
        }

        p {
            color: #555;
            line-height: 1.6;
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #ddd;
            border-top-color: #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 8px;
            vertical-align: middle;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .btn {
            margin-top: 20px;
            padding: 10px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            color: white;
        }

        .btn-primary {
            background: #007bff;
        }

        .btn-success {
            background: #28a745;
        }

        .btn-home {
            background: #6c757d;
        }

        #toast {
            display: none;
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            padding: 14px 28px;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            font-size: 15px;
            z-index: 9999;
            min-width: 280px;
            text-align: center;
        }

        #toast.success {
            background: #28a745;
        }

        #toast.error {
            background: #dc3545;
        }

        #msgBox {
            display: none;
            margin-top: 16px;
            background: #f0f8ff;
            border-left: 4px solid #007bff;
            padding: 12px 16px;
            border-radius: 6px;
            text-align: left;
            color: #333;
        }

        #msgBox strong {
            display: block;
            margin-bottom: 6px;
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="box" id="statusBox">
        <div class="icon" id="statusIcon">⏳</div>
        <h2 id="statusTitle">Appointment Pending</h2>
        <p id="statusText">
            Your appointment has been submitted.<br>
            Waiting for doctor's confirmation...<br>
            <span class="spinner" id="spinnerEl"></span>
        </p>
        <div id="msgBox">
            <strong>Message from Doctor:</strong>
            <span id="msgText"></span>
        </div>
        <div id="actionButtons"></div>
    </div>

    <div id="toast"></div>

    <script>
        const APPOINTMENT_ID = "{{ session('appointment_id') }}";
        const API_BASE = window.location.origin;

        let pollingInterval = null;

        function showToast(msg, type) {
            const t = document.getElementById("toast");
            t.textContent = msg;
            t.className = type;
            t.style.display = "block";
            setTimeout(() => {
                t.style.display = "none";
            }, 4000);
        }

        function handleApproved(doctorMessage) {
            clearInterval(pollingInterval);
            document.getElementById("statusIcon").textContent = "✅";
            document.getElementById("statusTitle").textContent = "Appointment Confirmed!";
            document.getElementById("statusText").innerHTML = "Your appointment has been approved by the doctor.";
            const spinner = document.getElementById("spinnerEl");
            if (spinner) spinner.style.display = "none";
            if (doctorMessage) {
                document.getElementById("msgText").textContent = doctorMessage;
                document.getElementById("msgBox").style.display = "block";
            }
            document.getElementById("actionButtons").innerHTML = `
                <button class="btn btn-success" onclick="goToCheckout()">💳 Proceed to Checkout</button>`;
            showToast("🎉 Your appointment has been approved!", "success");
        }

        function handleCancelled(doctorMessage) {
            clearInterval(pollingInterval);
            document.getElementById("statusIcon").textContent = "❌";
            document.getElementById("statusTitle").textContent = "Appointment Cancelled";
            document.getElementById("statusText").innerHTML = "Unfortunately, your appointment was not approved.";
            const spinner = document.getElementById("spinnerEl");
            if (spinner) spinner.style.display = "none";
            if (doctorMessage) {
                document.getElementById("msgText").textContent = doctorMessage;
                document.getElementById("msgBox").style.display = "block";
            }
            document.getElementById("actionButtons").innerHTML = `
                <button class="btn btn-primary" onclick="bookAgain()">Book Again</button>
                <br><br>
                <button class="btn btn-home" onclick="goHome()">Back to Home</button>`;
            showToast("❌ Appointment was cancelled.", "error");
        }

        async function checkAppointmentStatus() {
            if (!APPOINTMENT_ID || APPOINTMENT_ID === "") {
                document.getElementById("statusText").textContent = "Session expired. Please book again.";
                document.getElementById("spinnerEl").style.display = "none";
                return;
            }

            try {
                const res = await fetch(`${API_BASE}/api/appointment-status/${APPOINTMENT_ID}`);
                const data = await res.json();

                if (data.status !== "success") return;

                const apptStatus = data.appt_status;
                const doctorMsg = data.doctor_message;

                if (apptStatus === "approved") {
                    handleApproved(doctorMsg);
                } else if (apptStatus === "cancelled") {
                    handleCancelled(doctorMsg);
                }

            } catch (err) {
                console.error("Polling error:", err);
            }
        }

        function goToCheckout() {
            window.location.href = "{{ route('checkout.show') }}";
        }

        function goHome() {
            window.location.href = "{{ route('home') }}";
        }

        function bookAgain() {
            window.location.href = "{{ route('doctors') }}";
        }

        if (APPOINTMENT_ID && APPOINTMENT_ID !== "") {
            checkAppointmentStatus();
            pollingInterval = setInterval(checkAppointmentStatus, 10000);
        } else {
            document.getElementById("statusText").textContent = "No active booking found. Please book first.";
            document.getElementById("spinnerEl").style.display = "none";
        }
    </script>
</body>

</html>