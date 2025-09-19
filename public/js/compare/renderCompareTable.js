export function renderCompareTable(containerId) {
    const list = JSON.parse(localStorage.getItem("compareProducts")) || [];
    const container = document.getElementById(containerId);

    if (!container) return;

    if (list.length === 0) {
        container.innerHTML = `<p>Вы не выбрали товары для сравнения.</p>`;
        return;
    }

    let table = `<div class="compare-table-wrapper">
        <table class="compare-table">
            <thead>
                <tr>
                    <th>Характеристика</th>
                    ${list.map(p => `<th>${p.name}</th>`).join("")}
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Цена</td>
                    ${list.map(p => `<td>${p.price} ₽</td>`).join("")}
                </tr>
                <tr>
                    <td>Рейтинг</td>
                    ${list.map(p => `<td>⭐ ${p.rating}</td>`).join("")}
                </tr>
                <tr>
                    <td>Наличие</td>
                    ${list.map(p => `<td>${p.stock} шт.</td>`).join("")}
                </tr>
                <tr>
                    <td>Категория</td>
                    ${list.map(p => `<td>${p.category}</td>`).join("")}
                </tr>
            </tbody>
        </table>
    </div>`;

    container.innerHTML = table;
}
