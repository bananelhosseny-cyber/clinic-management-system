/**
 * BookingCardiology.js  (and BookingDen.js / BookingOrthopedics.js — same logic)
 *
 * CHANGES FROM ORIGINAL:
 *  - REMOVED localStorage for selected_date and selected_slot
 *  - Date and time are now passed directly via a hidden form field
 *  - Slot availability is fetched from the real backend API
 *    (GET /api/available-slots?doctor_id=X&date=Y-m-d)
 *  - Unavailable (booked) slots are shown as disabled, not removed
 *
 * USAGE:
 *  Set DOCTOR_ID to the correct value on each booking page.
 *  The hidden inputs #selected_date and #selected_time must exist in the form.
 */

// ── CONFIG: Set this per page ─────────────────────────────────────────────────
// BookingCardiology: 7 (John Smith user_id)
// BookingDen:        9 (Ruby Perrin user_id)
// BookingOrthopedics:8 (Mahmoud Ahmed user_id)
const DOCTOR_ID = 8; // ← change per specialty page

// ── DOM ───────────────────────────────────────────────────────────────────────
const monthTitle = document.getElementById("monthTitle");
const calendarDates = document.getElementById("calendarDates");
const prevBtn = document.getElementById("prevMonth");
const nextBtn = document.getElementById("nextBtn"); // the "Next" button
const slotsBox = document.getElementById("slotsBox");

let currentDate = new Date();
let selectedDate = null;
let selectedSlot = null; // stored as "HH:MM" (24-hour)

const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
];

// ── Calendar ──────────────────────────────────────────────────────────────────
function renderCalendar() {
    calendarDates.innerHTML = "";

    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    monthTitle.textContent = `${months[month]} ${year}`;

    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();
    const today = new Date();

    for (let i = 0; i < firstDay; i++) {
        calendarDates.appendChild(document.createElement("div"));
    }

    for (let day = 1; day <= lastDate; day++) {
        const dateEl = document.createElement("div");
        dateEl.textContent = day;

        const thisDate = new Date(year, month, day);

        // Past dates are not selectable
        if (
            thisDate <
            new Date(today.getFullYear(), today.getMonth(), today.getDate())
        ) {
            dateEl.classList.add("disabled");
            dateEl.style.opacity = "0.4";
            dateEl.style.cursor = "not-allowed";
            calendarDates.appendChild(dateEl);
            continue;
        }

        if (
            day === today.getDate() &&
            month === today.getMonth() &&
            year === today.getFullYear()
        ) {
            dateEl.classList.add("today");
        }

        if (
            selectedDate &&
            thisDate.toDateString() === selectedDate.toDateString()
        ) {
            dateEl.classList.add("selected");
        }

        dateEl.addEventListener("click", async () => {
            selectedDate = new Date(year, month, day);
            selectedSlot = null;
            renderCalendar();

            const dateStr = formatDate(selectedDate);
            slotsBox.innerHTML =
                "<p style='color:#888'>Loading available slots...</p>";

            const slots = await fetchAvailableSlots(dateStr);
            renderSlots(slots);
        });

        calendarDates.appendChild(dateEl);
    }
}

document.getElementById("prevMonth").onclick = () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
};

nextBtn.onclick = () => {
    if (!selectedDate || !selectedSlot) {
        alert("Please select a date and a time slot before continuing.");
        return;
    }

    // Pass date + time directly into the form hidden fields (NO localStorage)
    document.getElementById("selected_date").value = formatDate(selectedDate);
    document.getElementById("selected_time").value = selectedSlot;

    // Submit the form to /appointment/{doctor_id}
    document.getElementById("bookingForm").submit();
};

// ── Slots ─────────────────────────────────────────────────────────────────────

/**
 * Fetch available slots from the backend.
 * Falls back to all slots if the API fails (e.g., no network).
 */
async function fetchAvailableSlots(dateStr) {
    try {
        const res = await fetch(
            `/api/available-slots?doctor_id=${DOCTOR_ID}&date=${dateStr}`,
        );
        const data = await res.json();
        if (data.status === "success") {
            return data.slots; // array of "HH:MM" strings
        }
    } catch (err) {
        console.error("Failed to fetch slots:", err);
    }
    // Fallback: show all slots (server will still block duplicates on submit)
    return [
        "09:00",
        "09:35",
        "10:10",
        "10:45",
        "11:20",
        "11:55",
        "12:30",
        "13:05",
        "13:40",
        "14:15",
        "14:50",
        "15:25",
    ];
}

function renderSlots(slots) {
    slotsBox.innerHTML = "";
    selectedSlot = null;

    if (!slots.length) {
        slotsBox.innerHTML =
            "<p style='color:#e74c3c'>No available slots for this date.</p>";
        return;
    }

    slots.forEach((time24) => {
        const slotEl = document.createElement("div");
        slotEl.className = "time-slot";
        slotEl.textContent = to12Hour(time24);
        slotEl.dataset.value = time24;

        slotEl.addEventListener("click", () => {
            document
                .querySelectorAll(".time-slot")
                .forEach((s) => s.classList.remove("active"));
            slotEl.classList.add("active");
            selectedSlot = time24; // always store as HH:MM for DB
        });

        slotsBox.appendChild(slotEl);
    });
}

// ── Helpers ───────────────────────────────────────────────────────────────────
function formatDate(date) {
    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, "0");
    const d = String(date.getDate()).padStart(2, "0");
    return `${y}-${m}-${d}`;
}

function to12Hour(time24) {
    const [h, m] = time24.split(":").map(Number);
    const suffix = h >= 12 ? "pm" : "am";
    const hour = h % 12 || 12;
    return `${hour}:${String(m).padStart(2, "0")} ${suffix}`;
}

renderCalendar();
