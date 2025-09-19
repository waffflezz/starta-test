import { getBadges, renderBadges } from './badges.js';

export function renderProducts(products, categoryMedians = {}) {
    const grid = document.getElementById('productsGrid');
    grid.innerHTML = '';

    products.forEach(product => {
        const card = document.createElement('div');
        card.className = 'product-card';
        card.innerHTML = `
            <div class="product-card__image-wrapper" style="position:relative;">
                <img src="/images/placeholder.jpg" class="product-card__image" alt="${product.name}">
                <div class="product-card__badges"></div>
            </div>
            <div class="product-card__name">${product.name}</div>
            <div class="product-card__price">${product.price} ₽</div>
            <div class="product-card__rating">⭐ ${product.rating}</div>
            <div class="product-card__stock">${product.stock} шт.</div>
            <div class="product-card__compare">
                <label>
                    <input 
                        type="checkbox" 
                        class="compare-checkbox" 
                        data-id="${product.id}" 
                        data-name="${product.name}"
                        data-price="${product.price}"
                        data-rating="${product.rating}"
                        data-stock="${product.stock}"
                        data-category="${product.category}">
                    Сравнить
                </label>
            </div>
        `;

        const median = categoryMedians[product.category] || null;
        const badges = getBadges(product, median);
        renderBadges(card, badges);

        grid.appendChild(card);
    });
}
