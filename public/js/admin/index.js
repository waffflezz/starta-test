import { createMessageContainer } from "./ui.js";
import { initFormHandler } from "./formHandler.js";

document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".upload__form");
    const input = document.querySelector(".upload__input");

    const messageContainer = createMessageContainer();
    form.after(messageContainer);

    initFormHandler(form, input, messageContainer);
});