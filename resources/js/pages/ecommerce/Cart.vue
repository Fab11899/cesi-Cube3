<template>
    <div class="bg-white">
        <!-- Mobile menu -->
        <TransitionRoot as="template" :show="open">
            <Dialog class="relative z-40 lg:hidden" @close="open = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-black/25" />
                </TransitionChild>

                <div class="fixed inset-0 z-40 flex">
                    <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
                        <DialogPanel class="relative flex w-full max-w-xs flex-col overflow-y-auto bg-white pb-12 shadow-xl">
                            <div class="flex px-4 pt-5 pb-2">
                                <button type="button" class="-m-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400" @click="open = false">
                                    <span class="sr-only">Close menu</span>
                                    <XMarkIcon class="size-6" aria-hidden="true" />
                                </button>
                            </div>

                            <!-- Links -->
                            <TabGroup as="div" class="mt-2">
                                <div class="border-b border-gray-200">
                                    <TabList class="-mb-px flex space-x-8 px-4">
                                        <Tab as="template" v-for="category in navigation.categories" :key="category.name" v-slot="{ selected }">
                                            <button :class="[selected ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-900', 'flex-1 border-b-2 px-1 py-4 text-base font-medium whitespace-nowrap']">{{ category.name }}</button>
                                        </Tab>
                                    </TabList>
                                </div>
                                <TabPanels as="template">
                                    <TabPanel v-for="category in navigation.categories" :key="category.name" class="space-y-10 px-4 pt-10 pb-8">
                                        <div class="space-y-4">
                                            <div v-for="(item, itemIdx) in category.featured" :key="itemIdx" class="group relative overflow-hidden rounded-md bg-gray-100">
                                                <img :src="item.imageSrc" :alt="item.imageAlt" class="aspect-square w-full object-cover group-hover:opacity-75" />
                                                <div class="absolute inset-0 flex flex-col justify-end">
                                                    <div class="bg-white/60 p-4 text-base sm:text-sm">
                                                        <a :href="item.href" class="font-medium text-gray-900">
                                                            <span class="absolute inset-0" aria-hidden="true" />
                                                            {{ item.name }}
                                                        </a>
                                                        <p aria-hidden="true" class="mt-0.5 text-gray-700 sm:mt-1">Shop now</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-for="(column, columnIdx) in category.sections" :key="columnIdx" class="space-y-10">
                                            <div v-for="section in column" :key="section.name">
                                                <p :id="`${category.id}-${section.id}-heading-mobile`" class="font-medium text-gray-900">{{ section.name }}</p>
                                                <ul role="list" :aria-labelledby="`${category.id}-${section.id}-heading-mobile`" class="mt-6 flex flex-col space-y-6">
                                                    <li v-for="item in section.items" :key="item.name" class="flow-root">
                                                        <a :href="item.href" class="-m-2 block p-2 text-gray-500">{{ item.name }}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </TabPanel>
                                </TabPanels>
                            </TabGroup>

                            <div class="space-y-6 border-t border-gray-200 px-4 py-6">
                                <div v-for="page in navigation.pages" :key="page.name" class="flow-root">
                                    <a :href="page.href" class="-m-2 block p-2 font-medium text-gray-900">{{ page.name }}</a>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 px-4 py-6">
                                <a href="#" class="-m-2 flex items-center p-2">
                                    <img src="https://tailwindcss.com/plus-assets/img/flags/flag-canada.svg" alt="" class="block h-auto w-5 shrink-0" />
                                    <span class="ml-3 block text-base font-medium text-gray-900">CAD</span>
                                    <span class="sr-only">, change currency</span>
                                </a>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <header class="relative bg-white">
            <nav aria-label="Top" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="border-b border-gray-200">
                    <div class="flex h-16 items-center justify-between">
                        <div class="flex flex-1 items-center lg:hidden">
                            <button type="button" class="-ml-2 rounded-md bg-white p-2 text-gray-400" @click="open = true">
                                <span class="sr-only">Open menu</span>
                                <Bars3Icon class="size-6" aria-hidden="true" />
                            </button>

                            <a href="#" class="ml-2 p-2 text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Search</span>
                                <MagnifyingGlassIcon class="size-6" aria-hidden="true" />
                            </a>
                        </div>

                        <!-- Flyout menus -->
                        <PopoverGroup class="hidden lg:block lg:flex-1 lg:self-stretch">
                            <div class="flex h-full space-x-8">
                                <Popover v-for="category in navigation.categories" :key="category.name" class="flex" v-slot="{ open }">
                                    <div class="relative flex">
                                        <PopoverButton :class="[open ? 'text-indigo-600' : 'text-gray-700 hover:text-gray-800', 'relative z-10 flex items-center justify-center text-sm font-medium transition-colors duration-200 ease-out']">
                                            {{ category.name }}
                                            <span :class="[open ? 'bg-indigo-600' : '', 'absolute inset-x-0 bottom-0 h-0.5 transition-colors duration-200 ease-out sm:mt-5 sm:translate-y-px sm:transform']" aria-hidden="true" />
                                        </PopoverButton>
                                    </div>

                                    <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                        <PopoverPanel class="absolute inset-x-0 top-full">
                                            <!-- Presentational element used to render the bottom shadow, if we put the shadow on the actual panel it pokes out the top, so we use this shorter element to hide the top of the shadow -->
                                            <div class="absolute inset-0 top-1/2 bg-white shadow-sm" aria-hidden="true" />

                                            <div class="relative bg-white">
                                                <div class="mx-auto max-w-7xl px-8">
                                                    <div class="grid grid-cols-2 gap-x-8 gap-y-10 py-16">
                                                        <div class="grid grid-cols-2 grid-rows-1 gap-8 text-sm">
                                                            <div v-for="(item, itemIdx) in category.featured" :key="item.name" :class="[itemIdx === 0 ? 'col-span-2' : '', 'group relative overflow-hidden rounded-md bg-gray-100']">
                                                                <img :src="item.imageSrc" :alt="item.imageAlt" :class="[itemIdx === 0 ? 'aspect-2/1' : 'aspect-square', 'w-full object-cover group-hover:opacity-75']" />
                                                                <div class="absolute inset-0 flex flex-col justify-end">
                                                                    <div class="bg-white/60 p-4 text-sm">
                                                                        <a :href="item.href" class="font-medium text-gray-900">
                                                                            <span class="absolute inset-0" aria-hidden="true" />
                                                                            {{ item.name }}
                                                                        </a>
                                                                        <p aria-hidden="true" class="mt-0.5 text-gray-700 sm:mt-1">Shop now</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-3 gap-x-8 gap-y-10 text-sm text-gray-500">
                                                            <div v-for="(column, columnIdx) in category.sections" :key="columnIdx" class="space-y-10">
                                                                <div v-for="section in column" :key="section.name">
                                                                    <p :id="`${category.id}-${section.id}-heading`" class="font-medium text-gray-900">{{ section.name }}</p>
                                                                    <ul role="list" :aria-labelledby="`${category.id}-${section.id}-heading`" class="mt-4 space-y-4">
                                                                        <li v-for="item in section.items" :key="item.name" class="flex">
                                                                            <a :href="item.href" class="hover:text-gray-800">{{ item.name }}</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </PopoverPanel>
                                    </transition>
                                </Popover>

                                <a v-for="page in navigation.pages" :key="page.name" :href="page.href" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">{{ page.name }}</a>
                            </div>
                        </PopoverGroup>

                        <!-- Logo -->
                        <a href="/" class="flex">
                            <span class="sr-only">Your Company</span>
                            <img class="h-8 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="" />
                        </a>

                        <div class="flex flex-1 items-center justify-end">
                            <a href="#" class="hidden text-gray-700 hover:text-gray-800 lg:flex lg:items-center">
                                <img src="https://tailwindcss.com/plus-assets/img/flags/flag-canada.svg" alt="" class="block h-auto w-5 shrink-0" />
                                <span class="ml-3 block text-sm font-medium">CAD</span>
                                <span class="sr-only">, change currency</span>
                            </a>

                            <!-- Search -->
                            <a href="#" class="ml-6 hidden p-2 text-gray-400 hover:text-gray-500 lg:block">
                                <span class="sr-only">Search</span>
                                <MagnifyingGlassIcon class="size-6" aria-hidden="true" />
                            </a>

                            <!-- Account -->
                            <a href="#" class="p-2 text-gray-400 hover:text-gray-500 lg:ml-4">
                                <span class="sr-only">Account</span>
                                <UserIcon class="size-6" aria-hidden="true" />
                            </a>

                            <!-- Cart -->
                            <div class="ml-4 flow-root lg:ml-6">
                                <a href="cart" class="group -m-2 flex items-center p-2">
                                    <ShoppingBagIcon class="size-6 shrink-0 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                    <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">0</span>
                                    <span class="sr-only">items in cart, view bag</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:px-0">
                <h1 class="text-center text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Shopping Cart</h1>

                <form class="mt-12">
                    <section aria-labelledby="cart-heading">
                        <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>

                        <ul role="list" class="divide-y divide-gray-200 border-t border-b border-gray-200">
                            <li v-for="product in products" :key="product.product_id" class="flex py-6">
                                <div class="shrink-0">
                                    <img :src="product.image_src" :alt="product.image_alt" class="size-24 rounded-md object-cover sm:size-32" />
                                </div>

                                <div class="ml-4 flex flex-1 flex-col sm:ml-6">
                                    <div>
                                        <div class="flex justify-between">
                                            <h4 class="text-sm">
                                                <a :href="product.href" class="font-medium text-gray-700 hover:text-gray-800">{{ product.name }}</a>
                                            </h4>
                                            <p class="ml-4 text-sm font-medium text-gray-900">{{ product.price }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-4 flex flex-1 items-end justify-between">
                                        <p class="flex items-center space-x-2 text-sm text-gray-700">
                                            <CheckIcon v-if="product.inStock" class="size-5 shrink-0 text-green-500" aria-hidden="true" />
                                            <ClockIcon v-else class="size-5 shrink-0 text-gray-300" aria-hidden="true" />
                                            <span>{{ product.inStock ? 'In stock' : `Will ship in ${product.leadTime}` }}</span>
                                        </p>
                                        <div class="ml-4">
                                            <button type="button" @click.prevent="removeFromCart(product.product_id)" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                                <span>Remove</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <!-- Order summary -->
                    <section aria-labelledby="summary-heading" class="mt-10">
                        <h2 id="summary-heading" class="sr-only">Order summary</h2>

                        <div>
                            <dl class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <dt class="text-base font-medium text-gray-900">Subtotal</dt>
                                    <dd class="ml-4 text-base font-medium text-gray-900">$96.00</dd>
                                </div>
                            </dl>
                            <p class="mt-1 text-sm text-gray-500">Shipping and taxes will be calculated at checkout.</p>
                        </div>

                        <div class="mt-10">
                            <button type="submit" class="w-full rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-xs hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50 focus:outline-hidden">Checkout</button>
                        </div>

                        <div class="mt-6 text-center text-sm text-gray-500">
                            <p>
                                or{{ ' ' }}
                                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                    Continue Shopping
                                    <span aria-hidden="true"> &rarr;</span>
                                </a>
                            </p>
                        </div>
                    </section>
                </form>
            </div>

            <!-- Policy grid -->
            <section aria-labelledby="policies-heading" class="border-t border-gray-200 bg-gray-50">
                <h2 id="policies-heading" class="sr-only">Our policies</h2>

                <div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 sm:py-32 lg:px-8">
                    <div class="grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 lg:gap-x-8 lg:gap-y-0">
                        <div v-for="policy in policies" :key="policy.name" class="text-center md:flex md:items-start md:text-left lg:block lg:text-center">
                            <div class="md:shrink-0">
                                <div class="flow-root">
                                    <img class="mx-auto -my-1 h-24 w-auto" :src="policy.imageUrl" alt="" />
                                </div>
                            </div>
                            <div class="mt-6 md:mt-0 md:ml-4 lg:mt-6 lg:ml-0">
                                <h3 class="text-base font-medium text-gray-900">{{ policy.name }}</h3>
                                <p class="mt-3 text-sm text-gray-500">{{ policy.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer aria-labelledby="footer-heading" class="bg-gray-50">
            <h2 id="footer-heading" class="sr-only">Footer</h2>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="border-t border-gray-200 py-20">
                    <div class="grid grid-cols-1 md:grid-flow-col md:auto-rows-min md:grid-cols-12 md:gap-x-8 md:gap-y-16">
                        <!-- Image section -->
                        <div class="col-span-1 md:col-span-2 lg:col-start-1 lg:row-start-1">
                            <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="" class="h-8 w-auto" />
                        </div>

                        <!-- Sitemap sections -->
                        <div class="col-span-6 mt-10 grid grid-cols-2 gap-8 sm:grid-cols-3 md:col-span-8 md:col-start-3 md:row-start-1 md:mt-0 lg:col-span-6 lg:col-start-2">
                            <div class="grid grid-cols-1 gap-y-12 sm:col-span-2 sm:grid-cols-2 sm:gap-x-8">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Products</h3>
                                    <ul role="list" class="mt-6 space-y-6">
                                        <li v-for="item in footerNavigation.products" :key="item.name" class="text-sm">
                                            <a :href="item.href" class="text-gray-500 hover:text-gray-600">{{ item.name }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Company</h3>
                                    <ul role="list" class="mt-6 space-y-6">
                                        <li v-for="item in footerNavigation.company" :key="item.name" class="text-sm">
                                            <a :href="item.href" class="text-gray-500 hover:text-gray-600">{{ item.name }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">Customer Service</h3>
                                <ul role="list" class="mt-6 space-y-6">
                                    <li v-for="item in footerNavigation.customerService" :key="item.name" class="text-sm">
                                        <a :href="item.href" class="text-gray-500 hover:text-gray-600">{{ item.name }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Newsletter section -->
                        <div class="mt-12 md:col-span-8 md:col-start-3 md:row-start-2 md:mt-0 lg:col-span-4 lg:col-start-9 lg:row-start-1">
                            <h3 class="text-sm font-medium text-gray-900">Sign up for our newsletter</h3>
                            <p class="mt-6 text-sm text-gray-500">The latest deals and savings, sent to your inbox weekly.</p>
                            <form class="mt-2 flex sm:max-w-md">
                                <input id="email-address" type="text" autocomplete="email" required="" aria-label="Email address" class="block w-full rounded-md bg-white px-4 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" />
                                <div class="ml-4 shrink-0">
                                    <button type="submit" class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-xs hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-hidden">Sign up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 py-10 text-center">
                    <p class="text-sm text-gray-500">&copy; 2021 Your Company, Inc. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import {
    Dialog,
    DialogPanel,
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
    Tab,
    TabGroup,
    TabList,
    TabPanel,
    TabPanels,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import { Bars3Icon, MagnifyingGlassIcon, ShoppingBagIcon, UserIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { CheckIcon, ClockIcon } from '@heroicons/vue/20/solid'
import axios from 'axios'

const products = ref([])
const loading = ref(true)
onMounted(() => {
    loadCartProducts()
})


const loadCartProducts = async () => {
    loading.value = true
    try {
        const response = await axios.get('/api/cart') // Adjust the endpoint as needed
        products.value = response.data
        // Avec l'ID produit, on récupère les détails des produits
        for (const product of products.value) {
            const productResponse = await axios.get(`/api/product/${product.product_id}`) // Adjust the endpoint as needed
            Object.assign(product, productResponse.data)
        }
    } catch (error) {
        console.error('Error fetching products:', error)
    } finally {
        loading.value = false
    }
}
const removeFromCart = async (productId) => {
    try {
        const response = await axios.delete(`/api/cart/remove/${productId}`)
        alert('Produit retiré du panier !')
        products.value = response.data.cart
        await loadCartProducts() // ← recharge tout le panier
    } catch (error) {
        console.error('Erreur suppression :', error)
        alert("Erreur lors de la suppression du produit")
    }
}



const navigation = {
    categories: [
        {
            id: 'women',
            name: 'Women',
            featured: [
                {
                    name: 'New Arrivals',
                    href: 'category',
                    imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/mega-menu-category-01.jpg',
                    imageAlt: 'Models sitting back to back, wearing Basic Tee in black and bone.',
                },
                {
                    name: 'Basic Tees',
                    href: 'category',
                    imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/mega-menu-category-02.jpg',
                    imageAlt: 'Close up of Basic Tee fall bundle with off-white, ochre, olive, and black tees.',
                },
                {
                    name: 'Accessories',
                    href: 'category',
                    imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/mega-menu-category-03.jpg',
                    imageAlt: 'Model wearing minimalist watch with black wristband and white watch face.',
                },
            ],
            sections: [
                [
                    {
                        id: 'shoes',
                        name: 'Shoes & Accessories',
                        items: [
                            { name: 'Sneakers', href: 'category' },
                            { name: 'Boots', href: 'category' },
                            { name: 'Flats', href: 'category' },
                            { name: 'Sandals', href: 'category' },
                            { name: 'Heels', href: 'category' },
                            { name: 'Socks', href: 'category' },
                        ],
                    },
                    {
                        id: 'collection',
                        name: 'Shop Collection',
                        items: [
                            { name: 'Everything', href: 'category' },
                            { name: 'Core', href: 'category' },
                            { name: 'New Arrivals', href: 'category' },
                            { name: 'Sale', href: 'category' },
                            { name: 'Accessories', href: 'category' },
                        ],
                    },
                ],
                [
                    {
                        id: 'clothing',
                        name: 'All Clothing',
                        items: [
                            { name: 'Basic Tees', href: 'category' },
                            { name: 'Artwork Tees', href: 'category' },
                            { name: 'Tops', href: 'category' },
                            { name: 'Bottoms', href: 'category' },
                            { name: 'Swimwear', href: 'category' },
                            { name: 'Underwear', href: 'category' },
                        ],
                    },
                    {
                        id: 'accessories',
                        name: 'All Accessories',
                        items: [
                            { name: 'Watches', href: 'category' },
                            { name: 'Wallets', href: 'category' },
                            { name: 'Bags', href: 'category' },
                            { name: 'Sunglasses', href: 'category' },
                            { name: 'Hats', href: 'category' },
                            { name: 'Belts', href: 'category' },
                        ],
                    },
                ],
                [
                    {
                        id: 'brands',
                        name: 'Brands',
                        items: [
                            { name: 'Full Nelson', href: 'category' },
                            { name: 'My Way', href: 'category' },
                            { name: 'Re-Arranged', href: 'category' },
                            { name: 'Counterfeit', href: 'category' },
                            { name: 'Significant Other', href: 'category' },
                        ],
                    },
                ],
            ],
        },
        {
            id: 'men',
            name: 'Men',
            featured: [
                {
                    name: 'Accessories',
                    href: 'category',
                    imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/home-page-03-category-01.jpg',
                    imageAlt:
                        'Wooden shelf with gray and olive drab green baseball caps, next to wooden clothes hanger with sweaters.',
                },
                {
                    name: 'New Arrivals',
                    href: 'category',
                    imageSrc:
                        'https://tailwindcss.com/plus-assets/img/ecommerce-images/product-page-04-detail-product-shot-01.jpg',
                    imageAlt: 'Drawstring top with elastic loop closure and textured interior padding.',
                },
                {
                    name: 'Artwork Tees',
                    href: 'category',
                    imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/category-page-02-image-card-06.jpg',
                    imageAlt:
                        'Three shirts in gray, white, and blue arranged on table with same line drawing of hands and shapes overlapping on front of shirt.',
                },
            ],
            sections: [
                [
                    {
                        id: 'shoes',
                        name: 'Shoes & Accessories',
                        items: [
                            { name: 'Sneakers', href: 'category' },
                            { name: 'Boots', href: 'category' },
                            { name: 'Sandals', href: 'category' },
                            { name: 'Socks', href: 'category' },
                        ],
                    },
                    {
                        id: 'collection',
                        name: 'Shop Collection',
                        items: [
                            { name: 'Everything', href: 'category' },
                            { name: 'Core', href: 'category' },
                            { name: 'New Arrivals', href: 'category' },
                            { name: 'Sale', href: 'category' },
                        ],
                    },
                ],
                [
                    {
                        id: 'clothing',
                        name: 'All Clothing',
                        items: [
                            { name: 'Basic Tees', href: 'category' },
                            { name: 'Artwork Tees', href: 'category' },
                            { name: 'Pants', href: 'category' },
                            { name: 'Hoodies', href: 'category' },
                            { name: 'Swimsuits', href: 'category' },
                        ],
                    },
                    {
                        id: 'accessories',
                        name: 'All Accessories',
                        items: [
                            { name: 'Watches', href: 'category' },
                            { name: 'Wallets', href: 'category' },
                            { name: 'Bags', href: 'category' },
                            { name: 'Sunglasses', href: 'category' },
                            { name: 'Hats', href: 'category' },
                            { name: 'Belts', href: 'category' },
                        ],
                    },
                ],
                [
                    {
                        id: 'brands',
                        name: 'Brands',
                        items: [
                            { name: 'Re-Arranged', href: 'category' },
                            { name: 'Counterfeit', href: 'category' },
                            { name: 'Full Nelson', href: 'category' },
                            { name: 'My Way', href: 'category' },
                        ],
                    },
                ],
            ],
        },
    ],
    pages: [
        { name: 'Company', href: 'category' },
        { name: 'Stores', href: 'category' },
    ],
}
/*const products = [
    {
        id: 1,
        name: 'Artwork Tee',
        href: '#',
        price: '$32.00',
        color: 'Mint',
        size: 'Medium',
        inStock: true,
        imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/checkout-page-03-product-04.jpg',
        imageAlt: 'Front of mint cotton t-shirt with wavey lines pattern.',
    },
]*/
const policies = [
    {
        name: 'Free returns',
        imageUrl: 'https://tailwindcss.com/plus-assets/img/ecommerce/icons/icon-returns-light.svg',
        description: 'Not what you expected? Place it back in the parcel and attach the pre-paid postage stamp.',
    },
    {
        name: 'Same day delivery',
        imageUrl: 'https://tailwindcss.com/plus-assets/img/ecommerce/icons/icon-calendar-light.svg',
        description:
            'We offer a delivery service that has never been done before. Checkout today and receive your products within hours.',
    },
    {
        name: 'All year discount',
        imageUrl: 'https://tailwindcss.com/plus-assets/img/ecommerce/icons/icon-gift-card-light.svg',
        description: 'Looking for a deal? You can use the code "ALLYEAR" at checkout and get money off all year round.',
    },
    {
        name: 'For the planet',
        imageUrl: 'https://tailwindcss.com/plus-assets/img/ecommerce/icons/icon-planet-light.svg',
        description: 'We’ve pledged 1% of sales to the preservation and restoration of the natural environment.',
    },
]
const footerNavigation = {
    products: [
        { name: 'Bags', href: 'category' },
        { name: 'Tees', href: 'category' },
        { name: 'Objects', href: 'category' },
        { name: 'Home Goods', href: 'category' },
        { name: 'Accessories', href: 'category' },
    ],
    company: [
        { name: 'Who we are', href: '#' },
        { name: 'Sustainability', href: '#' },
        { name: 'Press', href: '#' },
        { name: 'Careers', href: '#' },
        { name: 'Terms & Conditions', href: '#' },
        { name: 'Privacy', href: '#' },
    ],
    customerService: [
        { name: 'Contact', href: '#' },
        { name: 'Shipping', href: '#' },
        { name: 'Returns', href: '#' },
        { name: 'Warranty', href: '#' },
        { name: 'Secure Payments', href: '#' },
        { name: 'FAQ', href: '#' },
        { name: 'Find a store', href: '#' },
    ],
}

const open = ref(false)
</script>
