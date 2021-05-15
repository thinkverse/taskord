import hotkeys from "hotkeys-js";

// Admin Bar
hotkeys("p+b, `", async () => {
  const res = await window.fetch(`/site/adminbar`);
  if (res.status === 200) {
    location.reload();
  }
});

// Dark Mode
hotkeys("d+m", async () => {
  const res = await window.fetch(`/darkmode`);
  if (res.status === 200) {
    location.reload();
  }
});

// Go to home
hotkeys("g+h", () => {
  window.location.href = "/";
});

// Go to user profile
hotkeys("g+u", () => {
  const username = document.getElementById("taskord-username").innerHTML.trim();
  window.location.href = "/@" + username;
});

// Go to products
hotkeys("g+p", () => {
  window.location.href = "/products";
});

// Go to questions
hotkeys("g+q", () => {
  window.location.href = "/questions";
});

// Go to notifications
hotkeys("g+n", () => {
  window.location.href = "/notifications";
});

// Go to settings
hotkeys("g+s", () => {
  window.location.href = "/settings";
});

// New Task Modal
var newTaskModal = document.getElementById("newTaskModal");
if (newTaskModal != null) {
  hotkeys("n", async () => {
    (new bootstrap.Modal(newTaskModal)).show();
  });
}

// Deploy Modal
var deployModal = document.getElementById("deployModal");
if (deployModal != null) {
  hotkeys("shift+d", async () => {
    (new bootstrap.Modal(deployModal)).show();
  });
}
