<script setup>
import {ref} from "vue";
import {store} from "../store";

const props = defineProps({
  product: {}
});
const counter = ref(props.product.quantity || 0)
const restrictMax = () => {
  if (counter.value > store.maxQty) {
    counter.value = store.maxQty
  }
  if (counter.value < 0) {
    counter.value = 0
  }

}
const increment = () => {
  counter.value++
  restrictMax()
}
const addToCart = (product) => {
  store.updateCart(product, counter.value)
}
const decrement = () => {
  counter.value--
  restrictMax()
}


</script>
<template>
  <div class="relative">
    <div
        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
      <img :src="product.image"
           :alt="product.title"
           class="h-full w-full object-cover object-center lg:h-full lg:w-full">
    </div>
    <div class="mt-4 flex justify-between">
      <div>
        <h3 class="text-sm text-gray-700 ">
          <a href="#">
            <span aria-hidden="true" class="absolute inset-0"></span>
          </a>
          {{ product.title }}
        </h3>
        <p class="mt-1 text-sm text-gray-500">
          {{ product.category }}
        </p>
      </div>
    </div>
    <p class="text-sm font-medium text-gray-900">${{ product.price }}</p>
  </div>
  <label for="counter-input" class="sr-only">Choose quantity:</label>
  <div>
    <div class="flex items-center justify-evenly gap-x-2 mt-3">
      <button v-show="counter > 0" type="button" @click="decrement"
              class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
        <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" xmlns="http://www.w3.org/2000/svg"
             fill="none" viewBox="0 0 18 2">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
        </svg>
      </button>
      <input type="text" v-model="counter"
             class="w-10 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0 dark:text-white"
             placeholder="" required/>
      <button v-show="counter < store.maxQty " type="button" @click="increment"
              class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
        <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" xmlns="http://www.w3.org/2000/svg"
             fill="none" viewBox="0 0 18 18">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 1v16M1 9h16"/>
        </svg>
      </button>
      <div class="flex">
        <button v-show="counter > 0 " @click="addToCart(product)"
                class="btn-sm border text-white font-bold py-2 px-4 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" height="15px"
               width="15px" viewBox="0 0 26 26" xml:space="preserve">
            <g>
              <path
                  d="M25.856,10.641C21.673,19.5,20.312,19.5,19.5,19.5h-8c-2.802,0-4.949-1.648-5.47-4.2   c-0.016-0.078-1.6-7.853-2.005-10.025C3.826,4.21,3.32,3.5,1.5,3.5C0.671,3.5,0,2.829,0,2s0.671-1.5,1.5-1.5   c3.02,0,4.964,1.5,5.474,4.224c0.401,2.149,1.98,9.898,1.996,9.977c0.319,1.566,1.722,1.8,2.53,1.8h7.605   c0.817-0.878,2.679-4.261,4.038-7.141c0.354-0.749,1.249-1.068,1.997-0.716C25.89,8.997,26.21,9.891,25.856,10.641z M10.5,20.5   C9.119,20.5,8,21.619,8,23s1.119,2.5,2.5,2.5S13,24.381,13,23S11.881,20.5,10.5,20.5z M19.5,20.5c-1.381,0-2.5,1.119-2.5,2.5   s1.119,2.5,2.5,2.5S22,24.381,22,23S20.881,20.5,19.5,20.5z M14.663,12.344c0.1,0.081,0.223,0.12,0.346,0.12   s0.244-0.039,0.346-0.12c0.1-0.079,2.828-2.74,4.316-4.954c0.115-0.172,0.126-0.392,0.028-0.574   c-0.095-0.181-0.285-0.295-0.49-0.295h-2.226c0,0-0.217-4.291-0.359-4.49c-0.206-0.294-1.057-0.494-1.616-0.494   c-0.561,0-1.427,0.2-1.634,0.494c-0.141,0.198-0.328,4.49-0.328,4.49h-2.255c-0.206,0-0.395,0.114-0.492,0.295   c-0.097,0.182-0.086,0.403,0.028,0.574C11.816,9.605,14.564,12.265,14.663,12.344z"/>
            </g>
            </svg>
        </button>
      </div>
    </div>
  </div>
</template>
