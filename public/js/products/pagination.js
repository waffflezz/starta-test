import { loadProducts } from './filters.js';

const container = document.getElementById('pagination');

export function updatePagination(pagination, filters) {
    container.innerHTML = '';

    for (let i = 1; i <= pagination.pages; i++) {
        const btn = document.createElement('button');
        btn.className = `pagination__btn ${i === pagination.page ? 'pagination__btn--active' : ''}`;
        btn.textContent = i;

        btn.addEventListener('click', () => {
            const params = { ...filters, page: i };
            loadProducts(params);
            const query = new URLSearchParams(params).toString();
            history.pushState(null, '', `?${query}`);
        });

        container.appendChild(btn);
    }
}
