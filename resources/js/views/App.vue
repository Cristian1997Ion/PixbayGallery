<template>
    <div>
        <app-header/>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
import AppHeader from "../components/AppHeader";

export default {
    components: {AppHeader}
}
</script>
