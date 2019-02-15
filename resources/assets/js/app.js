
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('index', require('./components/Index.vue'));
Vue.component('recursos', require('./components/Recursos.vue'));
Vue.component('deudas', require('./components/Deudas.vue'));
Vue.component('planificacion-categorias', require('./components/PlanificacionCategorias.vue'));
Vue.component('planificacion', require('./components/Planificacion.vue'));
Vue.component('my-currency-input', {
    props: ["value"],
    template: `
        <div>
            <input type="text" class="form-control text-right" v-model="displayValue" @blur="isInputActive = false" @focus="isInputActive = true"/>
        </div>`,
    data: function() {
        return {
            isInputActive: false
        }
    },
    computed: {
        displayValue: {
            get: function() {
                if (this.isInputActive) {
                    // Cursor is inside the input field. unformat display value for user
                    return this.value.toString()
                } else {
                    // User is not modifying now. Format display value for user interface
                    return this.value.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "1,")
                }
            },
            set: function(modifiedValue) {
                // Recalculate value after ignoring "$" and "," in user input
                let newValue = parseFloat(modifiedValue.replace(/[^\d\.]/g, ""))
                // Ensure that it is not NaN
                if (isNaN(newValue)) {
                    newValue = 0
                }
                // Note: we cannot set this.value as it is a "prop". It needs to be passed to parent component
                // $emit the event so that parent component gets it
                this.$emit('input', newValue)
            }
        }
    }
});

const app = new Vue({
    el: '#app',
    data: {
        view: 0,
        categoria:0,
        categoria_estado:'',
        modulo_estado:''
    }
});
