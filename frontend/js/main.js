console.log("main.js loaded");

const routes = {
  home: "home.html",
  login: "login.html",
  register: "register.html",
  parkinglots: "parkinglots.html",
  reservations: "reservations.html",
};

async function renderRoute() {
  const hash = (window.location.hash || "#home").replace("#", "");
  const view = routes[hash] || routes.home;

  try {
    const res = await fetch(`views/${view}`);
    if (!res.ok) throw new Error(`View not found: views/${view}`);
    const html = await res.text();
    document.getElementById("app").innerHTML = html;

    // if you have auth handlers that must be attached after loading HTML
    if (typeof attachAuthHandlers === "function") attachAuthHandlers();
  } catch (err) {
    console.error(err);
    document.getElementById("app").innerHTML =
      `<p style="color:red;">Error loading view: ${view}</p>`;
  }
}

window.addEventListener("hashchange", renderRoute);
window.addEventListener("DOMContentLoaded", renderRoute);
