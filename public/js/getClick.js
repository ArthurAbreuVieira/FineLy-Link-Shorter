import httpFetch from "./httpFetch.js";

const clickCollection = document.querySelectorAll("[data-click]");
clickCollection.forEach(click => {
  click.addEventListener("click", async () => {
    const id = click.dataset.click;
    const data = httpFetch.fetchClick(id);
    console.log(data);
  });
});