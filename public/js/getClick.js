import httpFetch from "./httpFetch.js";
import fragments from "./fragments.js";

const clickCollection = document.querySelectorAll("[data-click]");
clickCollection.forEach(click => {
  click.addEventListener("click", async () => {

    const id = click.dataset.click;
    httpFetch.fetchClick(id, response => {
      if (response.status === "success") {
        const click = response.click;
        let modal = fragments.clickModal;
        modal = modal.replaceAll("{!ip!}", click.ip);
        modal = modal.replaceAll("{!ip_version!}", click.type);
        modal = modal.replaceAll("{!date!}", click.date);
        modal = modal.replaceAll("{!hour!}", click.hour);
        modal = modal.replaceAll("{!city!}", click.city);
        modal = modal.replaceAll("{!zip!}", click.zip);
        modal = modal.replaceAll("{!country!}", click.country_name);
        modal = modal.replaceAll("{!long!}", click.longitude);
        modal = modal.replaceAll("{!lat!}", click.latitude);
        const modalFragment = document.createRange().createContextualFragment(modal).firstElementChild;
        const main = document.getElementsByTagName("main")[0];
        main.insertAdjacentElement('afterbegin', modalFragment);
        const close = document.getElementById('close');
        close.addEventListener('click', () => {
          main.removeChild(modalFragment);
        });
        if (!isNaN(Number(click.longitude)) && !isNaN(Number(click.longitude))) {
          const map = document.getElementById('map');
          const html = `<iframe src="https://maps.google.com/maps?q=${click.latitude}, ${click.longitude}&z=18&output=embed&t=k" width="100%" height="100%" frameborder="0" style="border:0"></iframe>`;
          const iFrame = document.createRange().createContextualFragment(html).firstElementChild;
          map.appendChild(iFrame);
        } else {
          const map = document.getElementById('map');
          const mapContainer = map.parentElement;
          mapContainer.removeChild(map);
        }
      }
    });
  });
});