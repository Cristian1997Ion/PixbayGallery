<template>
    <div
        class="pixbay-photo-frame"
        @mouseenter="hover = true"
        @mouseleave="hover = false"
        @click="hover = !hover"
    >
        <img :src="photo.url" class="pixbay-photo img-thumbnail" alt=":(">
        <b-badge
            v-if="showAuthor"
            class="label-default"
            variant="dark"
        >
            {{photo.user}}
        </b-badge>
        <b-button
            v-if="showAddToFavourites"
            @click="storePhoto"
            v-show="hover && !stored"
            variant="dark"
            class="button-save"
        >
            <b-icon-star variant="light"/>
        </b-button>
        <b-button
            v-else
            @click="deletePhoto"
            v-show="hover && !deleted"
            variant="danger"
            class="button-delete"
        >
            <b-icon-x variant="light"/>
        </b-button>
    </div>
</template>

<script>
import { BIcon, BIconStar, BIconX} from 'bootstrap-vue'
export default {
    name: "PixbayPhoto",

    data: () => ({
        hover: false,
        stored: false,
        deleted: false,
    }),

    components: {
        BIcon,
        BIconStar,
        BIconX
    },

    props: {
        photo: Object,
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
            this.stored = true;
            this.$emit('storePhoto', {
                photoUrl: this.photo.url,
                photoId: this.photo.id
            });
        },

        deletePhoto(e) {
            e.stopPropagation();
            if (!confirm('Are you sure you want to remove this from favourites?')) {
                return;
            }

            this.deleted = true;
            this.$emit('deletePhoto', {
               photoId: this.photo.id,
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

    .button-delete {
        position: absolute;
        top: 1vh;
        right: 5%;
    }
}
</style>
