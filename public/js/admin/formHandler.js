import { clearMessages, showError, showSuccess } from "./ui.js";

export function initFormHandler(form, input, messageContainer) {
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        clearMessages(messageContainer);

        if (!input.files.length) {
            showError(messageContainer, "Выберите файл перед импортом");
            return;
        }

        const formData = new FormData(form);

        try {
            const response = await fetch("/api/upload", {
                method: "POST",
                body: formData,
            });

            const data = await response.json();

            if (data.status === "error") {
                showError(messageContainer, data.message);

                if (Array.isArray(data.errors)) {
                    data.errors.forEach((err) => {
                        showError(
                            messageContainer,
                            `Строка ${err.row}, поле "${err.field}": ${err.message}`
                        );
                    });
                }
            } else {
                showSuccess(messageContainer, "Импорт успешно завершён ✅");
                form.reset();
            }
        } catch (err) {
            showError(messageContainer, "Ошибка при отправке запроса: " + err.message);
        }
    });
}
