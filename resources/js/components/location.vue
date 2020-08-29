<template>
    <input @keydown.enter.prevent="true" type="text" v-model="addressValue" class="form-control">
</template>
<script>
    import autocomplete from 'autocompleter';

    export default {

        props: {
            value: String,
            searchType: {
                type: String,
                default () {
                    // Default coverage is city
                    return "city";
                }
            }
        },
        data() {
            return {
                addressValue: '',
                classType: {
                    city: "P",
                    region: "A",
                },
            }
        },
        computed: {
            featureClass() {
                return this.classType[this.searchType];
            },


            dataSource() {

                (async () => {
                    const where = encodeURIComponent(JSON.stringify({
                        "name": {
                            "$exists": true
                        }
                    }));
                    const response = await fetch(
                        `https://parseapi.back4app.com/classes/Continentscountriescities_Country?limit=10&order=name&excludeKeys=continent,phone,currency&where=${where}`, {
                            headers: {
                                'X-Parse-Application-Id': 's0IT2oKrnoKps5eImgCLYS44JQSpvzjcacYwlf9G', // This is your app's application id
                                'X-Parse-REST-API-Key': '6c39Rb8bRvhqpKCtkh0n3IiHXnz2hix9IZ5Jre7D', // This is your app's REST API key
                            }
                        }
                    );
                    const data = await response.json(); // Here you have the data that you need
                    console.log(JSON.stringify(data, null, 2));
                })();


            },
            source() {
                return "http://api.geonames.org/search?maxRows=10&username=kevin.loquencio&country=PH&type=json&featureClass=" +
                    this.featureClass + "&q=";
            }
        },
        watch: {
            addressValue(value) {
                this.$emit('input', value);
            },
            value(value) {
                this.addressValue = value;
            }
        },
        methods: {
            search(q, callBack) {
                var data = [];
                axios.get(this.source + q).then(response => {

                    response.data.geonames.forEach(element => {
                        data.push({
                            label: element.toponymName + ', ' + element.adminName1 + ' ' +
                                element
                                .countryName,
                            value: element.toponymName,
                        })
                    });


                }).finally(() => {
                    if (callBack)
                        callBack(data);
                });
            }
        },
        mounted() {

            var vm = this;

            vm.addressValue = vm.value;

            vm.$nextTick(() => {
                var input = vm.$el;
                autocomplete({
                    input: input,
                    fetch: function (text, update) {
                        text = text.toLowerCase();

                        vm.search(text, function (data) {
                            update(data);
                        });

                    },
                    onSelect: function (item) {
                        vm.addressValue = item.value;
                    }
                });
            });
        }
    }

</script>
