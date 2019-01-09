(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

Vue.component("google-maps-widget", {
    template: "<div :class=\"aspectRatio\" class=\"maps-component\" ref=\"googleMapsContainer\"></div>",

    props: {
        googleApiKey: {
            type: String,
            required: true
        },
        address: {
            type: String,
            required: false
        },
        lat: {
            type: Number
        },
        lng: {
            type: Number
        },
        zoom: {
            type: Number,
            default: 16
        },
        aspectRatio: {
            type: String,
            default: "map-3-1",
            validator: function validator(value) {
                return ["map-3-1", "map-2-1", "map-1-1", ""].indexOf(value) !== -1;
            }
        }
    },

    computed: {
        coordinates: function coordinates() {
            var isLatValid = !isNaN(this.lat) && this.lat > -90 && this.lat < 90;
            var isLngValid = !isNaN(this.lng) && this.lng > -180 && this.lng < 180;

            if (isLatValid && isLngValid) {
                return {
                    lat: this.lat,
                    lng: this.lng
                };
            }

            return null;
        }
    },

    mounted: function mounted() {
        var _this = this;

        this.$nextTick(function () {
            if (!document.querySelector("#google-maps-api")) {
                _this.createScript().then(function () {
                    return _this.initializeMap();
                });
            } else {
                _this.listenToExistingScript();
            }
        });
    },


    methods: {
        createScript: function createScript() {
            var _this2 = this;

            return new Promise(function (resolve, reject) {
                var script = document.createElement("script");
                var scriptSource = "https://maps.googleapis.com/maps/api/js?key=" + _this2.googleApiKey;

                script.type = "text/javascript";
                script.id = "google-maps-api";
                script.src = scriptSource;

                script.addEventListener("load", function () {
                    return resolve(script);
                }, false);
                script.addEventListener("error", function () {
                    return reject(script);
                }, false);

                document.body.appendChild(script);
            });
        },
        listenToExistingScript: function listenToExistingScript() {
            var _this3 = this;

            var script = document.querySelector("script#google-maps-api");

            if (typeof google === "undefined") {
                script.addEventListener("load", function () {
                    return _this3.initializeMap();
                }, false);
            } else {
                this.initializeMap();
            }
        },
        initializeMap: function initializeMap() {
            var _this4 = this;

            if (this.coordinates) {
                this.renderMap(this.coordinates);
            } else {
                this.geocodeAddress().then(function (coordinates) {
                    _this4.renderMap(coordinates);
                });
            }
        },
        geocodeAddress: function geocodeAddress() {
            var _this5 = this;

            return new Promise(function (resolve, reject) {
                new google.maps.Geocoder().geocode({ address: _this5.address }, function (results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        resolve({
                            lat: results[0].geometry.location.lat(),
                            lng: results[0].geometry.location.lng()
                        });
                    } else {
                        reject();
                    }
                });
            });
        },
        renderMap: function renderMap(coordinates) {
            var map = new google.maps.Map(this.$refs.googleMapsContainer, {
                center: coordinates,
                zoom: this.zoom
            });

            new google.maps.Marker({
                map: map,
                position: coordinates
            });
        }
    }
});

},{}]},{},[1])


//# sourceMappingURL=maps-component.js.map
