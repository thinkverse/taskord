import { getLCP, getFID, getCLS, getFCP, getTTFB } from 'web-vitals';

console.log(
  `%c🚀 Taskord stafftools turned on`,
  "color: #38c172; font-family: monospace; font-size: 20px; font-weight: bold"
);

function logInConsole({ name, delta }) {
  console.log(
    `%c[${name}] %c${parseFloat(name === 'CLS' ? delta * 1000 : delta).toFixed(2)}`,
    "color: #6a63ec; font-family: monospace; font-size: 15px; font-weight: bold",
    "font-family: monospace; font-size: 15px; font-weight: bold",
  );
}

getCLS(logInConsole);
getFID(logInConsole);
getLCP(logInConsole);
getFCP(logInConsole);

// Toggle stats in adminbar
var expandStats = document.getElementById("expand-stats");
if (expandStats) {
  expandStats.addEventListener("click", async () => {
    document.getElementById("staffbar-stats").classList.toggle('d-none');
  });
}
