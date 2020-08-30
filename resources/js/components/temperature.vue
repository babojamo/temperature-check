<template>

    <div class="container">
        <div class="row">
           
            <div class="col">
                <div class="weather-card one">
                    <div class="top">
                        <h3 style="font-size:16px; color:white;" class="pt-3">Weather Temperature</h3>

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



                            <div v-if="reloading===false" class="pt-4" >
                                <small style="color:rgb(129, 129, 129);"  >To get the location weather temperature, select country, region and city</small>
                            </div>
                            
                            <div class="pt-4">

                              
                                


                                <div class="form-group">
                                    <label>Country</label>
                                    <location-search v-model="country" :required="true">>
                                    </location-search>
                                </div>

                                <div class="form-group">
                                    <label>Region</label>
                                    <location-search search-type="regions" :country="country" v-model="region"
                                        :required="true">>
                                    </location-search>
                                </div>

                                <div class="form-group">
                                    <label>City</label>
                                    <location-search search-type="cities" :region="region" :country="country"
                                        v-model="city" :required="true">
                                    </location-search>
                                </div>


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
                error: false,
                error_message: '',
                fetched: false,

                city: '',
                country: '',
                region: '',

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
                    this.error = false;

                    axios.get('/temperature', {
                        params: {
                            city: this.city,
                            country: this.country
                        }
                    }).then(response => {

                        var data = response.data;

                        this.weather_temperature.city = data.city;
                        this.weather_temperature.temperature = data.temperature;
                        this.weather_temperature.format = data.format;

                        this.fetched = true;

                    }).catch(error => {

                        this.error = true;
                        this.error_message = error.response.data.message;

                    }).finally(() => {
                        this.reloading = false;
                    });

                }
            }
        },
    }

</script>
