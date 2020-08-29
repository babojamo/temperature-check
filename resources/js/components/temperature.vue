<template>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="weather-card one">
                    <div class="top">




                        <div v-if="fetched===true" class="wrapper">
                            <h1 class="heading">{{ weather_temperature.country }}</h1>
                            <h3 class="location">{{ weather_temperature.city }}</h3>
                            <p class="temp">
                                <span class="temp-value">{{ weather_temperature.temperature }}</span>
                                <span class="deg">0</span>
                                <a href="javascript:;"><span class="temp-type">C</span></a>
                            </p>
                        </div>

                    </div>

                    <div class="bottom">
                        <div class="wrapper">

                            <template v-if="reloading===true">

                                <div class="d-flex justify-content-center" :style="{color:'gray'}">
                                    <div class="sk-pulse" :style="{backgroundColor:'gray'}"></div>
                                </div>
                                <div class="text-center">Fetching weather temperature...</div>


                            </template>


                            <div class="text-center text-danger pt-2" v-if="error===true" v-text="error_message"></div>


                            <div class="form-group pt-4">
                                <label>City</label>
                                <input type="text" v-model="search.city" class="form-control" required="required">
                            </div>

                            <div class="form-group">
                                <label>Country</label>
                                <input type="text" v-model="search.country" class="form-control" required="required">
                            </div>



                            <button type="button" @click.prevent="loadTemperature()" class="btn btn-primary">Get
                                Temperature</button>


                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

</template>
<script>
    export default {
        data() {
            return {
                reloading: false,
                error:false,
                error_message:'',
                fetched: false,
                search: {
                    city: '',
                    country: '',
                },
                weather_temperature: {
                    city: '',
                    country: '',
                    temperature: '',
                    format: '', 
                }
            };
        },
        methods: {
            loadTemperature() {

                if (this.reloading === false) {

                    this.reloading = true;
                    this.error=false;

                    axios.get('/temperature', {
                        params: {
                            city: this.search.city,
                            country: this.search.country
                        }
                    }).then(response => {

                        var data = response.data;

                        this.weather_temperature.temperature = data.temperature;
                        this.weather_temperature.format = data.format; 

                        this.fetched = true;

                    }).catch(error => {

                        this.error=true;
                        this.error_message=error.response.data.message;

                    }).finally(() => {
                        this.reloading = false;
                    });

                }
            }
        }
    }

</script>
