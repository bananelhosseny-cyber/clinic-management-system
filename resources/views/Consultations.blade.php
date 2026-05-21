<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultations</title>

    <link rel="stylesheet" href="{{ asset('CSS/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/Consultations.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

    <section class="consultations">
        <div class="overlay">
            <div class="main-container">

                <div class="cons-left">
                    <img src="{{ asset('images/Consultation.png') }}" alt="">
                </div>

                <div class="cons-right">

                    <h1>
                        Search Doctor, Make <br>
                        an <span>Appointment</span>
                    </h1>

                    <form id="appointmentForm">

                        <div class="form-group full">

                            <select required>
                                <option value="">Select a location</option>
                                <option>Cairo</option>
                                <option>Alexandria</option>
                                <option>Minia</option>
                            </select>

                        </div>

                        <div class="form-row">

                            <select required>
                                <option value="">Search by gender</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>

                            <select id="speciality" required>
                                <option value="">Select a speciality</option>
                                <option value="cardiology">Cardiology</option>
                                <option value="dentist">Dentist</option>
                                <option value="orthopedics">Orthopedics</option>
                            </select>

                            </select>

                        </div>
                   
                        
            <button type="submit" class="btn-primary" id="MAKE APPOINTMENT">
                MAKE APPOINTMENT
            </button>
                    </form>

                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("appointmentForm");

            form.addEventListener("submit", function(e) {
                e.preventDefault();

                const location = form.querySelectorAll("select")[0].value;
                const gender = form.querySelectorAll("select")[1].value;
                const speciality = document.getElementById("speciality").value;

                if (!location || !gender || !speciality) {
                    alert("Please fill all fields");
                    return;
                }

                const routes = {
                    cardiology: "{{ route('cardiology') }}",
                    dentist: "{{ route('dentist') }}",
                    orthopedics: "{{ route('orthopedics') }}"
                };

                if (routes[speciality]) {
                    window.location.href = routes[speciality];
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>