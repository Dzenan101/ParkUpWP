console.log("auth.js loaded");

function attachAuthHandlers() {
  // LOGIN
  const loginForm = document.getElementById("login-form");
  if (loginForm) {
    loginForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const email = document.getElementById("login-email")?.value?.trim();
      const password = document.getElementById("login-password")?.value;

      try {
        const res = await apiPost("/auth/login", { email, password });
        localStorage.setItem("token", res.token);
        localStorage.setItem("user", JSON.stringify(res.user));
        alert("Login successful!");
        window.location.hash = "#home";
      } catch (err) {
        console.error("Login failed:", err);
        alert("Login failed: " + err.message);
      }
    });
  }

  // REGISTER
  const registerForm = document.getElementById("register-form");
  if (registerForm) {
    registerForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const full_name = document.getElementById("register-full-name")?.value?.trim();
      const email = document.getElementById("register-email")?.value?.trim();
      const password = document.getElementById("register-password")?.value;
      const role = document.getElementById("register-role")?.value || "user";
      const phone = document.getElementById("register-phone")?.value?.trim() || null;

      try {
        const res = await apiPost("/auth/register", { full_name, email, password, role, phone });
        localStorage.setItem("token", res.token);
        localStorage.setItem("user", JSON.stringify(res.user));
        alert("Registered + logged in!");
        window.location.hash = "#home";
      } catch (err) {
        console.error("Register failed:", err);
        const el = document.getElementById("register-error");
        if (el) el.textContent = "Register failed: " + err.message;
        else alert("Register failed: " + err.message);
      }
    });
  }
}

// IMPORTANT: expose it globally so app.js can call it
window.attachAuthHandlers = attachAuthHandlers;
