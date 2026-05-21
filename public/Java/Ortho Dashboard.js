const API_BASE = window.location.origin;
const DOCTOR_EMAIL = window.DOCTOR_EMAIL || "";
const DOCTOR_PASSWORD = window.DOCTOR_PASSWORD || "";

let authToken = null;
let doctor = {};
let appointments = [];
let patients = [];
let currentStatusFilter = "all";
let pendingModalAction = null;
let isTodayMode = false;
async function apiPost(endpoint, body, withAuth = false) {
    const headers = {
        "Content-Type": "application/json",
    };
    if (withAuth && authToken) headers["Authorization"] = `Bearer ${authToken}`;

    const res = await fetch(API_BASE + endpoint, {
        method: "POST",
        headers,
        body: JSON.stringify(body),
    });
    return res.json();
}

async function apiGet(endpoint) {
    const res = await fetch(API_BASE + endpoint, {
        headers: {
            Authorization: `Bearer ${authToken}`,
        },
    });
    return res.json();
}

async function initDashboard() {
    try {
        const loginData = await apiPost("/api/login", {
            email: DOCTOR_EMAIL,
            password: DOCTOR_PASSWORD,
        });

        if (loginData.status !== "success") {
            alert(
                "Failed to log in. Please check your credentials and try again.",
            );
            return;
        }

        authToken = loginData.token;
        const doc = loginData.doctor;
        doctor = {
            name:
                "Dr. " +
                (doc.first_name || doc.name || "") +
                " " +
                (doc.last_name || ""),
            spec: "Orthopedic Surgeon",
            email: doc.email,
            phone: doc.phone || "01247434534",
        };

        await loadAppointments();
        renderAppointmentsTable();
        renderPatientsList();
        renderReportsPage();
        renderDoctorProfile();

        setInterval(async () => {
            await loadAppointments();
            renderAppointmentsTable();
            renderPatientsList();
            renderReportsPage();
        }, 10000);
    } catch (err) {
        console.error("error:", err);
        alert("Failed to load dashboard. Please try again later.");
    }
}

async function loadAppointments() {
    if (isTodayMode) return;
    const data = await apiGet("/api/appointments");
    if (data.status === "success") {
        appointments = data.data.map((appt) => {
            const patientName = appt.patient
                ? (appt.patient.first_name || "") +
                  " " +
                  (appt.patient.last_name || "")
                : "Patient";

            return {
                id: appt.id,
                patient: patientName.trim() || "Patient",
                avatar: patientName
                    .split(" ")
                    .map((n) => n[0])
                    .join("")
                    .toUpperCase()
                    .slice(0, 2),
                date: appt.date || "",
                time: (appt.time || "").slice(0, 5),
                reason: appt.notes || "—",
                status:
                    appt.status === "approved"
                        ? "approved"
                        : appt.status === "cancelled"
                          ? "cancelled"
                          : appt.status === "completed"
                            ? "completed"
                            : appt.status || "pending",
            };
        });

        const uniquePatients = {};
        appointments.forEach((a) => {
            if (!uniquePatients[a.patient]) {
                uniquePatients[a.patient] = {
                    avatar: a.avatar,
                    name: a.patient,
                };
            }
        });

        patients = Object.values(uniquePatients);
    }
}

function navigate(pageName, clickedNavLink) {
    document
        .querySelectorAll(".page-section")
        .forEach((p) => p.classList.remove("active"));
    document
        .querySelectorAll(".left-nav-link")
        .forEach((l) => l.classList.remove("active"));

    document.getElementById("page-" + pageName).classList.add("active");
    if (clickedNavLink) clickedNavLink.classList.add("active");

    const pageRenderers = {
        appt: renderAppointmentsTable,
        patients: renderPatientsList,
        reports: renderReportsPage,
        profile: renderDoctorProfile,
    };
    if (pageRenderers[pageName]) pageRenderers[pageName]();
}

function filterAppts(clickedButton) {
    isTodayMode = false;
    document
        .querySelectorAll(".appointments-filter-button")
        .forEach((b) => b.classList.remove("active"));
    clickedButton.classList.add("active");
    currentStatusFilter = clickedButton.dataset.f;
    renderAppointmentsTable();
}

function renderAppointmentsTable() {
    const filteredList =
        currentStatusFilter === "all"
            ? appointments
            : appointments.filter((a) => a.status === currentStatusFilter);

    const tableBody = document.getElementById("apptTbody");

    if (!filteredList.length) {
        tableBody.innerHTML = `
      <tr>
        <td colspan="6">
          <div class="empty-state-container">
            <div class="empty-state-icon">📭</div>
            No appointments found.
          </div>
        </td>
      </tr>`;
        return;
    }

    tableBody.innerHTML = filteredList
        .map((appointment) => {
            const statusBadgeHTML =
                {
                    pending: `<span class="appointment-status-badge appointment-status-badge--pending">  <span class="appointment-status-dot"></span>Pending</span>`,
                    approved: `<span class="appointment-status-badge appointment-status-badge--approved"><span class="appointment-status-dot"></span>Confirmed</span>`,
                    completed: `<span class="appointment-status-badge appointment-status-badge--completed"><span class="appointment-status-dot"></span>Completed</span>`,
                    cancelled: `<span class="appointment-status-badge appointment-status-badge--cancelled"><span class="appointment-status-dot"></span>Cancelled</span>`,
                }[appointment.status] || "";

            let actionButtonsHTML = "";
            if (appointment.status === "pending") {
                actionButtonsHTML = `
                    <div style="display:flex; gap:6px; flex-wrap:nowrap;">
                        <button class="row-action-button row-action-button--approve"  onclick="openapproveationModal(${appointment.id}, 'approve')">Confirm</button>
                        <button class="row-action-button row-action-button--cancel"   onclick="openapproveationModal(${appointment.id}, 'cancel')">Cancel</button>
                    </div>`;
            } else if (appointment.status === "approved") {
                actionButtonsHTML = `
                    <div style="display:flex; gap:4px; flex-wrap:none;">
                        <button class="row-action-button row-action-button--complete" onclick="openapproveationModal(${appointment.id}, 'complete')">Complete</button>
                        <button class="row-action-button row-action-button--cancel"   onclick="openapproveationModal(${appointment.id}, 'cancel')">Cancel</button>
                    </div>`;
            } else {
                actionButtonsHTML = `<span style="color:#94a3b8;font-size:13px;">&mdash;</span>`;
            }

            return `
      <tr>
        <td class="patient-name">${appointment.patient}</td>
        <td>${appointment.date}</td>
        <td>${appointment.time}</td>
        <td>${appointment.reason}</td>
        <td>${statusBadgeHTML}</td>
        <td><div class="appointment-row-actions">${actionButtonsHTML}</div></td>
      </tr>`;
        })
        .join("");
}

const MODAL_CONFIG = {
    approve: {
        icon: "🔵",
        title: "Confirm Appointment",
        description:
            "Confirming this appointment will notify the patient that their slot is locked in.",
        submitButtonText: "Confirm",
        submitButtonColor: "modal-submit-button--blue",
        showMessageField: true,
        messageLabel: "Message to patient (optional)",
        messagePlaceholder:
            "e.g. Please arrive 10 minutes early and bring your previous reports.",
    },
    complete: {
        icon: "✅",
        title: "Mark as Completed",
        submitButtonText: "Mark Complete",
        submitButtonColor: "modal-submit-button--green",
        showMessageField: false,
        messageLabel: "",
        messagePlaceholder: "",
    },
    cancel: {
        icon: "❌",
        title: "Cancel Appointment",
        submitButtonText: "Cancel Appointment",
        submitButtonColor: "modal-submit-button--red",
        showMessageField: true,
        messageLabel: "Reason for cancellation (optional)",
        messagePlaceholder: "e.g. Schedule conflict, patient request…",
    },
};

function openapproveationModal(appointmentId, actionType) {
    const appointment = appointments.find((a) => a.id === appointmentId);
    if (!appointment) return;

    pendingModalAction = { id: appointmentId, action: actionType };

    const config = MODAL_CONFIG[actionType];
    const messageFieldEl = document.getElementById("mReasonWrap");
    const messageLabelEl = document.getElementById("mReasonLabel");
    const messageTextarea = document.getElementById("mReason");
    const submitButton = document.getElementById("mActionBtn");

    document.getElementById("mIcon").textContent = config.icon;
    document.getElementById("mTitle").textContent = config.title;
    document.getElementById("mDesc").textContent = config.description;
    document.getElementById("mInfo").innerHTML =
        `<strong>${appointment.patient}</strong>
     ${appointment.date} &middot; ${appointment.time} &middot; ${appointment.reason}`;

    messageFieldEl.style.display = config.showMessageField ? "block" : "none";
    if (config.showMessageField) {
        messageLabelEl.textContent = config.messageLabel;
        messageTextarea.placeholder = config.messagePlaceholder;
    }
    messageTextarea.value = "";

    submitButton.textContent = config.submitButtonText;
    submitButton.className = "modal-submit-button " + config.submitButtonColor;

    document.getElementById("modalBg").classList.add("open");
}

function closeModal() {
    document.getElementById("modalBg").classList.remove("open");
    pendingModalAction = null;
}

document.getElementById("modalBg").addEventListener("click", function (event) {
    if (event.target === this) closeModal();
});

async function doAction() {
    if (!pendingModalAction) return;

    const { id, action } = pendingModalAction;
    const appointment = appointments.find((a) => a.id === id);
    if (!appointment) return;

    const messageInput = document.getElementById("mReason");
    const doctorMessage = messageInput ? messageInput.value.trim() : "";

    try {
        const result = await apiPost(
            "/api/appointment-status",
            {
                id: id,
                status:
                    action === "approve"
                        ? "approved"
                        : action === "cancel"
                          ? "cancelled"
                          : action === "complete"
                            ? "completed"
                            : action,
                message: doctorMessage,
            },
            true,
        );

        if (result.status !== "success") {
            alert("Problem updating appointment. Please try again.");
            return;
        }

        const newStatusMap = {
            approve: "approved",
            complete: "completed",
            cancel: "cancelled",
        };
        appointment.status = newStatusMap[action];

        const toastTypeMap = {
            approve: "info",
            complete: "success",
            cancel: "error",
        };
        const toastMessageMap = {
            approve: `Appointment approved for ${appointment.patient}`,
            complete: `Appointment marked as completed`,
            cancel: `Appointment cancelled for ${appointment.patient}`,
        };

        closeModal();
        renderAppointmentsTable();
        showToastNotification(toastTypeMap[action], toastMessageMap[action]);
    } catch (err) {
        console.error("error:", err);
        alert("Failed to update appointment. Please try again.");
    }
}

function renderPatientsList() {
    const listContainer = document.getElementById("patientList");

    if (!patients.length) {
        listContainer.innerHTML = `<p style="color:#94a3b8;text-align:center;padding:20px;">No patients found.</p>`;
        return;
    }

    listContainer.innerHTML = patients
        .map(
            (patient, index) => `
    <div>
      <div class="patient-list-row">
        <div class="patient-initials-avatar">${patient.avatar}</div>
        <div class="patient-basic-info">
          <div class="patient-full-name">${patient.name}</div>
        </div>
      </div>
    </div>
  `,
        )
        .join("");
}

function renderReportsPage() {
    const totalAppointments = appointments.length;
    const completedCount = appointments.filter(
        (a) => a.status === "completed",
    ).length;
    const pendingCount = appointments.filter(
        (a) => a.status === "pending",
    ).length;
    const approvedCount = appointments.filter(
        (a) => a.status === "approved",
    ).length;
    const completionPercentage = totalAppointments
        ? Math.round(
              ((completedCount + approvedCount) / totalAppointments) * 100,
          )
        : 0;

    document.getElementById("rTotal").textContent = totalAppointments;
    document.getElementById("rCompleted").textContent =
        completedCount + approvedCount;
    document.getElementById("rPending").textContent = pendingCount;
    document.getElementById("rPatients").textContent = patients.length;

    document.getElementById("progBar").style.width = completionPercentage + "%";
    document.getElementById("progPct").textContent = completionPercentage + "%";

    document.getElementById("legCompleted").textContent =
        "Completed: " + completedCount;
    document.getElementById("legPending").textContent =
        "Pending: " + pendingCount;
    document.getElementById("legapproved").textContent =
        "approved: " + approvedCount;
}

function renderDoctorProfile() {
    document.getElementById("profBannerName").textContent = doctor.name;
    document.getElementById("profBannerSpec").textContent = doctor.spec;
    document.getElementById("pfName").textContent = doctor.name;
    document.getElementById("pfSpec").textContent = doctor.spec;
    document.getElementById("pfEmail").textContent = doctor.email;
    document.getElementById("pfPhone").textContent = doctor.phone;
}

function toggleEditForm() {
    const editFormEl = document.getElementById("editForm");
    editFormEl.classList.toggle("open");

    if (editFormEl.classList.contains("open")) {
        document.getElementById("ef-name").value = doctor.name;
        document.getElementById("ef-spec").value = doctor.spec;
        document.getElementById("ef-email").value = doctor.email;
        document.getElementById("ef-phone").value = doctor.phone;
    }
}

async function saveProfile() {
    const newName = document.getElementById("ef-name").value.trim();
    const newSpec = document.getElementById("ef-spec").value.trim();
    const newEmail = document.getElementById("ef-email").value.trim();
    const newPhone = document.getElementById("ef-phone").value.trim();

    try {
        await apiPost(
            "/api/update-profile",
            {
                name: newName,
                email: newEmail,
                phone: newPhone,
            },
            true,
        );
    } catch (e) {
        console.warn("Profile update error:", e);
    }

    if (newName) doctor.name = newName;
    if (newSpec) doctor.spec = newSpec;
    if (newEmail) doctor.email = newEmail;
    if (newPhone) doctor.phone = newPhone;

    renderDoctorProfile();
    document.getElementById("editForm").classList.remove("open");
    showToastNotification("success", "Profile updated successfully");
}

function showToastNotification(type, message) {
    const iconMap = { success: "✅", error: "❌", info: "ℹ️" };
    const container = document.getElementById("toasts");

    const toastEl = document.createElement("div");
    toastEl.className = `toast-notification toast-notification--${type}`;
    toastEl.innerHTML = `<span>${iconMap[type] || ""}</span>${message}`;
    container.appendChild(toastEl);

    setTimeout(() => {
        toastEl.classList.add("removing");
        setTimeout(() => toastEl.remove(), 300);
    }, 3000);
}

async function loadTodayAppointments(clickedButton) {
    isTodayMode = true;
    document
        .querySelectorAll(".appointments-filter-button")
        .forEach((b) => b.classList.remove("active"));
    clickedButton.classList.add("active");
    try {
        const data = await apiGet("/api/today-appointments");
        if (data.status === "success") {
            appointments = data.data.map((appt) => {
                const patientName = appt.patient
                    ? (appt.patient.first_name || "") +
                      " " +
                      (appt.patient.last_name || "")
                    : "Patient";

                return {
                    id: appt.id,
                    patient: patientName.trim() || "Patient",
                    avatar: patientName
                        .split(" ")
                        .map((n) => n[0])
                        .join("")
                        .toUpperCase()
                        .slice(0, 2),
                    date: appt.date || "",
                    time: (appt.time || "").slice(0, 5),
                    reason: appt.notes || "—",
                    status:
                        appt.status === "approved"
                            ? "approved"
                            : appt.status === "cancelled"
                              ? "cancelled"
                              : appt.status === "completed"
                                ? "completed"
                                : appt.status || "pending",
                };
            });
        }
        renderAppointmentsTable();
    } catch (err) {
        console.error("error:", err);
        alert("Failed to load today's appointments. Please try again later.");
    }
}

async function generateAppointmentsPDF() {
    try {
        const completedAppointments = appointments.filter(
            (a) => a.status === "completed",
        );

        if (!completedAppointments.length) {
            alert("No completed appointments found.");
            return;
        }

        const { jsPDF } = window.jspdf;

        const doc = new jsPDF();

        doc.setFontSize(18);
        doc.text("Completed Appointments Report", 14, 20);

        doc.setFontSize(11);
        doc.text(`Doctor: ${doctor.name}`, 14, 30);

        doc.text(`Generated: ${new Date().toLocaleDateString()}`, 14, 37);

        const tableData = completedAppointments.map((appt, index) => [
            index + 1,
            appt.patient,
            appt.date,
            appt.time,
            appt.reason,
        ]);

        doc.autoTable({
            startY: 45,
            head: [["#", "Patient", "Date", "Time", "Details"]],
            body: tableData,
            styles: {
                fontSize: 10,
            },
            headStyles: {
                fillColor: [41, 128, 185],
            },
        });

        doc.save("Completed_Appointments_Report.pdf");

        showToastNotification("success", "PDF report downloaded successfully");
    } catch (err) {
        console.error(err);
        alert("Failed to generate PDF.");
    }
}

async function generateAppointmentsPDF() {
    try {
        if (!appointments.length) {
            alert("No appointments found.");
            return;
        }

        const { jsPDF } = window.jspdf;

        const doc = new jsPDF();

        doc.setFontSize(18);
        doc.text("All Appointments Report", 14, 20);

        doc.setFontSize(11);
        doc.text(`Doctor: ${doctor.name}`, 14, 30);

        doc.text(`Generated: ${new Date().toLocaleDateString()}`, 14, 37);

        const tableData = appointments.map((appt, index) => [
            index + 1,
            appt.patient,
            appt.date,
            appt.time,
            appt.reason,
            appt.status,
        ]);

        doc.autoTable({
            startY: 45,
            head: [["#", "Patient", "Date", "Time", "Details", "Status"]],
            body: tableData,
            styles: {
                fontSize: 10,
            },
            headStyles: {
                fillColor: [41, 128, 185],
            },
        });

        doc.save("All_Appointments_Report.pdf");

        showToastNotification(
            "success",
            "Appointments report downloaded successfully",
        );
    } catch (err) {
        console.error(err);
        alert("Failed to generate PDF.");
    }
}

async function generatePatientsPDF() {
    try {
        if (!patients.length) {
            alert("No patients found.");
            return;
        }

        const { jsPDF } = window.jspdf;

        const doc = new jsPDF();

        doc.setFontSize(18);
        doc.text("All Patients Report", 14, 20);

        doc.setFontSize(11);

        doc.text(`Doctor: ${doctor.name}`, 14, 30);

        doc.text(`Generated: ${new Date().toLocaleDateString()}`, 14, 37);

        const tableData = patients.map((patient, index) => [
            index + 1,
            patient.name,
            patient.avatar,
        ]);

        doc.autoTable({
            startY: 45,
            head: [["#", "Patient Name", "Avatar"]],
            body: tableData,
            styles: {
                fontSize: 10,
            },
            headStyles: {
                fillColor: [46, 204, 113],
            },
        });

        doc.save("All_Patients_Report.pdf");

        showToastNotification(
            "success",
            "Patients report downloaded successfully",
        );
    } catch (err) {
        console.error(err);
        alert("Failed to generate PDF.");
    }
}

initDashboard();
