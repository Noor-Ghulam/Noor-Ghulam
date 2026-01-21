<template>
  <div class="min-h-screen">
    <header class="bg-white shadow-sm">
      <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-slate-900">
          حاسبة الأسعار متعددة المنتجات
        </h1>
        <p class="mt-2 text-sm text-slate-500">
          احسب التكلفة الأساسية، التكاليف الإضافية، وأسعار هوامش الربح فورًا.
        </p>
      </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
      <PricingCalculator />
    </main>
  </div>
</template>

<script setup>
import PricingCalculator from './components/PricingCalculator.vue';
</script>
