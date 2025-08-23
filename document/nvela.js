// Auto-upload when file chosen
document.getElementById("fileInput").addEventListener("change", async (e) => {
  const file = e.target.files[0];
  if (!file) return;

  const form = new FormData();
  form.append("file", file);

  await fetch("api/upload.php", { method: "POST", body: form });
  loadFiles();
});

// Fetch and display files from DB
async function loadFiles() {
  const res = await fetch("api/list_files.php");
  const files = await res.json();

  const list = document.getElementById("fileList");
  list.innerHTML = "";

  files.forEach(file => {
    const div = document.createElement("div");
    div.className = "file-item";

    // clickable link
    const link = document.createElement("a");
    link.href = file.filepath;
    link.target = "_blank";
    link.textContent = file.filename;

    div.appendChild(link);
    list.appendChild(div);
  });
}

loadFiles();
