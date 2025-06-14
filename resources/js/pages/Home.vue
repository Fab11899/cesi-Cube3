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
                                    <TabPanel v-for="category in navigation.categories" :key="category.name" class="space-y-12 px-4 py-6">
                                        <div class="grid grid-cols-2 gap-x-4 gap-y-10">
                                            <div v-for="item in category.featured" :key="item.name" class="group relative">
                                                <img :src="item.imageSrc" :alt="item.imageAlt" class="aspect-square w-full rounded-md bg-gray-100 object-cover group-hover:opacity-75" />
                                                <a :href="item.href" class="mt-6 block text-sm font-medium text-gray-900">
                                                    <span class="absolute inset-0 z-10" aria-hidden="true" />
                                                    {{ item.name }}
                                                </a>
                                                <p aria-hidden="true" class="mt-1 text-sm text-gray-500">Shop now</p>
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

                            <div class="space-y-6 border-t border-gray-200 px-4 py-6">
                                <div class="flow-root">
                                    <a href="#" class="-m-2 block p-2 font-medium text-gray-900">Create an account</a>
                                </div>
                                <div class="flow-root">
                                    <a href="#" class="-m-2 block p-2 font-medium text-gray-900">Sign in</a>
                                </div>
                            </div>

                            <div class="space-y-6 border-t border-gray-200 px-4 py-6">
                                <!-- Currency selector -->
                                <form>
                                    <div class="-ml-2 inline-grid grid-cols-1">
                                        <select id="mobile-currency" name="currency" aria-label="Currency" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-0.5 pr-7 pl-2 text-base font-medium text-gray-700 group-hover:text-gray-800 focus:outline-2 sm:text-sm/6">
                                            <option v-for="currency in currencies" :key="currency">{{ currency }}</option>
                                        </select>
                                        <ChevronDownIcon class="pointer-events-none col-start-1 row-start-1 mr-1 size-5 self-center justify-self-end fill-gray-500" aria-hidden="true" />
                                    </div>
                                </form>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <header class="relative">
            <nav aria-label="Top">
                <!-- Top navigation -->
                <div class="bg-gray-900">
                    <div class="mx-auto flex h-10 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                        <!-- Currency selector -->
                        <form>
                            <div class="-ml-2 inline-grid grid-cols-1">
                                <select id="desktop-currency" name="currency" aria-label="Currency" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-gray-900 py-0.5 pr-7 pl-2 text-left text-base font-medium text-white focus:outline-2 focus:-outline-offset-1 focus:outline-white sm:text-sm/6">
                                    <option v-for="currency in currencies" :key="currency">{{ currency }}</option>
                                </select>
                                <ChevronDownIcon class="pointer-events-none col-start-1 row-start-1 mr-1 size-5 self-center justify-self-end fill-gray-300" aria-hidden="true" />
                            </div>
                        </form>

                        <div class="flex items-center space-x-6">
                            <a href="#" class="text-sm font-medium text-white hover:text-gray-100">Sign in</a>
                            <a href="#" class="text-sm font-medium text-white hover:text-gray-100">Create an account</a>
                        </div>
                    </div>
                </div>

                <!-- Secondary navigation -->
                <div class="bg-white">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="flex h-16 items-center justify-between">
                            <!-- Logo (lg+) -->
                            <div class="hidden lg:flex lg:flex-1 lg:items-center">
                                <a href="/">
                                    <span class="sr-only">Your Company</span>
                                    <img class="h-8 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="" />
                                </a>
                            </div>

                            <div class="hidden h-full lg:flex">
                                <!-- Flyout menus -->
                                <PopoverGroup class="inset-x-0 bottom-0 px-4">
                                    <div class="flex h-full justify-center space-x-8">
                                        <Popover v-for="category in navigation.categories" :key="category.name" class="flex" v-slot="{ open }">
                                            <div class="relative flex">
                                                <PopoverButton :class="[open ? 'text-indigo-600' : 'text-gray-700 hover:text-gray-800', 'relative flex items-center justify-center text-sm font-medium transition-colors duration-200 ease-out']">
                                                    {{ category.name }}
                                                    <span :class="[open ? 'bg-indigo-600' : '', 'absolute inset-x-0 -bottom-px z-20 h-0.5 transition duration-200 ease-out']" aria-hidden="true" />
                                                </PopoverButton>
                                            </div>

                                            <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                                <PopoverPanel class="absolute inset-x-0 top-full z-10 bg-white text-sm text-gray-500">
                                                    <!-- Presentational element used to render the bottom shadow, if we put the shadow on the actual panel it pokes out the top, so we use this shorter element to hide the top of the shadow -->
                                                    <div class="absolute inset-0 top-1/2 bg-white shadow-sm" aria-hidden="true" />
                                                    <!-- Fake border when menu is open -->
                                                    <div class="absolute inset-0 top-0 mx-auto h-px max-w-7xl px-8" aria-hidden="true">
                                                        <div :class="[open ? 'bg-gray-200' : 'bg-transparent', 'h-px w-full transition-colors duration-200 ease-out']" />
                                                    </div>

                                                    <div class="relative">
                                                        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                                                            <div class="grid grid-cols-4 gap-x-8 gap-y-10 py-16">
                                                                <div v-for="item in category.featured" :key="item.name" class="group relative">
                                                                    <img :src="item.imageSrc" :alt="item.imageAlt" class="aspect-square w-full rounded-md bg-gray-100 object-cover group-hover:opacity-75" />
                                                                    <a :href="item.href" class="mt-4 block font-medium text-gray-900">
                                                                        <span class="absolute inset-0 z-10" aria-hidden="true" />
                                                                        {{ item.name }}
                                                                    </a>
                                                                    <p aria-hidden="true" class="mt-1">Shop now</p>
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
                            </div>

                            <!-- Mobile menu and search (lg-) -->
                            <div class="flex flex-1 items-center lg:hidden">
                                <button type="button" class="-ml-2 rounded-md bg-white p-2 text-gray-400" @click="open = true">
                                    <span class="sr-only">Open menu</span>
                                    <Bars3Icon class="size-6" aria-hidden="true" />
                                </button>

                                <!-- Search -->
                                <a href="#" class="ml-2 p-2 text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Search</span>
                                    <MagnifyingGlassIcon class="size-6" aria-hidden="true" />
                                </a>
                            </div>

                            <!-- Logo (lg-) -->
                            <a href="/" class="lg:hidden">
                                <span class="sr-only">Your Company</span>
                                <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="" class="h-8 w-auto" />
                            </a>

                            <div class="flex flex-1 items-center justify-end">
                                <a href="#" class="hidden text-sm font-medium text-gray-700 hover:text-gray-800 lg:block">Search</a>

                                <div class="flex items-center lg:ml-8">
                                    <!-- Help -->
                                    <a href="#" class="p-2 text-gray-400 hover:text-gray-500 lg:hidden">
                                        <span class="sr-only">Help</span>
                                        <QuestionMarkCircleIcon class="size-6" aria-hidden="true" />
                                    </a>
                                    <a href="#" class="hidden text-sm font-medium text-gray-700 hover:text-gray-800 lg:block">Help</a>

                                    <!-- Cart -->
                                    <div class="ml-4 flow-root lg:ml-8">
                                        <a href="cart" class="group -m-2 flex items-center p-2">
                                            <ShoppingBagIcon class="size-6 shrink-0 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                            <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">0</span>
                                            <span class="sr-only">items in cart, view bag</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            <!-- Hero section -->
            <div class="relative">
                <!-- Background image and overlap -->
                <div aria-hidden="true" class="absolute inset-0 hidden sm:flex sm:flex-col">
                    <div class="relative w-full flex-1 bg-gray-800">
                        <div class="absolute inset-0 overflow-hidden">
                            <img src="https://tailwindcss.com/plus-assets/img/ecommerce-images/home-page-04-hero-full-width.jpg" alt="" class="size-full object-cover" />
                        </div>
                        <div class="absolute inset-0 bg-gray-900 opacity-50" />
                    </div>
                    <div class="h-32 w-full bg-white md:h-40 lg:h-48" />
                </div>

                <div class="relative mx-auto max-w-3xl px-4 pb-96 text-center sm:px-6 sm:pb-0 lg:px-8">
                    <!-- Background image and overlap -->
                    <div aria-hidden="true" class="absolute inset-0 flex flex-col sm:hidden">
                        <div class="relative w-full flex-1 bg-gray-800">
                            <div class="absolute inset-0 overflow-hidden">
                                <img src="https://tailwindcss.com/plus-assets/img/ecommerce-images/home-page-04-hero-full-width.jpg" alt="" class="size-full object-cover" />
                            </div>
                            <div class="absolute inset-0 bg-gray-900 opacity-50" />
                        </div>
                        <div class="h-48 w-full bg-white" />
                    </div>
                    <div class="relative py-32">
                        <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl">Breizhsport test</h1>
                        <div class="mt-4 sm:mt-6">
                            <a href="category" class="inline-block rounded-md border border-transparent bg-indigo-600 px-8 py-3 font-medium text-white hover:bg-indigo-700">Shop Collection</a>
                        </div>
                    </div>
                </div>

                <section aria-labelledby="collection-heading" class="relative -mt-96 sm:mt-0">
                    <h2 id="collection-heading" class="sr-only">Collections</h2>
                    <div class="mx-auto grid max-w-md grid-cols-1 gap-y-6 px-4 sm:max-w-7xl sm:grid-cols-3 sm:gap-x-6 sm:gap-y-0 sm:px-6 lg:gap-x-8 lg:px-8">
                        <div v-for="collection in collections" :key="collection.name" class="group relative h-96 rounded-lg bg-white shadow-xl sm:aspect-4/5 sm:h-auto">
                            <div aria-hidden="true" class="absolute inset-0 overflow-hidden rounded-lg">
                                <div class="absolute inset-0 overflow-hidden group-hover:opacity-75">
                                    <img :src="collection.imageSrc" :alt="collection.imageAlt" class="size-full object-cover" />
                                </div>
                                <div class="absolute inset-0 bg-linear-to-b from-transparent to-black opacity-50" />
                            </div>
                            <div class="absolute inset-0 flex items-end rounded-lg p-6">
                                <div>
                                    <p aria-hidden="true" class="text-sm text-white">Shop the collection</p>
                                    <h3 class="mt-1 font-semibold text-white">
                                        <a :href="collection.href">
                                            <span class="absolute inset-0" />
                                            {{ collection.name }}
                                        </a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <section aria-labelledby="trending-heading">
                <div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 sm:py-32 lg:px-8 lg:pt-32">
                    <div class="md:flex md:items-center md:justify-between">
                        <h2 id="favorites-heading" class="text-2xl font-bold tracking-tight text-gray-900">Trending Products</h2>
                        <a href="#" class="hidden text-sm font-medium text-indigo-600 hover:text-indigo-500 md:block">
                            Shop the collection
                            <span aria-hidden="true"> &rarr;</span>
                        </a>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">
                        <div v-for="product in trendingProducts" :key="product.id" class="group relative">
                            <div class="h-56 w-full overflow-hidden rounded-md group-hover:opacity-75 lg:h-72 xl:h-80">
                                <img :src="product.imageSrc" :alt="product.imageAlt" class="size-full object-cover" />
                            </div>
                            <h3 class="mt-4 text-sm text-gray-700">
                                <a :href="product.href">
                                    <span class="absolute inset-0" />
                                    {{ product.name }}
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">{{ product.color }}</p>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ product.price }}</p>
                        </div>
                    </div>

                    <div class="mt-8 text-sm md:hidden">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Shop the collection
                            <span aria-hidden="true"> &rarr;</span>
                        </a>
                    </div>
                </div>
            </section>

            <section aria-labelledby="perks-heading" class="border-t border-gray-200 bg-gray-50">
                <h2 id="perks-heading" class="sr-only">Our perks</h2>

                <div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 sm:py-32 lg:px-8">
                    <div class="grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 lg:gap-x-8 lg:gap-y-0">
                        <div v-for="perk in perks" :key="perk.name" class="text-center md:flex md:items-start md:text-left lg:block lg:text-center">
                            <div class="md:shrink-0">
                                <div class="flow-root">
                                    <img class="mx-auto -my-1 h-24 w-auto" :src="perk.imageUrl" alt="" />
                                </div>
                            </div>
                            <div class="mt-6 md:mt-0 md:ml-4 lg:mt-6 lg:ml-0">
                                <h3 class="text-base font-medium text-gray-900">{{ perk.name }}</h3>
                                <p class="mt-3 text-sm text-gray-500">{{ perk.description }}</p>
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
import { ref } from 'vue'
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
import {
    Bars3Icon,
    MagnifyingGlassIcon,
    QuestionMarkCircleIcon,
    ShoppingBagIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'

const currencies = ['CAD', 'USD', 'AUD', 'EUR', 'GBP']
const navigation = {
    categories: [
        {
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
                {
                    name: 'Carry',
                    href: 'category',
                    imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/mega-menu-category-04.jpg',
                    imageAlt: 'Model opening tan leather long wallet with credit card pockets and cash pouch.',
                },
            ],
        },
        {
            name: 'Men',
            featured: [
                {
                    name: 'New Arrivals',
                    href: 'category',
                    imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/mega-menu-01-men-category-01.jpg',
                    imageAlt: 'Hats and sweaters on wood shelves next to various colors of t-shirts on hangers.',
                },
                {
                    name: 'Basic Tees',
                    href: 'category',
                    imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/mega-menu-01-men-category-02.jpg',
                    imageAlt: 'Model wearing light heather gray t-shirt.',
                },
                {
                    name: 'Accessories',
                    href: 'category',
                    imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/mega-menu-01-men-category-03.jpg',
                    imageAlt:
                        'Grey 6-panel baseball hat with black brim, black mountain graphic on front, and light heather gray body.',
                },
                {
                    name: 'Carry',
                    href: 'category',
                    imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/mega-menu-01-men-category-04.jpg',
                    imageAlt: 'Model putting folded cash into slim card holder olive leather wallet with hand stitching.',
                },
            ],
        },
    ],
    pages: [
        { name: 'Company', href: '#' },
        { name: 'Stores', href: '#' },
    ],
}
const collections = [
    {
        name: "Women's",
        href: 'category',
        imageSrc: 'https://larrogante.fr/wp-content/uploads/2019/05/roxy-fitness-tenue-sport-running.png?w=660',
        imageAlt: 'Woman wearing a comfortable cotton t-shirt.',
    },
    {
        name: "Men's",
        href: 'category',
        imageSrc: 'https://m.media-amazon.com/images/I/61H7exu6wsL._AC_UF1000,1000_QL80_.jpg',
        imageAlt: 'Man wearing a comfortable and casual cotton t-shirt.',
    },
    {
        name: 'Desk Accessories',
        href: 'category',
        imageSrc: 'https://pecheneglantine.fr/wp-content/uploads/2017/10/Accessoires-fitness-2.jpeg',
        imageAlt: 'Person sitting at a wooden desk with paper note organizer, pencil and tablet.',
    },
]
const trendingProducts = [
    {
        id: 1,
        name: 'Leather Long Wallet',
        color: 'Natural',
        price: '$75',
        href: 'product',
        imageSrc: 'https://tailwindcss.com/plus-assets/img/ecommerce-images/home-page-04-trending-product-02.jpg',
        imageAlt: 'Hand stitched, orange leather long wallet.',
    },
    // More products...
]
const perks = [
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
        { name: 'Bags', href: 'product' },
        { name: 'Tees', href: 'product' },
        { name: 'Objects', href: 'product' },
        { name: 'Home Goods', href: 'product' },
        { name: 'Accessories', href: 'product' },
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
