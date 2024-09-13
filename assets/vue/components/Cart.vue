<template>
  <div class="relative z-10" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">

    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 overflow-hidden">
      <div class="absolute inset-0 overflow-hidden">
        <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
          <div class="pointer-events-auto w-screen max-w-md">
            <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
              <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                <div class="flex items-start justify-between">
                  <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Shopping cart</h2>
                  <div class="ml-3 flex h-7 items-center">

                    <button @click="store.setCartVisibility(false)" type="button" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                      <span class="absolute -inset-0.5"></span>
                      <span class="sr-only">Close panel</span>
                      <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                           aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                      </svg>
                    </button>

                  </div>
                </div>

                <div class="mt-8">
                  <div class="flow-root">
                    <ul role="list" class="-my-6 divide-y divide-gray-200">
                      <li class=" py-6" v-if="store.cart.length === 0">
                        <div
                            class="w-100 p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
                            role="alert">
                          <span class="font-medium">No items!</span> Add products to cart.
                        </div>

                      </li>
                      <li v-for="cartItem in store.cart" class="flex py-6" :key="cartItem.id">
                        <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                          <img :src="cartItem.image"
                               :alt="cartItem.title"
                               class="h-full w-full object-cover object-center">
                        </div>

                        <div class="ml-4 flex flex-1 flex-col">
                          <div>
                            <div class="flex justify-between text-base font-medium text-gray-900">
                              <h3>
                                <a href="#">{{ cartItem.title }}</a>
                              </h3>
                              <p class="ml-4">${{ cartItem.price }}</p>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                              <span
                                  class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                                {{ cartItem.category }}
                              </span>
                            </p>
                          </div>
                          <div class="flex flex-1 items-end justify-between text-sm">
                            <p class="text-gray-500">Quantity:  x <strong>{{ cartItem.quantity }}</strong></p>
                            <div class="flex">
                              <button @click="store.removeFromCart(cartItem.id)" type="button"
                                      class="font-medium text-indigo-600 hover:text-indigo-500">Remove
                              </button>
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                <div class="flex justify-between text-base font-medium text-gray-900">
                  <p>Subtotal</p>
                  <p>${{ total.toFixed(2) }}}</p>
                </div>
                <div class="flex justify-between text-base font-medium text-gray-900">
                  <p>Discount</p>
                  <p class="bg-red-700 p-2" v-if="discount > 0"  >-  ${{ discount.toFixed(2) }}</p>
                  <p v-else>you need to buy ({{(total - store.discountMinimum).toFixed(2)}}) more to get a {{ store.discountAmount }}% discount</p>
                </div>
                <div class="flex justify-between text-base font-medium text-gray-900">
                  <p>New total</p>
                  <p class="bg-green-700 p-2">${{ (total - discount).toFixed(2) }}</p>
                </div>
                <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                <div class="mt-6">
                  <button :disabled="isCheckoutInProgress" @click.prevent="checkout"
                     class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">
                    <div class="flex gap-x-3 items-center">
                      Checkout
                      <div v-if="isCheckoutInProgress" role="status" >
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                          <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                      </div>
                    </div>
                  </button>

                </div>
                <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                  <p>
                    or
                    <button @click="store.setCartVisibility(false)" type="button"
                            class="font-medium text-indigo-600 hover:text-indigo-500">
                      Continue Shopping
                      <span aria-hidden="true"> &rarr;</span>
                    </button>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {store} from '../store'
import {computed, ref} from "vue";
const isCheckoutInProgress = ref(false)
const total = computed(() => store.total())
const discount = computed(() => store.discount())
const checkout = async () => {
  isCheckoutInProgress.value = true
  await store.submitCart()
  isCheckoutInProgress.value = false
  store.setCartVisibility(false)
  store.messages.push({
    message: 'Checkout completed, Data persisted in database successfully.',
    type: 'success'
  })
  scroll(0, 0)
}
</script>
