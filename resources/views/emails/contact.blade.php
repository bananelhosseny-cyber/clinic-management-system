<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            margin-top: 20px;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Inquiry</h2>
        </div>
        <div class="content">
            <p><span class="label">Patient Name:</span> {{ $data['name'] }}</p>
            <p><span class="label">Email Address:</span> {{ $data['email'] }}</p>
            <p><span class="label">Message Details:</span></p>
            <div style="background: #fff; padding: 15px; border-left: 5px solid #007bff;">
                {{ $data['message'] }}
            </div>
        </div>
        <footer style="margin-top: 20px; font-size: 12px; color: #888;">
            <p>This email was sent from the Medicarely Clinic website contact form.</p>
        </footer>
    </div>
</body>
</html>