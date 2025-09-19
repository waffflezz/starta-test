export function createMessageContainer() {
    const container = document.createElement("div");
    container.classList.add("upload__messages");
    return container;
}

export function clearMessages(container) {
    container.innerHTML = "";
}

export function showError(container, msg) {
    const p = document.createElement("p");
    p.classList.add("upload__error");
    p.textContent = msg;
    container.appendChild(p);
}

export function showSuccess(container, msg) {
    const p = document.createElement("p");
    p.classList.add("upload__success");
    p.textContent = msg;
    container.appendChild(p);
}
