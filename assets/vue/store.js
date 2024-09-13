import {reactive} from 'vue'

export const store = reactive({
  cart: JSON.parse(window.localStorage.getItem('cart')) || [],
  products: [],
  discountAmount: 10,
  discountMinimum: 1000,
  messages: [],
  maxQty: 5,
  total() {
    return this.cart.reduce((previousValue, currentValue) => {
      return previousValue + (currentValue.quantity * currentValue.price)
    }, 0)
  },
  showCart: false,
  setProducts(products) {
    this.products = products
  },
  discount() {
    const total = this.total()
    if (total >= this.discountMinimum) {
      return (total * 10) / 100
    }
    return 0
  },
  updateCart(product, quantity) {
    const isInCart = this.cart.some((val) => {
      return val.id === product.id
    })
    if (!isInCart) {
      this.cart.push({...product, quantity})
    } else {
      this.cart = this.cart.map((cartItem) => {
        if (cartItem.id === product.id) {
          return {...product, quantity}
        }
        return cartItem
      })
    }
    window.localStorage.setItem('cart', JSON.stringify(this.cart))
    this.setCartVisibility(true)
  },
  async submitCart() {
    await fetch('/api/carts', {
      method: 'POST',
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        items: this.cart,
        active: true,
      })
    }).catch((error) => {
      console.log(error)
    })
  },
  removeFromCart(productId) {
    this.cart = this.cart.filter(product => product.id !== productId)
    window.localStorage.setItem('cart', this.cart)
  },
  setCartVisibility(visible) {
    this.showCart = visible
  }
})