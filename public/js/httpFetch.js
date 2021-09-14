import env from "./env.js";

const httpFetch = {
  updateUser(params) {
    fetch(`${env.BASE}/update/`, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: `data=${JSON.stringify(params)}`
    })
      .then(response => response.json())
      .then(json => {
        // console.log(json);
        if (json.status === "error") {
          if (!document.querySelector('.error')) {
            const form = document.getElementById("updateForm");
            console.log(form);
            const htmlError = `<span class="error" style="margin: 0;">${json.msg}</span>`;
            const errorElement = document.createRange().createContextualFragment(htmlError).firstChild;
            form.insertAdjacentElement("afterend", errorElement);
          }
        } else if (json.status === "success") {
          window.location.reload();
        }
      });
  },
  updateLink(params, action) {
    fetch(`${env.BASE}/${action}/`, params)
      .then(response => response.json())
      .then(json => {
        if (json.status === "success") {
          if(action === "edit") {
            window.location.reload();
          } else {
            window.location = `${env.BASE}/mylinks/`;
          }
        } else {
          if (!document.querySelector("[data-type=error_message]")) {
            const errorMessage = `<span data-type="error_message" class="error">${json.msg}</span>`;
            const container = document.getElementById("main-content");
            container.insertAdjacentHTML("afterbegin", errorMessage);
          }
        }
      });
  },
  fetchClick(id, callback) {
    fetch(`${env.BASE}/click/`, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: `id=${id}`
    })
    .then(response => response.json())
    .then(json => {
      json.click = JSON.parse(json.click);
      for(let key in json.click) {
        json.click[key] = json.click[key] === null ? "Indefinido" : json.click[key];
        if(typeof json.click[key] === "object") {
          for(let k in json.click[key]) {
            json.click[key][k] = json.click[key][k] === null ? "Indefinido" : json.click[key][k];
          }
        }
      }
      callback(json);
    });
  }
}
export default httpFetch;