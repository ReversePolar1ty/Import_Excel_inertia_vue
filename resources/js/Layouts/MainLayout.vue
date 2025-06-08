<template>
    <div class="w-96 mx-auto">
        <navigation></navigation>
        <slot/>
    </div>
</template>
<script>
import NavLink from "@/Components/NavLink.vue";
import {Link} from "@inertiajs/vue3";
import Navigation from "@/Components/Navigation.vue";

export default{
    name: "MainLayout",
    components: {
        Link,
        NavLink,
        Navigation
    }
}
</script>
<style scoped>

</style>
