import httpFetch from 'http://localhost/likn/public/js/httpFetch.js';
import fragments from 'http://localhost/likn/public/js/fragments.js';

const link = {
  id: document.getElementById('linkId') ? document.getElementById('linkId').innerText : null,
  redirect: document.getElementById('linkRedirect') ? document.getElementById('linkRedirect').innerText : null,
  clickCount: document.getElementById('clickCount') ? document.getElementById('clickCount').innerText : null
}

const actionsBtn = document.querySelectorAll("[data-btn=actions]");
actionsBtn.forEach(btn => {
  btn.addEventListener('click', () => {
    let modal;
    if (btn.dataset.action === "edit") {
      modal = fragments.modal;
    } else {
      modal = fragments.modalDelete;
      modal = modal.replaceAll('{{link.click_count}}', link.clickCount);
    }
    modal = modal.replaceAll('{{link.redirect}}', link.redirect);
    modal = modal.replaceAll('{{link.id}}', link.id);

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
      const action = btn.dataset.action;
      httpFetch.updateLink(options, action);
    });
  });
});