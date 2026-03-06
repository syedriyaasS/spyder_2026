// Unified functions for all gallery years to ensure consistent behavior and fix variable conflicts.

function openFullScreen(yearId) {
  const fullView = document.getElementById("fullView" + yearId);
  const fullViewImage = document.getElementById("fullViewImage" + yearId);
  const mainImage = document.getElementById("mainImage" + yearId);

  if (fullView && fullViewImage && mainImage) {
    fullView.style.display = "flex";
    fullViewImage.src = mainImage.src;
    document.body.style.overflow = "hidden";

    // Store current view for zoom and escape key functionality
    window.currentFullView = fullView;
    window.currentFullViewImage = fullViewImage;
  }
}

function closeFullScreen() {
  if (window.currentFullView) {
    window.currentFullView.style.display = "none";
    document.body.style.overflow = "auto";
    resetZoom();
    window.currentFullView = null;
    window.currentFullViewImage = null;
  }
}

// Map old function names to the unified one for compatibility with HTML
function openFullScreen6() { openFullScreen('6'); }
function openFullScreen5() { openFullScreen('5'); }
function openFullScreen1() { openFullScreen('1'); }
function openFullScreen2() { openFullScreen('2'); }
function openFullScreen3() { openFullScreen('3'); }
function openFullScreen4() { openFullScreen('4'); }

function replaceMainImage(yearId, thumbnail) {
  const mainImage = document.getElementById("mainImage" + yearId);
  if (!mainImage) return;

  const mainParent = mainImage.parentElement;
  const thumbParent = thumbnail.parentElement;

  // Swap elements in DOM
  mainParent.appendChild(thumbnail);
  thumbParent.appendChild(mainImage);

  // Sync classes, IDs, alt and event handlers
  const tempClass = mainImage.className;
  const tempOnclick = mainImage.onclick;
  const tempId = mainImage.id;
  const tempAlt = mainImage.alt;
  const tempMdb = mainImage.getAttribute('data-mdb-img');

  mainImage.className = thumbnail.className;
  mainImage.onclick = thumbnail.onclick;
  mainImage.id = "";
  mainImage.alt = thumbnail.alt;
  if (thumbnail.getAttribute('data-mdb-img')) {
    mainImage.setAttribute('data-mdb-img', thumbnail.getAttribute('data-mdb-img'));
  } else {
    mainImage.removeAttribute('data-mdb-img');
  }

  thumbnail.className = tempClass;
  thumbnail.onclick = tempOnclick;
  thumbnail.id = tempId;
  thumbnail.alt = tempAlt;
  if (tempMdb) {
    thumbnail.setAttribute('data-mdb-img', tempMdb);
  } else {
    thumbnail.removeAttribute('data-mdb-img');
  }
}

// Specialized functions for each year (physical element swap)
function replaceMainImage6(thumbnail) { replaceMainImage('6', thumbnail); }
function replaceMainImage5(thumbnail) { replaceMainImage('5', thumbnail); }
function replaceMainImage1(thumbnail) { replaceMainImage('1', thumbnail); }
function replaceMainImage2(thumbnail) { replaceMainImage('2', thumbnail); }
function replaceMainImage3(thumbnail) { replaceMainImage('3', thumbnail); }
function replaceMainImage4(thumbnail) { replaceMainImage('4', thumbnail); }

// Global event listener for Escape key
document.addEventListener("keydown", function (event) {
  if (event.key === "Escape") {
    closeFullScreen();
  }
});

// Zoom-in Functionality
var zoomLevel = 1;

function resetZoom() {
  zoomLevel = 1;
  if (window.currentFullViewImage) {
    window.currentFullViewImage.style.transform = "scale(" + zoomLevel + ")";
  }
}

function zoomIn() {
  zoomLevel += 0.2;
  if (window.currentFullViewImage) {
    window.currentFullViewImage.style.transform = "scale(" + zoomLevel + ")";
  }
}

function zoomOut() {
  if (zoomLevel > 1) {
    zoomLevel -= 0.2;
    if (window.currentFullViewImage) {
      window.currentFullViewImage.style.transform = "scale(" + zoomLevel + ")";
    }
  }
}

// Handle zoom with mouse wheel on the image
document.addEventListener("wheel", function (event) {
  if (window.currentFullViewImage && window.currentFullView.style.display === "flex") {
    // Only zoom if the mouse is over the full view image area
    if (event.target === window.currentFullViewImage || window.currentFullView.contains(event.target)) {
      event.preventDefault();
      if (event.deltaY < 0) {
        zoomIn();
      } else {
        zoomOut();
      }
    }
  }
}, { passive: false });
