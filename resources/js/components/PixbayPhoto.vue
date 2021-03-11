<template>
    <div
        class="pixbay-photo-frame"
        @mouseenter="hover = true"
        @mouseleave="hover = false"
        @click="hover = !hover"
    >
        <img :src="image.url" class="pixbay-photo img-thumbnail" alt=":(">
        <b-badge
            v-if="showAuthor"
            class="label-default"
            variant="dark"
        >
            {{image.user}}
        </b-badge>
        <b-button
            v-if="showAddToFavourites"
            @click="storePhoto"
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
        image: Object,
        showAddToFavourites: {
            type: Boolean,
            default: true,
        },
        showAuthor: {
            type: Boolean,
            deafult: true,
        }
    },

    methods: {
        storePhoto(e) {
            e.stopPropagation();
            this.$emit('storePhoto', {
                photoUrl: this.image.url,
                photoId: this.image.id
            });
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
