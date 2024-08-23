<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="sidebar fixed sm:relative sm:translate-x-0 -translate-x-full">
        <div class="logo">
            <img src="https://picsum.photos/200" alt="Logo" />
            <h1>F.C. Products</h1>
        </div>
        <nav>
            <ul>
                <li><Link :href="route('home')"><i class="icon-home"></i> Home</Link></li>
                <li><Link :href="route('website')"><i class="icon-globe"></i> Website</Link></li>
                <li><Link :href="route('chats')"><i class="icon-chat"></i> Chats</Link></li>
                <li><Link :href="route('inventory')"><i class="icon-inventory"></i> Inventory</Link></li>
                <li><Link :href="route('receipt')"><i class="icon-receipt"></i> Receipt</Link></li>
                <li><Link :href="route('finance')"><i class="icon-finance"></i> Finance</Link></li>
                <li><Link :href="route('settings')"><i class="icon-settings"></i> Additional Settings</Link></li>
            </ul>
        </nav>
    </div>
</template>

<style scoped>
.sidebar {
    background-color: #1a202c;
    color: #fff;
    width: 250px;
    height: 100vh;
    z-index: 50; /* Adjust z-index to ensure the sidebar overlays other content */
}
.logo {
    text-align: center;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center; /* Aligns items horizontally center */
}
.logo img {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    margin-bottom: 10px; /* Adjust as needed */
}
.logo h1 {
    font-size: 1.5em;
    margin: 0; /* Reset margin for h1 */
}
nav ul {
    list-style-type: none;
    padding: 0;
}
nav ul li {
    margin: 10px 0;
}
nav ul li a {
    color: #fff;
    text-decoration: none;
    display: flex;
    align-items: center;
    padding: 10px 20px;
}
nav ul li a i {
    margin-right: 10px;
}
</style>
