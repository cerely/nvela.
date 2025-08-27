<?php
include __DIR__ . "/../db.php";

// Fetch files from DB
$files = [];
$result = $conn->query("SELECT id, filename, filepath, tag FROM documents ORDER BY id DESC");
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $files[] = $row;
  }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>nv-doc</title>
  <link rel="stylesheet" href="nvela.css">
</head>
<body>
  <header>
    <nav>
      <div class="nav-icon">
        <a href="/main.html"><img class="icon" src="icons/left back1.svg" alt=""></a>
      </div>
      <p class="logo">nvela.</p>
      <div class="right">
        <div class="time"><p id="timeNow"></p></div>
        <div class="wifi"><img src="icons/wifi.svg" alt=""></div>
      </div>
    </nav>
  </header>
  <main>
    <div class="folder">
      <img src="./imgs/docs.png" alt="Document">
      <p class="folder-label">Documents</p>

      <div class="open-folder" id="openFolder">
        <div class="open-content">
          <div class="open-header">
            <span id="openTitle">Documents</span>
            <button class="close-modal"><img src="icons/close.svg" alt=""></button>
          </div>
          <div class="modal-body">

            <!-- Dropzone -->
            <div class="modal-dropzone" id="modalDropzone">Drag & Drop or Browse Files Here</div>

            <!-- Upload form -->
            <form id="uploadForm" enctype="multipart/form-data">
              <input type="file" id="modalUploadInput" name="file" accept="application/pdf,image/*" required>
              <input type="text" name="subject" placeholder="Enter tag (optional)">
              <button type="submit">Upload</button>
            </form>

            <!-- File Grid -->
            <div class="file-grid" id="modalFileGrid"
                 data-files='<?php echo json_encode($files); ?>'>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

<script src="http://localhost/NVELAMAIN/document/nvela.js?v=<?php echo time(); ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.9.179/pdf.min.js"></script>
</body>
</html>
