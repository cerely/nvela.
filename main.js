// =============================
// 🌙 THEME SWITCHER
// =============================
const themeRadios = document.querySelectorAll('input[name="theme"]');

function updateTheme(theme) {
  document.documentElement.setAttribute("data-theme", theme);
}

themeRadios.forEach(radio => {
  radio.addEventListener("change", e => {
    const theme = e.target.value;

    if (!document.startViewTransition) {
      updateTheme(theme);
      return;
    }

    // Animated transition (Chrome/Edge support)
    document.startViewTransition(() => updateTheme(theme));
  });
});

// =============================
// 🧠 CURRENT SUBJECT FETCHER
// =============================
function fetchCurrentSubject() {
  fetch('http://localhost/NVELAMAIN/get_subject.php')
    .then(response => response.json())
    .then(data => {
      const subjectElement = document.getElementById("current-subject");

      if (data.subject_name && data.subject_name !== "No Subject") {
        const start = data.start_time
          ? new Date(data.start_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
          : '';
        const end = data.end_time
          ? new Date(data.end_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
          : '';

        subjectElement.textContent = `${data.subject_name} (${start} - ${end})`;
        subjectElement.style.color = "var(--accent-color, #433B42)";
      } else {
        subjectElement.textContent = "No Subject currently";
        subjectElement.style.color = "var(--text-secondary, #888)";
      }
    })
    .catch(err => {
      console.error("Error fetching subject:", err);
      const subjectElement = document.getElementById("current-subject");
      subjectElement.textContent = "Error fetching subject";
      subjectElement.style.color = "red";
    });
}

// =============================
// 🧍 ATTENDANCE FETCHER
// =============================
const studInfo = document.querySelector(".stud-info");

async function fetchCurrentAttendance() {
  try {
    const res = await fetch("http://10.169.34.71/NVELAMAIN/get_current_attendance.php");
    const data = await res.json();

    studInfo.innerHTML = ""; // clear old data

    // Handle no subject or no data cases
    if (data.message && data.message.includes("No subject")) {
      studInfo.innerHTML = `<p style="opacity:0.6; text-align:center;">No class currently</p>`;
      return;
    }

    if (data.message && data.message.includes("No attendance")) {
      studInfo.innerHTML = `<p style="opacity:0.6; text-align:center;">${data.message}</p>`;
      return;
    }

    if (!data.attendance || data.attendance.length === 0) {
      studInfo.innerHTML = `<p style="opacity:0.6; text-align:center;">No attendance data available</p>`;
      return;
    }

    // Render student cards
    data.attendance.forEach((record, index) => {
      const checkinTime = record.checkin ? record.checkin.substring(0, 5) : "--:--";
      const name = record.student_name || `Student ${index + 1}`;

      const studentCard = document.createElement("div");
      studentCard.classList.add("student-1");
      studentCard.innerHTML = `
        <div class="profile-att">
          <img class="prof" src="./images/user.png" alt="">
        </div>
        <div class="prof-info">
          <p>${name}</p>
          <p>${checkinTime}</p>
        </div>
      `;
      studInfo.appendChild(studentCard);
    });

  } catch (err) {
    console.error("Error fetching attendance:", err);
    studInfo.innerHTML = `<p style="color:red; text-align:center;">Error fetching data</p>`;
  }
}

// =============================
// 📁 RECENTLY UPLOADED FILES FETCHER
// =============================
function fetchRecentFiles() {
  const fileList = document.getElementById("file-list");
  const fileSize = document.getElementById("file-size");

  if (!fileList || !fileSize) return; // safety check

  fetch("http://10.169.34.71/NVELAMAIN/get_documents.php")
    .then(response => response.json())
    .then(data => {
      if (!Array.isArray(data) || data.length === 0) {
        fileList.innerHTML = "<p>No files found.</p>";
        fileSize.innerHTML = "<p>—</p>";
        return;
      }

      fileList.innerHTML = "";
      fileSize.innerHTML = "";

      data.forEach(doc => {
        const fileP = document.createElement("p");
        const sizeP = document.createElement("p");

        // ✅ clickable link for each filename
        const link = document.createElement("a");
        link.href = doc.filepath;
        link.textContent = doc.filename;
        link.target = "_blank";
        link.style.textDecoration = "none";
        link.style.color = "inherit";

        fileP.appendChild(link);
        sizeP.textContent = "—"; // optional placeholder for size

        fileList.appendChild(fileP);
        fileSize.appendChild(sizeP);
      });
    })
    .catch(err => {
      console.error("Error fetching documents:", err);
      fileList.innerHTML = "<p style='color:red;'>Error loading files</p>";
      fileSize.innerHTML = "<p>—</p>";
    });
}

// =============================
// 🌬️ FAN TOGGLE CONTROL
// =============================
async function sendCommand(command) {
      document.getElementById('status').textContent = "Sending command...";
      try {
        const res = await fetch(`http://10.95.134.212:5000/fan/${command}`, {
          method: "POST"
        });
        const data = await res.text();
        document.getElementById('status').textContent = "Status: " + data;
      } catch (error) {
        document.getElementById('status').textContent = "Error sending command!";
        console.error(error);
      }
    }

// =============================
// ⏰ INITIALIZE ON PAGE LOAD
// =============================
document.addEventListener("DOMContentLoaded", () => {
  fetchCurrentSubject();
  fetchCurrentAttendance();
  fetchRecentFiles();

  // Auto-refresh every 1 minute
  setInterval(fetchCurrentSubject, 60000);
  setInterval(fetchCurrentAttendance, 60000);
  setInterval(fetchRecentFiles, 60000);
});
