<div class="filters">
    <form class="filters__form">
        <input
            type="text"
            class="filters__search"
            placeholder="Поиск по названию..."
            name="q"
        >

        <select class="filters__select" name="cat">
            <option value="">Все категории</option>
        </select>

        <div class="filters__range">
            <input type="number" class="filters__input" name="min" placeholder="Мин. цена">
            <span>-</span>
            <input type="number" class="filters__input" name="max" placeholder="Макс. цена">
        </div>

        <label class="filters__checkbox">
            <input type="checkbox" name="inStock" value="1">
            В наличии
        </label>

        <select class="filters__select" name="sort">
            <option value="date_desc">Сначала новые</option>
            <option value="date_asc">Сначала старые</option>
            <option value="price_desc">Дороже</option>
            <option value="price_asc">Дешевле</option>
            <option value="rating_desc">Наибольший рейтинг</option>
            <option value="rating_asc">Наименьший рейтинг</option>
        </select>

        <button type="submit" class="filters__btn">Применить</button>
    </form>
</div>
