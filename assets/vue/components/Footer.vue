<script setup>
const currentYear = new Date().toLocaleDateString('FR-fr', { year: 'numeric' });
</script>

<template>
    <footer class="footer footer-center p-10 text-gray-400">
        <div>
            <p class="font-bold">
                Le Bus Magique
            </p>
            <p>Copyright © {{currentYear}} - Tous droits réservés</p>
        </div>
    </footer>
</template>