@php $game = $game ?? null; @endphp
<div class="mb-3">
    <label class="form-label">Название</label>
    <input type="text" name="title" value="<?= e(old('title', $game->title ?? '')) ?>" class="form-control" required>
</div>
<div class="mb-3">
    <label class="form-label">Описание</label>
    <textarea name="description" rows="4" class="form-control"><?= e(old('description', $game->description ?? '')) ?></textarea>
</div>
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Цена, ₽</label>
        <input type="number" step="0.01" min="0" name="price" value="<?= e(old('price', $game->price ?? '')) ?>" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Жанр</label>
        <input type="text" name="genre" value="<?= e(old('genre', $game->genre ?? '')) ?>" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Остаток</label>
        <input type="number" min="0" max="255" name="stock" value="<?= e(old('stock', $game->stock ?? 0)) ?>" class="form-control" required>
    </div>
</div>
<div class="mb-3 mt-3">
    <label class="form-label">Обложка (изображение)</label>
    @if (!empty($game?->image))
        <div class="mb-2"><img src="<?= asset('storage/'.$game->image) ?>" alt="" style="height:90px;border-radius:8px"></div>
    @endif
    <input type="file" name="image" accept="image/*" class="form-control">
    <div class="form-text">JPG, PNG или WEBP, до 2 МБ. Если не загружать — останется текущая обложка или цветной градиент.</div>
</div>
<div class="form-check mt-3">
    <input type="checkbox" name="is_hidden" value="1" class="form-check-input" id="is_hidden" <?= old('is_hidden', $game->is_hidden ?? false) ? 'checked' : '' ?>>
    <label class="form-check-label" for="is_hidden">Скрыть из каталога</label>
</div>
