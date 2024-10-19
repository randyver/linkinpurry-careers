function handleFileUpload(type) {
  const fileInput = document.getElementById(`upload-${type}`);
  const fileNameDisplay = document.getElementById(`${type}-name`);
  const removeButton = document.getElementById(`${type}-remove`);

  if (fileInput.files.length > 0) {
      const fileName = fileInput.files[0].name;
      fileNameDisplay.textContent = fileName;  // Display file name
      removeButton.style.display = 'inline';   // Show remove button
  }
}

function removeFile(type) {
  const fileInput = document.getElementById(`upload-${type}`);
  const fileNameDisplay = document.getElementById(`${type}-name`);
  const removeButton = document.getElementById(`${type}-remove`);

  fileInput.value = '';  // Clear the file input
  fileNameDisplay.textContent = `Upload ${type === 'cv' ? 'CV' : 'Introduction Video'}`;  // Reset display text
  removeButton.style.display = 'none';  // Hide remove button
}