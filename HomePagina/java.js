
// zet de false naar true om de pagina in constructie te zetten
let siteUnderConstruction = false;

function showErrorMessage() {
if (siteUnderConstruction) {
  document.getElementById('overlay').style.display = 'flex'; 
}
}

window.onload = function() {
showErrorMessage();
};