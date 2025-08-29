<script>
import '@/assets/css/style.css';
</script>

<template>
    <div>
        <nav>
            <router-link :to="{ name: 'home' }">Home</router-link> |
            <router-link :to="{ name: 'movies' }">Movies</router-link>
        </nav>
    </div>
</template>

<style>
nav {
    margin-bottom: 20px;
}
nav a {
    text-decoration: none;
    margin: 0 10px;
    color: blue;
}
nav a:hover {
    text-decoration: underline;
}
</style>
