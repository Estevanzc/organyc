<template>
    <header class="px-16 py-4 flex items-center justify-between shadow-lg">
        <div class="appheader-logo flex items-center justify-center">
            <a href="/" aria-label="Home" class="flex items-center justify-center gap-2 text-3xl text-lime-500">
                <font-awesome-icon class="block text-center cursor-pointer"
                            :icon="['fas', 'leaf']"></font-awesome-icon>
                <span class="logo-text font-bold">Organyc</span>
            </a>
        </div>

        <nav class="primary-nav w-7/10 h-full flex items-center">
            <ul class="nav-links flex flex-1 items-center justify-evenly text-lg">
                <li><a href="/">Home</a></li>
                <li><a href="/creatures/animals/catalogue">Animals</a></li>
                <li><a href="/creatures/plants/catalogue">Plants</a></li>
            </ul>
        </nav>

        <div class="appheader-actions text-lg">
            <a href="#" aria-label="login" class="text-lime-500">
                My Profile
                <font-awesome-icon class="block text-center cursor-pointer"
                            :icon="['fas', 'chevron-down']"></font-awesome-icon>
            </a>
        </div>
    </header>
</template>