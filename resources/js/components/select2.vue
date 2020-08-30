<template>

    <select class="form-control" v-bind:multiple="multiple"></select>

</template>

<script>
    export default {
        props: {

            options: {
                Object
            },
            value: null,
            multiple: {
                Boolean,
                default: false

            }
        },
        data() {
            return {
                select2data: [],
                select: null,
            }
        },
        watch: {
            options: {
                deep: true,
                handler(value) {
                    this.formatOptions(value);

                    // update options
                    $(this.$el).empty().select2({
                        data: this.select2data
                    });

                    this.select.val(this.value).trigger('change');

                }
            },

            value: {
                deep: true,
                handler(value) { 
                    this.select.val(value).trigger('change');
                }
            }
        },
        mounted() {


            this.select = $(this.$el);
            this.select.select2({
                    placeholder: 'Select',
                    allowClear: true,
                    data: this.select2data
                })
                .on('select2:select', () => {

                    this.$emit('input', $(this.$el).val());

                });

            this.$nextTick(() => {
                this.select.val(this.value).trigger('change');
            });

        },
        methods: {
            formatOptions(options) {
                // this.select2data.push({
                //     id: '',
                //     text: 'Select'
                // })
                this.select2data=[];
                for (let key in options) {
                    this.select2data.push(options[key])
                }
            }
        },
        beforeMount() {
            this.formatOptions(this.options);
        },

        destroyed: function () {
            $(this.$el).off().select2('destroy')
        }

    }

</script>
