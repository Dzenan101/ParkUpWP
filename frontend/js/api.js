console.log("api.js loaded");

const API_BASE_URL = "http://127.0.0.1:8000";

function getToken() {
  return localStorage.getItem("token");
}

async function apiRequest(path, options = {}) {
  const url = API_BASE_URL + path;

  const headers = options.headers ? { ...options.headers } : {};
  headers["Content-Type"] = "application/json";

  const token = getToken();
  if (token) {
    headers["Authorization"] = `Bearer ${token}`;
  }

  let response;
  try {
    response = await fetch(url, { ...options, headers });
  } catch (err) {
    console.error("FETCH FAILED:", err);
    throw new Error("Backend not reachable. Is php server running on 127.0.0.1:8000?");
  }

  const text = await response.text();
  let data = null;
  try {
    data = text ? JSON.parse(text) : null;
  } catch (e) {
    console.error("Non-JSON response:", text);
    throw new Error("Backend returned non-JSON (check PHP error output).");
  }

  if (!response.ok) {
    const msg = (data && data.error) ? data.error : `HTTP ${response.status}`;
    throw new Error(msg);
  }

  return data;
}

async function apiGet(path) {
  return apiRequest(path, { method: "GET" });
}

async function apiPost(path, body) {
  return apiRequest(path, { method: "POST", body: JSON.stringify(body) });
}

async function apiPut(path, body) {
  return apiRequest(path, { method: "PUT", body: JSON.stringify(body) });
}

async function apiDelete(path) {
  return apiRequest(path, { method: "DELETE" });
}
