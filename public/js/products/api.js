export async function fetchProducts(params = {}) {
    const query = new URLSearchParams(params).toString();
    const res = await fetch(`/api/products?${query}`);
    if (!res.ok) throw new Error('Ошибка загрузки продуктов');
    return res.json();
}

export async function fetchCategories() {
    const res = await fetch('/api/products/categories');
    if (!res.ok) throw new Error('Ошибка загрузки категорий');
    return res.json();
}
