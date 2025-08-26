document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ JS loaded");

    const openFolder = document.getElementById("openFolder");  
    const openTitle = document.getElementById("openTitle");    
    const modalFileGrid = document.getElementById("modalFileGrid");
    const modalDropzone = document.getElementById("modalDropzone");
    const modalUploadInput = document.getElementById("modalUploadInput");
    const uploadForm = document.getElementById("uploadForm");
    const closeModalBtn = document.querySelector(".close-modal");
    const docsIcon = document.querySelector(".folder img");    
    const fileList = document.getElementById("fileList"); // optional separate list

    let folders = [{ name: "Documents", files: [] }];
    let currentFolder = 0;
    let openWindows = [];
    let zIndex = 10000;

    // 🕒 Clock
    function updateClock() {
        const timeEl = document.querySelector(".time");
        if (!timeEl) return;
        const now = new Date();
        let hours = now.getHours();
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; 
        timeEl.textContent = `${hours}:${minutes} ${ampm}`;
    }
    updateClock();
    setInterval(updateClock, 60000);

    // 📂 Open modal
    if (docsIcon) {
        docsIcon.addEventListener("click", () => {
            openTitle.textContent = folders[currentFolder].name;
            loadFiles(); // load DB files instead of local only
            openFolder.style.display = "flex";
            openFolder.style.opacity = "0";
            setTimeout(() => openFolder.style.opacity = "1", 10);
        });
    }

    // ❌ Close modal
    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", () => {
            openFolder.style.opacity = "0";
            setTimeout(() => openFolder.style.display = "none", 300);
        });
    }

    // 📤 Upload (form submit)
    if (uploadForm) {
        uploadForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            console.log("📤 Upload form submitted");

            const form = new FormData(uploadForm);
            try {
                const res = await fetch("api/upload.php", {
                    method: "POST",
                    body: form
                });
                if (!res.ok) throw new Error("Upload failed");

                const result = await res.json();
                if (result.success) {
                    console.log("✅ Upload success");
                    uploadForm.reset();
                    loadFiles(); // reload DB files
                } else {
                    alert("❌ Upload error: " + (result.error || "Unknown error"));
                }
            } catch (err) {
                console.error("❌ Upload error:", err);
                alert("Upload failed, check console.");
            }
        });
    }

    // 🖱️ Drag & Drop
    modalDropzone.addEventListener("dragover", (e) => {
        e.preventDefault();
        modalDropzone.classList.add("dragover");
    });
    modalDropzone.addEventListener("dragleave", () => modalDropzone.classList.remove("dragover"));
    modalDropzone.addEventListener("drop", (e) => {
        e.preventDefault();
        modalDropzone.classList.remove("dragover");
        handleUploadFiles(Array.from(e.dataTransfer.files));
    });

    // 📤 Local preview only (optional)
    function handleUploadFiles(files) {
        files.forEach(file => {
            if (!file.type.startsWith("image/") && file.type !== "application/pdf") {
                alert(`❌ Unsupported: ${file.name}`);
                return;
            }
            const fileURL = URL.createObjectURL(file);
            const type = file.type.startsWith("image/") ? "image" : "pdf";
            folders[currentFolder].files.push({ name: file.name, url: fileURL, type });
        });
        renderLocalFiles(currentFolder);
    }

    // 🗂️ Render local preview files (dragged ones)
    function renderLocalFiles(folderIndex) {
        modalFileGrid.innerHTML = "";
        folders[folderIndex].files.forEach((file, idx) => {
            const card = document.createElement("div");
            card.className = "file-card";
            const thumb = (file.type === "image")
                ? `<img class="file-thumb" src="${file.url}">`
                : `<div class="file-thumb file-icon">📄</div>`;
            card.innerHTML = `${thumb}<span>${file.name}</span>`;
            card.addEventListener("click", () => openFileWindow(file));
            modalFileGrid.appendChild(card);
        });
    }

    // 📥 Fetch files from DB & render in modal grid
    async function loadFiles() {
        try {
            const res = await fetch("api/list_files.php");
            const files = await res.json();

            modalFileGrid.innerHTML = "";
            if (files.length === 0) {
                modalFileGrid.innerHTML = "<p>No files uploaded yet.</p>";
                return;
            }

            files.forEach(file => {
                const card = document.createElement("div");
                card.className = "file-card";
                card.innerHTML = `
                    <div class="file-thumb file-icon">📄</div>
                    <span>${file.filename}</span>
                `;
                card.addEventListener("click", () => {
                    openFileWindow({ name: file.filename, url: file.filepath, type: "pdf" });
                });
                modalFileGrid.appendChild(card);

                // also populate optional side list
                if (fileList) {
                    const div = document.createElement("div");
                    div.className = "file-item";
                    const link = document.createElement("a");
                    link.href = file.filepath;
                    link.target = "_blank";
                    link.textContent = file.filename;
                    div.appendChild(link);
                    fileList.appendChild(div);
                }
            });
        } catch (err) {
            console.error("❌ Failed to load files:", err);
        }
    }

    // 🪟 Open file in window
    function openFileWindow(file) {
        if (openWindows.length >= 10) { alert("❌ Max 10 windows!"); return; }
        const id = Date.now();
        const win = document.createElement("div");
        win.className = "window";
        win.style.left = (100 + openWindows.length * 30) + "px";
        win.style.top = (100 + openWindows.length * 30) + "px";

        win.innerHTML = `
            <div class="title-bar">
                ${file.name} 
                <button class="close-btn"><img src="icons/close.svg" alt=""></button>
            </div>
            <div class="file-container" id="content-${id}"><p>Loading...</p></div>
        `;
        document.body.appendChild(win);
        openWindows.push(win);

        win.querySelector(".close-btn").addEventListener("click", () => {
            win.remove();
            openWindows = openWindows.filter(w => w !== win);
        });

        makeDraggable(win);
        if (file.name.endsWith('pdf')) loadPdf(file.url, document.getElementById(`content-${id}`));
        else loadImage(file.url, document.getElementById(`content-${id}`));
    }

    // 🖱️ Make windows draggable
    function makeDraggable(win) {
        const bar = win.querySelector(".title-bar");
        let offsetX, offsetY, drag = false;
        bar.addEventListener("mousedown", (e) => {
            drag = true;
            offsetX = e.clientX - win.offsetLeft;
            offsetY = e.clientY - win.offsetTop;
            win.style.zIndex = ++zIndex;
        });
        document.addEventListener("mousemove", (e) => {
            if (drag) {
                win.style.left = (e.clientX - offsetX) + "px";
                win.style.top = (e.clientY - offsetY) + "px";
            }
        });
        document.addEventListener("mouseup", () => drag = false);
    }

    // 📑 PDF.js loader
    function loadPdf(url, container) {
        container.innerHTML = "";
        if (typeof pdfjsLib === "undefined") {
            container.innerHTML = "<p style='color:red;'>⚠️ PDF.js not loaded!</p>";
            return;
        }
        pdfjsLib.getDocument(url).promise.then(pdf => {
            for (let p = 1; p <= pdf.numPages; p++) {
                pdf.getPage(p).then(page => {
                    const scale = 1.1;
                    const viewport = page.getViewport({ scale });
                    const canvas = document.createElement("canvas");
                    const ctx = canvas.getContext("2d");
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;
                    container.appendChild(canvas);
                    page.render({ canvasContext: ctx, viewport });
                });
            }
        }).catch(err => container.innerHTML = `<p style="color:red;">${err.message}</p>`);
    }

    // 🖼️ Image loader
    function loadImage(url, container) {
        container.innerHTML = "";
        const img = document.createElement("img");
        img.src = url;
        container.appendChild(img);
    }

    // Initial load
    loadFiles();
});
