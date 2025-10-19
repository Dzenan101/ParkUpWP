// /frontend/js/app.js
const app = document.getElementById('app');

async function loadView(view) {
  try {
    const res = await fetch(`views/${view}.html`);
    const html = await res.text();
    app.innerHTML = html;
  } catch (error) {
    app.innerHTML = "<h2>Page not found</h2>";
  }
}

function router() {
  let hash = window.location.hash.substring(1);
  if (hash === '') hash = 'home'; // default view
  loadView(hash);
}

window.addEventListener('hashchange', router);
window.addEventListener('load', router);
