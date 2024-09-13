
<script setup>
import DefaultLayout from "../Layouts/DefaultLayout.vue";
import Product from "../components/Product.vue";
import Cart from "../components/Cart.vue";
import {store} from "../store";
import {computed, onMounted} from "vue";
import SearchInput from "../components/SearchInput.vue";

onMounted(() => {
  store.setProducts(props.products)
})

const props = defineProps({
  products: Array
});
const productList = computed(() => {
  const cartItems = store.cart
  if(cartItems.length > 0) {
    return store.products.map((product) => {
      return {...product, qty: cartItems.find((item) => item.id === product.id)?.quantity || 0}
    })
  }
  return props.products
})
</script>
<template>
  <DefaultLayout>
    <SearchInput/>
    <div class="bg-white">
      <div v-if="store.products.length === 0">
        <div class="container mx-auto p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
          <span class="font-medium">No products, Try to import fixtures or change search values...</span>
        </div>
      </div>
      <div v-else>
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
          <h2 class="text-2xl font-bold tracking-tight text-gray-900">Products ({{store.products.length}})</h2>
          <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            <div class="group relative" v-for="product in productList" :key="product.id">
              <Product :product="product"/>
            </div>
          </div>

        </div>
      </div>
    </div>
    <div v-if="store.showCart">
      <Cart/>
    </div>
  </DefaultLayout>
</template>

