import { initFilters, loadProducts } from './filters.js';
import { initCompare } from "./compare.js";

document.addEventListener('DOMContentLoaded', async () => {
    await initFilters();

    const params = Object.fromEntries(new URLSearchParams(window.location.search));
    await loadProducts(params);
    initCompare()
});
