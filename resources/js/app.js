require('./sentry');
require("./shortcuts");
require("./tribute");
require("./tippy");
require('./clipboard');
require('./site');
import { isInViewport } from "observe-element-in-viewport";

// Greetings
console.log(
  "%cTaskord",
  `
    color:#6a63ec;
    font-size: 50px;
    font-weight: bold;
    -webkit-text-stroke: 0.5px white;
  `
);

document.addEventListener("DOMContentLoaded", async () => {
  // Pagination
  Livewire.hook("component.initialized", () => {
    window.addEventListener("scroll", () => {
      var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
      var loadMore = document.getElementById("load-more");
      if (scrollTop + window.innerHeight > document.documentElement.scrollHeight - 100) {
        if (loadMore != null) {
          loadMore.click();
          loadMore.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
          loadMore.disabled = true;
        }
      }
    });
  });

  // Initial Pagination
  var loadMore = document.getElementById("load-more");
  if (loadMore && await isInViewport(loadMore)) {
    if (loadMore != null) {
      loadMore.click();
      loadMore.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
      loadMore.disabled = true;
    }
  }
});

// Admin Bar toggle in dropdown
var adminBar = document.getElementById("admin-bar-click");
if (adminBar) {
  adminBar.addEventListener("click", async () => {
    const res = await window.fetch(`/stafftools/adminbar`);
    if (res.status === 200) {
      window.location.reload();
    }
  });
}

// Dark mode toggle in dropdown
var darkMode = document.getElementById("dark-mode");
if (darkMode) {
  darkMode.addEventListener("click", async () => {
    const res = await window.fetch(`/darkmode`);
    if (res.status === 200) {
      window.location.reload();
    }
  });
}
