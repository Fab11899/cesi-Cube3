<template>
    <div v-if="loading">
        Chargement en cours...
    </div>
    <div v-else-if="products">
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
                                        <PopoverPanel class="absolute inset-x-0 top-full z-10">
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
                                <a href="/cart" class="group -m-2 flex items-center p-2">
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

        <main class="mx-auto mt-8 max-w-2xl px-4 pb-16 sm:px-6 sm:pb-24 lg:max-w-7xl lg:px-8">
            <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8">
                <div class="lg:col-span-5 lg:col-start-8">
                    <div class="flex justify-between">
                        <h1 class="text-xl font-medium text-gray-900">{{ products.name }}</h1>
                        <p class="text-xl font-medium text-gray-900">{{ products.price }}</p>
                    </div>
                    <!-- Reviews -->
                    <div class="mt-4">
                        <h2 class="sr-only">Reviews</h2>
                        <div class="flex items-center">
                            <p class="text-sm text-gray-700">
                                {{ reviews.average }}
                                <span class="sr-only"> out of 5 stars</span>
                            </p>
                            <div class="ml-1 flex items-center">
                                <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[reviews.average > rating ? 'text-yellow-400' : 'text-gray-200', 'size-5 shrink-0']" aria-hidden="true" />
                            </div>
                            <div aria-hidden="true" class="ml-4 text-sm text-gray-300">·</div>
                            <div class="ml-4 flex">
                                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">See all {{ reviews.totalCount }} reviews</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image gallery -->
                <div class="mt-8 lg:col-span-7 lg:col-start-1 lg:row-span-3 lg:row-start-1 lg:mt-0">
                    <h2 class="sr-only">Images</h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-3 lg:gap-8">
                        <img  :key="products.id" :src="products.image_src" :alt="products.image_alt" :class="'lg:col-span-2 lg:row-span-2'" />
                    </div>
                </div>

                <div class="mt-8 lg:col-span-5">
                    <form>
                        <button type="submit" @click.prevent="addToCart(products)"  class="mt-8 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-hidden">Add to cart</button>
                    </form>
                    <!-- Product details -->
                    <div class="mt-10">
                        <h2 class="text-sm font-medium text-gray-900">Description</h2>
                        <div class="mt-4 space-y-4 text-sm/6 text-gray-500">
                            <p>The Basic tee is an honest new take on a classic. The tee uses super soft, pre-shrunk cotton for true comfort and a dependable fit. They are hand cut and sewn locally, with a special dye technique that gives each tee it's own look.</p>
                            <p>Looking to stock your closet? The Basic tee also comes in a 3-pack or 5-pack at a bundle discount.</p>
                        </div>
                    </div>

                    <!-- Policies -->
                    <section aria-labelledby="policies-heading" class="mt-10">
                        <h2 id="policies-heading" class="sr-only">Our Policies</h2>

                        <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                            <div v-for="policy in policies" :key="policy.name" class="rounded-lg border border-gray-200 bg-gray-50 p-6 text-center">
                                <dt>
                                    <component :is="policy.icon" class="mx-auto size-6 shrink-0 text-gray-400" aria-hidden="true" />
                                    <span class="mt-4 text-sm font-medium text-gray-900">{{ policy.name }}</span>
                                </dt>
                                <dd class="mt-1 text-sm text-gray-500">{{ policy.description }}</dd>
                            </div>
                        </dl>
                    </section>
                </div>
            </div>

            <!-- Reviews -->
            <section aria-labelledby="reviews-heading" class="mt-16 sm:mt-24">
                <h2 id="reviews-heading" class="text-lg font-medium text-gray-900">Recent reviews</h2>

                <div class="mt-6 divide-y divide-gray-200 border-t border-b border-gray-200">
                    <div v-for="review in reviews.featured" :key="review.id" class="py-10 lg:grid lg:grid-cols-12 lg:gap-x-8">
                        <div class="lg:col-span-8 lg:col-start-5 xl:col-span-9 xl:col-start-4 xl:grid xl:grid-cols-3 xl:items-start xl:gap-x-8">
                            <div class="flex items-center xl:col-span-1">
                                <div class="flex items-center">
                                    <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[review.rating > rating ? 'text-yellow-400' : 'text-gray-200', 'size-5 shrink-0']" aria-hidden="true" />
                                </div>
                                <p class="ml-3 text-sm text-gray-700">{{ review.rating }}<span class="sr-only"> out of 5 stars</span></p>
                            </div>

                            <div class="mt-4 lg:mt-6 xl:col-span-2 xl:mt-0">
                                <h3 class="text-sm font-medium text-gray-900">{{ review.title }}</h3>

                                <div class="mt-3 space-y-6 text-sm text-gray-500" v-html="review.content" />
                            </div>
                        </div>

                        <div class="mt-6 flex items-center text-sm lg:col-span-4 lg:col-start-1 lg:row-start-1 lg:mt-0 lg:flex-col lg:items-start xl:col-span-3">
                            <p class="font-medium text-gray-900">{{ review.author }}</p>
                            <time :datetime="review.datetime" class="ml-4 border-l border-gray-200 pl-4 text-gray-500 lg:mt-2 lg:ml-0 lg:border-0 lg:pl-0">{{ review.date }}</time>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer aria-labelledby="footer-heading">
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
    </div>
    <div v-else>
        Produit introuvable.
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
    RadioGroup,
    RadioGroupOption,
    Tab,
    TabGroup,
    TabList,
    TabPanel,
    TabPanels,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import {
    Bars3Icon,
    CurrencyDollarIcon,
    GlobeAmericasIcon,
    MagnifyingGlassIcon,
    ShoppingBagIcon,
    UserIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'
import { StarIcon } from '@heroicons/vue/20/solid'
import { usePage } from '@inertiajs/vue3'
import axios from 'axios'

const navigation = {
    categories: [
        {
            id: 'women',
            name: 'Women',
            featured: [
                {
                    name: 'New Arrivals',
                    href: 'categroy',
                    imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/mega-menu-category-01.jpg',
                    imageAlt: 'Models sitting back to back, wearing Basic Tee in black and bone.',
                },
                {
                    name: 'Basic Tees',
                    href: 'categroy',
                    imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/mega-menu-category-02.jpg',
                    imageAlt: 'Close up of Basic Tee fall bundle with off-white, ochre, olive, and black tees.',
                },
                {
                    name: 'Accessories',
                    href: 'categroy',
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
                            { name: 'Sneakers', href: '/' },
                            { name: 'Boots', href: '/' },
                            { name: 'Flats', href: '/' },
                            { name: 'Sandals', href: '/' },
                            { name: 'Heels', href: '/' },
                            { name: 'Socks', href: '/' },
                        ],
                    },
                    {
                        id: 'collection',
                        name: 'Shop Collection',
                        items: [
                            { name: 'Everything', href: '/' },
                            { name: 'Core', href: '/' },
                            { name: 'New Arrivals', href: '/' },
                            { name: 'Sale', href: '/' },
                            { name: 'Accessories', href: '/' },
                        ],
                    },
                ],
                [
                    {
                        id: 'clothing',
                        name: 'All Clothing',
                        items: [
                            { name: 'Basic Tees', href: '/' },
                            { name: 'Artwork Tees', href: '/' },
                            { name: 'Tops', href: '/' },
                            { name: 'Bottoms', href: '/' },
                            { name: 'Swimwear', href: '/' },
                            { name: 'Underwear', href: '/' },
                        ],
                    },
                    {
                        id: 'accessories',
                        name: 'All Accessories',
                        items: [
                            { name: 'Watches', href: '/' },
                            { name: 'Wallets', href: '/' },
                            { name: 'Bags', href: '/' },
                            { name: 'Sunglasses', href: '/' },
                            { name: 'Hats', href: '/' },
                            { name: 'Belts', href: '/' },
                        ],
                    },
                ],
                [
                    {
                        id: 'brands',
                        name: 'Brands',
                        items: [
                            { name: 'Full Nelson', href: '/' },
                            { name: 'My Way', href: '/' },
                            { name: 'Re-Arranged', href: '/' },
                            { name: 'Counterfeit', href: '/' },
                            { name: 'Significant Other', href: '/' },
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
                    href: '/',
                    imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/home-page-03-category-01.jpg',
                    imageAlt:
                        'Wooden shelf with gray and olive drab green baseball caps, next to wooden clothes hanger with sweaters.',
                },
                {
                    name: 'New Arrivals',
                    href: '/',
                    imageSrc:
                        'https://tailwindcss.com/plus-assets/img/ecommerce-images/product-page-04-detail-product-shot-01.jpg',
                    imageAlt: 'Drawstring top with elastic loop closure and textured interior padding.',
                },
                {
                    name: 'Artwork Tees',
                    href: '/',
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
                            { name: 'Sneakers', href: '/' },
                            { name: 'Boots', href: '/' },
                            { name: 'Sandals', href: '/' },
                            { name: 'Socks', href: '/' },
                        ],
                    },
                    {
                        id: 'collection',
                        name: 'Shop Collection',
                        items: [
                            { name: 'Everything', href: '/' },
                            { name: 'Core', href: '/' },
                            { name: 'New Arrivals', href: '/' },
                            { name: 'Sale', href: '/' },
                        ],
                    },
                ],
                [
                    {
                        id: 'clothing',
                        name: 'All Clothing',
                        items: [
                            { name: 'Basic Tees', href: '/' },
                            { name: 'Artwork Tees', href: '/' },
                            { name: 'Pants', href: '/' },
                            { name: 'Hoodies', href: '/' },
                            { name: 'Swimsuits', href: '/' },
                        ],
                    },
                    {
                        id: 'accessories',
                        name: 'All Accessories',
                        items: [
                            { name: 'Watches', href: '/' },
                            { name: 'Wallets', href: '/' },
                            { name: 'Bags', href: '/' },
                            { name: 'Sunglasses', href: '/' },
                            { name: 'Hats', href: '/' },
                            { name: 'Belts', href: '/' },
                        ],
                    },
                ],
                [
                    {
                        id: 'brands',
                        name: 'Brands',
                        items: [
                            { name: 'Re-Arranged', href: '/' },
                            { name: 'Counterfeit', href: '/' },
                            { name: 'Full Nelson', href: '/' },
                            { name: 'My Way', href: '/' },
                        ],
                    },
                ],
            ],
        },
    ],
    pages: [
        { name: 'Company', href: '/' },
        { name: 'Stores', href: '/' },
    ],
}

const { props } = usePage()
const id = props.productId

const products = ref(null)
const loading = ref(true)

onMounted(async () => {
    try {
        const response = await axios.get(`/api/product/${id}`)
        products.value = response.data
    } catch (error) {
        console.error('Erreur lors du chargement du produit :', error)
    } finally {
        loading.value = false
    }
})
const policies = [
    { name: 'International delivery', icon: GlobeAmericasIcon, description: 'Get your order in 2 years' },
    { name: 'Loyalty rewards', icon: CurrencyDollarIcon, description: "Don't look at other tees" },
]
const reviews = {
    average: 3.9,
    totalCount: 512,
    featured: [
        {
            id: 1,
            title: "Can't say enough good things",
            rating: 5,
            content: `
        <p>I was really pleased with the overall shopping experience. My order even included a little personal, handwritten note, which delighted me!</p>
        <p>The product quality is amazing, it looks and feel even better than I had anticipated. Brilliant stuff! I would gladly recommend this store to my friends. And, now that I think of it... I actually have, many times!</p>
      `,
            author: 'Risako M',
            date: 'May 16, 2021',
            datetime: '2021-01-06',
        },
        // More reviews...
    ],
}
const relatedProducts = [
    {
        id: 1,
        name: 'Basic Tee',
        href: 'product',
        imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/product-page-01-related-product-02.jpg',
        imageAlt: "Front of men's Basic Tee in white.",
        price: '$35',
        color: 'Aspen White',
    },
    // More products...
]
const footerNavigation = {
    products: [
        { name: 'Bags', href: '/' },
        { name: 'Tees', href: '/' },
        { name: 'Objects', href: '/' },
        { name: 'Home Goods', href: '/' },
        { name: 'Accessories', href: '/' },
    ],
    company: [
        { name: 'Who we are', href: '/' },
        { name: 'Sustainability', href: '/' },
        { name: 'Press', href: '/' },
        { name: 'Careers', href: '/' },
        { name: 'Terms & Conditions', href: '/' },
        { name: 'Privacy', href: '/' },
    ],
    customerService: [
        { name: 'Contact', href: '/' },
        { name: 'Shipping', href: '/' },
        { name: 'Returns', href: '/' },
        { name: 'Warranty', href: '/' },
        { name: 'Secure Payments', href: '/' },
        { name: 'FAQ', href: '/' },
        { name: 'Find a store', href: '/' },
    ],
}


const addToCart = async (products) => {
    // On tente un await sans données juste pour voir si la route nous renvoie qqch
    try {
        await axios.post('/api/cart/add' , {
            product_id: products.id,
            name: products.name,
            price: parseFloat(products.price), // si le prix est un string avec $
            quantity: 1
        })
        alert('Ajouté au panier !')
    } catch (error) {
        console.error(error)
        alert("Erreur lors de l'ajout au panier")
    }
    /*try {
        await axios.post('/api/cart/add', {
            product_id: products.id,
            name: products.name,
            price: parseFloat(products.price.replace('$', '')), // si le prix est un string avec $
            quantity: 1
        })
        alert('Ajouté au panier !')
    } catch (error) {
        console.error(error)
        alert("Erreur lors de l'ajout au panier")
    }*/
}

const open = ref(false)
</script>
