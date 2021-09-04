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
        console.log(json);
        if (json.status === "success") {
          window.location.reload();
        } else {
          if (!document.querySelector("[data-type=error_message]")) {
            const errorMessage = `<span data-type="error_message" class="error">${json.msg}</span>`;
            const container = document.getElementById("main-content");
            container.insertAdjacentHTML("afterbegin", errorMessage);
          }
        }
      });
  }
}
export default httpFetch;