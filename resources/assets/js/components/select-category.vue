<template>
    <select v-model="note.category_id" class="form-control">
        <option value="">- Selecciona una categoría</option>
        <option v-for="category in categories" :value="category.id">
            {{ category.name }}
        </option>
    </select>
</template>

<script>
export default {
    props: ['categories', 'note']
}
</script>