import { getLCP, getFID, getCLS, getFCP, getTTFB } from 'web-vitals';

function sendToGoogleAnalytics({ name, delta, id }) {
  ga('send', 'event', {
    eventCategory: 'Web Vitals',
    eventAction: name,
    eventLabel: id,
    eventValue: Math.round(name === 'CLS' ? delta * 1000 : delta),
    nonInteraction: true,
    transport: 'beacon',
  });
}

function logInConsole(metric) {
  const body = JSON.stringify({ [metric.name]: metric.value });
  console.log(
    `%c${metric.name}: ${metric.value}`,
    "color: #6a63ec; font-family: monospace; font-size: 15px; font-weight: bold"
  );
}

getCLS(sendToGoogleAnalytics);
getFID(sendToGoogleAnalytics);
getLCP(sendToGoogleAnalytics);
getFCP(sendToGoogleAnalytics);
getTTFB(sendToGoogleAnalytics);

// Toggle stats in adminbar
var expandStats = document.getElementById("expand-stats");
if (expandStats) {
  expandStats.addEventListener("click", async () => {
    document.getElementById("staffbar-stats").classList.toggle('d-none');
  });
}
