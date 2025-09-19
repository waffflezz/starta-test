import { renderProducts } from './products.js';
import { updatePagination } from './pagination.js';
import { fetchProducts, fetchCategories } from './api.js';

const form = document.querySelector('.filters__form');
const categorySelect = form.querySelector('select[name="cat"]');

export async function initFilters() {
    try {
        const { categories } = await fetchCategories();
        categories.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat;
            option.textContent = cat;
            categorySelect.appendChild(option);
        });
    } catch (e) {
        console.warn(e.message);
    }

    applyUrlToForm();

    const initialParams = getFiltersFromUrl();
    await loadProducts(initialParams);

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const params = getFiltersFromForm();
        updateUrl(params);
        await loadProducts(params);
    });
}

function getFiltersFromForm() {
    const formData = new FormData(form);
    const params = {};
    for (let [key, value] of formData.entries()) {
        if (value !== '') params[key] = value;
    }
    return params;
}

function getFiltersFromUrl() {
    const params = {};
    const searchParams = new URLSearchParams(window.location.search);
    for (let [key, value] of searchParams.entries()) {
        params[key] = value;
    }
    return params;
}

function applyUrlToForm() {
    const searchParams = new URLSearchParams(window.location.search);
    form.querySelectorAll('input, select').forEach(input => {
        if (searchParams.has(input.name)) {
            const value = searchParams.get(input.name);
            if (input.type === 'checkbox') {
                input.checked = input.value === value;
            } else {
                input.value = value;
            }
        }
    });
}

function updateUrl(params) {
    const query = new URLSearchParams(params).toString();
    history.pushState(null, '', query ? `?${query}` : window.location.pathname);
}

export async function loadProducts(params = {}) {
    try {
        const result = await fetchProducts(params);
        renderProducts(result.data);
        updatePagination(result.pagination, params);
    } catch (e) {
        console.error(e);
    }
}
