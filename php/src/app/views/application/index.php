<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application</title>
    <link rel="stylesheet" href="../../../public/css/navbar/style.css">
    <link rel="stylesheet" href="../../../public/css/application/style.css">
    <link rel="icon" href="../../../public/images/logo-icon.svg" type="image/x-icon">
</head>
<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>
    <main class="application-container">
        <!-- content -->
        <div>
          <!-- back button -->
          <div class="back-button">
              <img src="../../../public/images/arrow-left.png" alt="back">
              <p>Job Detail</p>
          </div>
          
          <!-- content -->
          <div class="application-content">
              <!-- intro -->
              <div class="intro">
                  <h1>Fill in your application</h1>
                  <p>You’re one step closer to your dream job!</p>
              </div>
              
              <!-- form -->
              <div class="application-form">
                <div class="file-upload">
                    <!-- Upload CV -->
                    <div class="upload-container">
                        <label class="upload-button" for="upload-cv">
                            <img src="../../../public/images/upload.svg" alt="upload">
                            <p id="cv-name">Upload CV</p>
                        </label>
                        <input type="file" id="upload-cv" name="cv" accept=".pdf, .doc, .docx" style="display: none;" onchange="handleFileUpload('cv')">
                        <button id="cv-remove" class="remove-button" style="display:none;" onclick="removeFile('cv')">&times;</button>
                    </div>

                    <!-- Upload Introduction Video -->
                    <div class="upload-container">
                        <label class="upload-button" for="upload-video">
                            <img src="../../../public/images/upload.svg" alt="upload">
                            <p id="video-name">Upload Introduction Video</p>
                        </label>
                        <input type="file" id="upload-video" name="video" accept="video/*" style="display: none;" onchange="handleFileUpload('video')">
                        <button id="video-remove" class="remove-button" style="display:none;" onclick="removeFile('video')">&times;</button>
                    </div>
                </div>
                <button class="send-button">Send</button>
              </div>

          </div>
        </div>
        
        <!-- image -->
        <div class="application-image">
            <img src="../../../public/images/application-people.png" alt="application">
        </div>
    </main>
    <script src="../../../public/js/application.js"></script>
</body>
</html>
