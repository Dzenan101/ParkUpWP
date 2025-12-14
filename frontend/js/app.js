console.log("app.js loaded");

const app = document.getElementById("app");

/*
|--------------------------------------------------------------------------
| Load HTML views into <main id="app">
|--------------------------------------------------------------------------
*/
async function loadView(name) {
  try {
    const res = await fetch(`views/${name}.html`);
    if (!res.ok) throw new Error("View not found");

    const html = await res.text();
    app.innerHTML = html;

    // Attach login/register handlers AFTER HTML loads
    if (window.attachAuthHandlers) {
      window.attachAuthHandlers();
    }

    // Initialize page-specific logic
    await initPage(name);

  } catch (err) {
    console.error(err);
    app.innerHTML = `<p class="text-danger">Error loading view.</p>`;
  }
}

/*
|--------------------------------------------------------------------------
| Page Initializer (THIS WAS MISSING)
|--------------------------------------------------------------------------
*/
async function initPage(viewName) {
  switch (viewName) {

    case "parkinglots":
      if (window.renderParkingLots) {
        await window.renderParkingLots();
      }
      break;

    case "reservations":
      if (!localStorage.getItem("token")) {
        const tbody =
          document.getElementById("reservationsTable") ||
          document.getElementById("reservations-tbody");

        if (tbody) {
          tbody.innerHTML = `
            <tr>
              <td colspan="7" class="text-danger text-center">
                Please login to view reservations.
              </td>
            </tr>
          `;
        }
        return;
      }

      if (window.renderReservations) {
        await window.renderReservations();
      }
      break;

    case "spots":
      if (window.renderSpots) {
        await window.renderSpots();
      }
      break;

    default:
      // home, login, register → nothing special
      break;
  }
}

/*
|--------------------------------------------------------------------------
| Router (hash-based)
|--------------------------------------------------------------------------
*/
function router() {
  const route = location.hash.replace("#", "") || "home";
  loadView(route);
}

window.addEventListener("hashchange", router);
window.addEventListener("load", router);
