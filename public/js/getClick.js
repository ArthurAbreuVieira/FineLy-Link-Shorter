import httpFetch from "./httpFetch.js";
import fragments from "./fragments.js";

const clickCollection = document.querySelectorAll("[data-click]");
clickCollection.forEach(click => {
  click.addEventListener("click", async () => {
    const id = click.dataset.click;
    httpFetch.fetchClick(id, response => {
      if(response.status === "success") {
        const click = response.click;
        let modal = fragments.clickModal;
        modal = modal.replaceAll("{!ip!}", click.ip);
        modal = modal.replaceAll("{!ip_version!}", click.type);
        modal = modal.replaceAll("{!date!}", click.date);
        modal = modal.replaceAll("{!hour!}", click.hour);
        modal = modal.replaceAll("{!city!}", click.city);
        modal = modal.replaceAll("{!zip!}", click.zip);
        modal = modal.replaceAll("{!country!}", click.country);
        modal = modal.replaceAll("{!long!}", click.longitude);
        modal = modal.replaceAll("{!lat!}", click.latitude);
        const modalFragment = document.createRange().createContextualFragment(modal).firstElementChild;
        const main = document.getElementsByTagName("main")[0];
        main.insertAdjacentElement('afterbegin', modalFragment);
        const close = document.getElementById('close');
        close.addEventListener('click', () => {
          main.removeChild(modalFragment);
        });
      }
    });
  });
});