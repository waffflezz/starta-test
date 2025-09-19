const grid = document.getElementById('productsGrid');

export function renderProducts(products) {
    grid.innerHTML = '';

    if (!products.length) {
        grid.innerHTML = '<p>Товары не найдены</p>';
        return;
    }

    products.forEach(p => {
        const card = document.createElement('div');
        card.className = 'product-card';
        card.innerHTML = `
            <img src="/images/placeholder.jpg" alt="${p.name}" class="product-card__image">
            <h3 class="product-card__name">${p.name}</h3>
            <div class="product-card__price">${p.price} ₽</div>
            <div class="product-card__rating">⭐ ${p.rating}</div>
            <div class="product-card__stock">${p.stock > 0 ? 'В наличии' : 'Нет в наличии'}</div>
            ${p.promo ? `<span class="product-card__badge">${p.promo}</span>` : ''}
        `;
        grid.appendChild(card);
    });
}
