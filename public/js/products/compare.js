const COMPARE_KEY = "compareProducts";
let popover = null;
let hideTimeout = null;

function getCompareList() {
    return JSON.parse(localStorage.getItem(COMPARE_KEY)) || [];
}

function setCompareList(list) {
    localStorage.setItem(COMPARE_KEY, JSON.stringify(list));
}

function clearCompare() {
    setCompareList([]);
    document.querySelectorAll(".compare-checkbox").forEach(cb => (cb.checked = false));
    renderPopover();
}

function renderPopover(target = null) {
    if (popover) popover.remove();

    const list = getCompareList();
    if (list.length === 0) return;

    popover = document.createElement("div");
    popover.className = "compare-popover";

    const items = list.map(
        (item) => `<div class="compare-popover__item">${item.name}</div>`
    ).join("");

    popover.innerHTML = `
        <div class="compare-popover__items">${items}</div>
        <div class="compare-popover__actions">
            <button class="compare-popover__btn compare-popover__btn--compare">Сравнить</button>
            <button class="compare-popover__btn compare-popover__btn--clear">Очистить</button>
        </div>
    `;

    document.body.appendChild(popover);

    if (target) {
        const rect = target.getBoundingClientRect();
        popover.style.position = "absolute";
        popover.style.top = `${window.scrollY + rect.bottom + 6}px`;
        popover.style.left = `${window.scrollX + rect.left}px`;
    }

    popover.querySelector(".compare-popover__btn--compare")
        .addEventListener("click", () => { window.location.href = "/compare"; });

    popover.querySelector(".compare-popover__btn--clear")
        .addEventListener("click", clearCompare);

    popover.addEventListener("mouseenter", () => {
        if (hideTimeout) clearTimeout(hideTimeout);
    });
    popover.addEventListener("mouseleave", () => {
        scheduleHide();
    });
}

function scheduleHide() {
    if (hideTimeout) clearTimeout(hideTimeout);
    hideTimeout = setTimeout(() => {
        if (popover) {
            popover.remove();
            popover = null;
        }
    }, 200);
}

export function initCompare() {
    document.addEventListener("change", (e) => {
        if (e.target.matches(".compare-checkbox")) {
            const productId = e.target.dataset.id;
            const productName = e.target.dataset.name;
            let list = getCompareList();

            if (e.target.checked) {
                if (list.length >= 4) {
                    e.target.checked = false;
                    alert("Нельзя выбрать больше 4 товаров");
                    return;
                }
                list.push({
                    id: productId,
                    name: productName,
                    price: e.target.dataset.price,
                    rating: e.target.dataset.rating,
                    stock: e.target.dataset.stock,
                    category: e.target.dataset.category
                });
            } else {
                list = list.filter(item => item.id !== productId);
            }

            setCompareList(list);
            renderPopover(e.target);
        }
    });

    const saved = getCompareList();
    if (saved.length > 0) {
        saved.forEach(item => {
            const checkbox = document.querySelector(`.compare-checkbox[data-id="${item.id}"]`);
            if (checkbox) checkbox.checked = true;
        });
    }

    document.addEventListener("mouseenter", (e) => {
        if (e.target.matches(".compare-checkbox")) {
            renderPopover(e.target);
        }
    }, true);

    document.addEventListener("mouseleave", (e) => {
        if (e.target.matches(".compare-checkbox")) {
            scheduleHide();
        }
    }, true);

    document.addEventListener("click", (e) => {
        if (e.target.matches(".compare-checkbox")) {
            renderPopover(e.target);
        } else if (popover && !popover.contains(e.target)) {
            popover.remove();
            popover = null;
        }
    });
}
