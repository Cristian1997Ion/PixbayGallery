<template>
    <div
        class="pixbay-photo-frame"
        @mouseenter="hover = true"
        @mouseleave="hover = false"
        @click="hover = !hover"
    >
        <img :src="image.url" class="pixbay-photo img-thumbnail" alt=":(">
        <b-badge
            class="label-default"
            variant="dark"
        >
            {{image.user}}
        </b-badge>
        <b-button
            @click="savePhoto"
            v-show="hover"
            variant="dark"
            class="button-save"
        >
            <b-icon-star variant="light"/>
        </b-button>
    </div>
</template>

<script>
import { BIcon, BIconStar} from 'bootstrap-vue'
export default {
    name: "PixbayPhoto",

    data: () => ({
       hover: false
    }),

    components: {
        BIcon,
        BIconStar
    },

    props: {
        image: Object
    },

    methods: {
        savePhoto(e) {
            e.stopPropagation();
            alert();
        }
    }
}
</script>

<style lang="scss" scoped>
.pixbay-photo-frame {
    height: 45vh;
    position: relative;
    .pixbay-photo {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .label-default {
        position: absolute;
        top: 3vh;
        left: 1vw;
    }

    .button-save {
        position: absolute;
        bottom: 1vh;
        right: 40%;
    }
}
</style>
