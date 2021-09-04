import fragments from './fragments.js';
import httpFetch from './httpFetch.js';

const params = {
  type: null,
  value: null
};

const name = document.getElementById("name").innerText;
const email = document.getElementById("email").innerText;

(function initEventListeners() {
  const editButtons = document.querySelectorAll("[data-edit]");

  editButtons.forEach(button => {
    const form = document.getElementById("updateForm");
    button.addEventListener("click", () => {
      if (button.dataset.edit === "name") {
        let formUpdate = fragments.formUpdate;
        formUpdate = formUpdate.replace("{!label!}", "Digite o seu novo nome de usuário:");
        formUpdate = formUpdate.replace("{!data-type!}", "name");
        formUpdate = formUpdate.replace("{!type!}", "text");
        formUpdate = formUpdate.replace("{!placeholder!}", "Novo nome de usuário");
        form.innerHTML = formUpdate;
      } else if (button.dataset.edit === "email") {
        let formUpdate = fragments.formUpdate;
        formUpdate = formUpdate.replace("{!label!}", "Digite o seu novo email de login:");
        formUpdate = formUpdate.replace("{!data-type!}", "email");
        formUpdate = formUpdate.replace("{!type!}", "email");
        formUpdate = formUpdate.replace("{!placeholder!}", "Novo email de login");
        form.innerHTML = formUpdate;
      } else if (button.dataset.edit === "password") {
        let formUpdate = fragments.formUpdate;
        formUpdate = formUpdate.replace("{!label!}", "Digite a sua nova senha de login:");
        formUpdate = formUpdate.replace("{!data-type!}", "password");
        formUpdate = formUpdate.replace("{!type!}", "text");
        formUpdate = formUpdate.replace("{!placeholder!}", "Nova senha de login");
        form.innerHTML = formUpdate;
      }
      const updateBtn = document.querySelector("[data-btn='update']");
      updateBtn.addEventListener("click", e => {
        e.preventDefault();
        params.type = document.querySelector("[data-js=get]").dataset.type;
        params.value = document.querySelector("[data-js=get]").value;
        httpFetch.updateUser(params);
      });

      const back = document.querySelector("[data-btn=back]");
      back.addEventListener("click", () => {
        let formOptions = fragments.formOptions;
        formOptions = formOptions.replace("{!name!}", name);
        formOptions = formOptions.replace("{!email!}", email);
        form.innerHTML = formOptions;
        initEventListeners();
      });
    });
  });
})();