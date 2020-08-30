<template>
    <select2 :options="options" :placeholder="placeholder" :required="required" v-model="location"></select2>
</template>
<script>
    export default {

        props: {
            value: String,
            searchType: {
                type: String,
                default () {
                    // Default coverage is countries
                    return "countries";
                }
            },
            country: String,
            region: String,
            required:Boolean,
            placeholder:String
        },
        data() {
            return {
                location: '',
                options: [],
            }
        },
        computed: {

            source() {

                return {
                    cities: "/location/cities?country=" + this.country + "&region=" + this.region,
                    regions: "/location/regions?country=" + this.country,
                    countries: "/location/countries",
                }
            }
        },
        watch: {
            location(value) {
                this.$emit('input', value);
            },
            value(value) {
                this.location = value;
            },
            country() {
                if (this.searchType === "regions")
                    this.loadList();
            },
            region() {
                if (this.searchType === "cities")
                    this.loadList();
            }
        },
        methods: {
            loadList() {
                var keys = {
                    name: "name",
                    id: "code"
                };

                if (this.searchType === "regions") {

                    if (!this.country) // Country is required
                        return;

                    keys.name = "region";
                    keys.id = "region";
                    
                } else if (this.searchType === "cities") {

                    if (!this.country || !this.region) // Region and country is required
                        return;

                    keys.name = "city";
                    keys.id = "city";
                }

                this.options = [];

                axios.get(this.source[this.searchType]).then(response => {


                    response.data.forEach(element => {

                        this.options.push({
                            text: element[keys.name],
                            id: element[keys.id],
                        });

                    });


                });

            }
        },
        mounted() {
            this.location = this.value;
        },
        beforeMount() {
            this.loadList();
        },
    }

</script>
