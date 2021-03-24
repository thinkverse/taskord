
// Load shortcuts
var shortcutsModal = document.getElementById("shortcutsModal");
shortcutsModal.addEventListener("shown.bs.modal", async () => {
  var shortcutsModalBody = document.getElementById("shortcutsModalBody");
  const res = await window.fetch(`/site/shortcuts`);
  shortcutsModalBody.innerHTML = await res.text();
});

// Load Cache
var cacheModal = document.getElementById("cacheModal");
if (cacheModal) {
  cacheModal.addEventListener("shown.bs.modal", async () => {
    var cacheModalBody = document.getElementById("cacheModalBody");
    const res = await window.fetch(`/site/cache-hits`);
    cacheModalBody.innerHTML = await res.text();
  });
}

// Load Commit Data
var deployModal = document.getElementById("deployModal");
if (deployModal) {
  deployModal.addEventListener("shown.bs.modal", async () => {
    var deployModalCommitBody = document.getElementById("deployModalCommitBody");
    const res = await window.fetch(`/site/commit-data`);
    deployModalCommitBody.innerHTML = await res.text();
  });
}
