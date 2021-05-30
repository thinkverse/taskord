import { getLCP, getFID, getCLS } from 'web-vitals';

function logInConsole(metric) {
    const body = JSON.stringify({ [metric.name]: metric.value });
    console.log(
        `%c${metric.name}: ${metric.value}`,
        "color: #6a63ec; font-family: monospace; font-size: 15px; font-weight: bold"
    );
}

getCLS(logInConsole);
getFID(logInConsole);
getLCP(logInConsole);
