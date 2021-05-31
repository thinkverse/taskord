import { getLCP, getFID, getCLS, getFCP, getTTFB } from 'web-vitals';

function logInConsole({ name, delta }) {
  console.log(
    `%c${name}: ${delta}`,
    "color: #6a63ec; font-family: monospace; font-size: 15px; font-weight: bold"
  );
}

getCLS(logInConsole);
getFID(logInConsole);
getLCP(logInConsole);
getFCP(logInConsole);
getTTFB(logInConsole);

// Toggle stats in adminbar
var expandStats = document.getElementById("expand-stats");
if (expandStats) {
  expandStats.addEventListener("click", async () => {
    document.getElementById("staffbar-stats").classList.toggle('d-none');
  });
}
