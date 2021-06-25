// Load shortcuts
const shortcutsModal = document.getElementById("shortcutsModal");
shortcutsModal.addEventListener("shown.bs.modal", async () => {
  const shortcutsModalBody = document.getElementById("shortcutsModalBody");
  const res = await window.fetch("/site/shortcuts");
  shortcutsModalBody.innerHTML = await res.text();
});

// Load Data from GitLab
const deployModal = document.getElementById("deployModal");
if (deployModal) {
  // Load Commit Data
  deployModal.addEventListener("shown.bs.modal", async () => {
    const deployModalCommitBody = document.getElementById("deployModalCommitBody");
    const res = await window.fetch("/site/commits-data");
    deployModalCommitBody.innerHTML = await res.text();
  });

  // Load CI Data
  deployModal.addEventListener("shown.bs.modal", async () => {
    const deployModalCIBody = document.getElementById("deployModalCIBody");
    const res = await window.fetch("/site/ci-data");
    deployModalCIBody.innerHTML = await res.text();
  });

  // Load Deployment Data
  deployModal.addEventListener("shown.bs.modal", async () => {
    const deployModalDeploymentBody = document.getElementById("deployModalDeploymentBody");
    const res = await window.fetch("/site/deployment-data");
    deployModalDeploymentBody.innerHTML = await res.text();
  });
}
