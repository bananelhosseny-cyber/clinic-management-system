const monthTitle = document.getElementById("monthTitle");
const calendarDates = document.getElementById("calendarDates");
const prevBtn = document.getElementById("prevMonth");
const nextBtn = document.getElementById("nextMonth");
const slotsBox = document.getElementById("slotsBox");
const addINfo = document.getElementById("nextBtn");

let currentDate = new Date();
let selectedDate = null;
let selectedSlot = null;

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

// ================= Calendar =================
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

        if (
            day === today.getDate() &&
            month === today.getMonth() &&
            year === today.getFullYear()
        ) {
            dateEl.classList.add("today");
        }

        if (
            selectedDate &&
            day === selectedDate.getDate() &&
            month === selectedDate.getMonth() &&
            year === selectedDate.getFullYear()
        ) {
            dateEl.classList.add("selected");
        }

        dateEl.addEventListener("click", async () => {
            selectedDate = new Date(year, month, day);
            renderCalendar();
            const slots = await fetchAvailableSlots(selectedDate);
            renderSlots(slots);
        });

        calendarDates.appendChild(dateEl);
    }
}

prevBtn.onclick = () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
};

nextBtn.onclick = () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
};

// ================= Slots =================
function fetchAvailableSlots(date) {
    return new Promise((resolve) => {
        setTimeout(() => {
            resolve([
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
            ]);
        }, 500);
    });
}

function renderSlots(slots) {
    slotsBox.innerHTML = "";
    selectedSlot = null;

    slots.forEach((time) => {
        const slotEl = document.createElement("div");
        slotEl.className = "time-slot";
        slotEl.innerHTML = `${time} <span>Slots:1</span>`;

        slotEl.addEventListener("click", () => {
            document
                .querySelectorAll(".time-slot")
                .forEach((s) => s.classList.remove("active"));
            slotEl.classList.add("active");
            selectedSlot = time;
        });

        slotsBox.appendChild(slotEl);
    });
}

renderCalendar();

addINfo.addEventListener("click", function () {
    if (!selectedDate || !selectedSlot) {
        alert("Please select a date and a time slot.");
        return;
    }

    const year = selectedDate.getFullYear();
    const month = String(selectedDate.getMonth() + 1).padStart(2, "0");
    const day = String(selectedDate.getDate()).padStart(2, "0");
    const dateStr = `${year}-${month}-${day}`;

    window.location.href = `/appointment/1?date=${dateStr}&time=${selectedSlot}`;
});
