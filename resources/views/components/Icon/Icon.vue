<template>

    <svg
        class="Icon"
        :class="isclasses"
        :style="style"
    >
        <use xlink:href="#{{ name }}"></use>

    </svg>

</template>

<script>

    export default {

        props: {
            isclasses: { default: '' },
            size: { default: 'md' },
            width: { default: 0 },
            height: { default: 0 },
            name: { default: '' },
            color: { default: 'black' }
        },

        computed: {
            style: function() {
                var sizes = { sm: 14, md: 18, lg: 32 }

                if (this.width && this.height) {
                    return {
                        width: this.width,
                        height: this.height,
                        fill: this.color
                    }
                }

                return {
                    width: sizes[this.size],
                    height: sizes[this.size],
                    fill: this.color
                }
            }
        }

    }

</script>