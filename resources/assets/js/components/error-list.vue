<template>
    <ul v-if="errors.length" class="text-danger">
        <li v-for="error in errors">
            {{ error }}
        </li>
    </ul>
</template>
<script>
export default {
    props: ['errors']
}
</script>