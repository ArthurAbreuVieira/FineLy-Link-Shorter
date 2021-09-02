import httpFetch from 'http://localhost/likn/public/js/httpFetch.js';
import fragments from 'http://localhost/likn/public/js/fragments.js';

const actionsBtn = document.querySelectorAll("[data-btn=actions]");
actionsBtn.forEach(btn => {
  btn.addEventListener('click', () => {
    let modal;
    if (btn.dataset.action === "edit") {
      modal = fragments.modal;
    } else {
      modal = fragments.modalDelete;
    }

    const fragment = document.createRange().createContextualFragment(modal).firstElementChild;
    document.body.insertAdjacentElement("afterbegin", fragment);

    const close = document.getElementById("close");
    close.addEventListener("click", () => {
      document.body.removeChild(fragment);
    });

    const submit = document.getElementById("submit");
    submit.addEventListener("click", e => {
      e.preventDefault();
      const id = document.getElementById("linkId").innerText;
      let data = "data=";
      if (btn.dataset.action === "edit") {
        const redirect = document.getElementById("redirect").value;
        data += JSON.stringify({
          id,
          redirect
        })
      } else {
        data += JSON.stringify({
          id
        })
      }
      const params = data;
      const options = {
        method: 'POST',
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: params
      }
      const action = btn.dataset.action === "edit" ? "edit" : "delete";
      httpFetch.updateLink(options, action);
    });
  });
});