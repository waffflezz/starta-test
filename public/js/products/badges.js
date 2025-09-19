export function getBadges(product, categoryMedianPrice) {
    const badges = [];
    const now = new Date();

    // Новинка: <= 30 дней
    const createdAt = new Date(product.created_at);
    const daysDiff = (now - createdAt) / (1000 * 60 * 60 * 24);
    if (daysDiff <= 30) {
        badges.push({ text: 'Новинка', class: 'product-card__badge--new' });
    }

    // Топ-рейтинг: rating >= 4.7 && reviews_count >= 50
    if (product.rating >= 4.7 && product.reviews_count >= 50) {
        badges.push({ text: 'Топ-рейтинг', class: 'product-card__badge--top' });
    }

    // Выгодно: цена на 15% ниже медианы категории
    if (categoryMedianPrice && product.price <= categoryMedianPrice * 0.85) {
        badges.push({ text: 'Выгодно', class: 'product-card__badge--deal' });
    }

    // Последний на складе: stock <= 3
    if (product.stock <= 3) {
        badges.push({ text: 'Последний', class: 'product-card__badge--last' });
    }

    // Ограничим до 2 бейджей
    return badges.slice(0, 2);
}

export function renderBadges(cardEl, badges) {
    const container = cardEl.querySelector('.product-card__badges');
    container.innerHTML = '';
    badges.forEach(b => {
        const span = document.createElement('span');
        span.className = `product-card__badge ${b.class}`;
        span.textContent = b.text;
        container.appendChild(span);
    });
}
