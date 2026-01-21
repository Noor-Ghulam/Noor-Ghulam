<template>
  <div class="grid gap-6 lg:grid-cols-[2fr_1fr]">
    <section class="space-y-6">
      <div class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
          <div>
            <h2 class="text-lg font-semibold text-slate-900">اختيار المنتجات</h2>
            <p class="text-sm text-slate-500">املأ القيم المطلوبة لكل منتج.</p>
          </div>
          <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs text-slate-600">
            العملة: {{ config?.currency || 'USD' }}
          </span>
        </div>
      </div>

      <div v-if="loading" class="rounded-2xl bg-white p-6 shadow-sm">
        <p class="text-sm text-slate-500">جاري تحميل الإعدادات...</p>
      </div>

      <div v-else class="space-y-6">
        <div
          v-for="(product, productKey) in config.products"
          :key="productKey"
          class="rounded-2xl bg-white p-6 shadow-sm"
        >
          <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-slate-900">
              {{ product.display }}
            </h3>
            <button
              type="button"
              class="text-xs text-slate-500 underline"
              @click="resetProduct(productKey, product.features)"
            >
              إعادة تعيين
            </button>
          </div>

          <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div
              v-for="feature in product.features"
              :key="feature.id"
              class="space-y-2"
            >
              <label class="text-sm font-medium text-slate-700">
                {{ feature.label }}
              </label>

              <input
                v-if="feature.type === 'number'"
                v-model.number="selection[productKey][feature.id]"
                type="number"
                min="0"
                class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100"
              />

              <label
                v-else
                class="flex cursor-pointer items-center gap-3 rounded-lg border border-slate-200 px-3 py-2 text-sm"
              >
                <input
                  v-model="selection[productKey][feature.id]"
                  type="checkbox"
                  class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                />
                <span>تفعيل</span>
              </label>

              <p class="text-xs text-slate-400">
                {{ formatPricingHint(feature) }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <aside class="space-y-6">
      <div class="rounded-2xl bg-white p-6 shadow-sm">
        <h3 class="text-base font-semibold text-slate-900">ملخص التسعير</h3>
        <dl class="mt-4 space-y-3 text-sm">
          <div class="flex items-center justify-between">
            <dt class="text-slate-500">التكلفة الأساسية</dt>
            <dd class="font-medium text-slate-900">{{ formatCurrency(baseCost) }}</dd>
          </div>
          <div class="flex items-center justify-between">
            <dt class="text-slate-500">التكاليف الإضافية</dt>
            <dd class="font-medium text-slate-900">{{ formatCurrency(overheads) }}</dd>
          </div>
          <div class="flex items-center justify-between border-t border-slate-100 pt-3">
            <dt class="text-slate-600">الإجمالي قبل الهامش</dt>
            <dd class="font-semibold text-slate-900">{{ formatCurrency(subtotal) }}</dd>
          </div>
        </dl>
      </div>

      <div class="rounded-2xl bg-white p-6 shadow-sm">
        <h3 class="text-base font-semibold text-slate-900">شرائح هامش الربح</h3>
        <div class="mt-4 space-y-4">
          <div
            v-for="tier in tierSummaries"
            :key="tier.key"
            class="rounded-xl border border-slate-100 bg-slate-50 p-4"
          >
            <div class="flex items-center justify-between text-sm">
              <span class="text-slate-500">{{ tier.label }}</span>
              <span class="font-semibold text-slate-900">{{ formatCurrency(tier.price) }}</span>
            </div>
            <p class="mt-1 text-xs text-slate-400">
              هامش {{ formatPercent(tier.margin) }}
            </p>
          </div>
        </div>
      </div>

      <div class="rounded-2xl bg-indigo-600 p-6 text-white">
        <h3 class="text-base font-semibold">ملاحظات سريعة</h3>
        <ul class="mt-3 space-y-2 text-sm text-indigo-100">
          <li>يتم احتساب الأسعار تلقائيًا بمجرد إدخال القيم.</li>
          <li>يمكنك تعديل الشرائح أو التكاليف لاحقًا من ملف الإعدادات.</li>
          <li>التطبيق متوافق مع اتجاه الكتابة من اليمين لليسار.</li>
        </ul>
      </div>
    </aside>
  </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import axios from 'axios';

const config = ref({
  currency: 'USD',
  overheads_pct: 0,
  margin_tiers: {},
  products: {},
});

const loading = ref(true);
const selection = reactive({});

const apiBase = import.meta.env.VITE_API_BASE || 'http://localhost:8000';

const initializeSelection = (products) => {
  Object.entries(products).forEach(([productKey, product]) => {
    selection[productKey] = selection[productKey] || {};
    product.features.forEach((feature) => {
      selection[productKey][feature.id] = feature.type === 'boolean' ? false : 0;
    });
  });
};

const resetProduct = (productKey, features) => {
  selection[productKey] = selection[productKey] || {};
  features.forEach((feature) => {
    selection[productKey][feature.id] = feature.type === 'boolean' ? false : 0;
  });
};

const fetchConfig = async () => {
  try {
    const response = await axios.get(`${apiBase}/api/pricing-config`);
    config.value = response.data;
    initializeSelection(response.data.products || {});
  } catch (error) {
    console.error('Failed to load pricing configuration', error);
  } finally {
    loading.value = false;
  }
};

const featureCost = (feature, value) => {
  if (feature.pricing === 'flat') {
    return value ? feature.unit_price : 0;
  }

  const numericValue = Number.isFinite(value) ? value : Number(value);
  return (Number.isFinite(numericValue) ? numericValue : 0) * feature.unit_price;
};

const baseCost = computed(() => {
  let total = 0;
  Object.entries(config.value.products || {}).forEach(([productKey, product]) => {
    product.features.forEach((feature) => {
      total += featureCost(feature, selection[productKey]?.[feature.id]);
    });
  });
  return total;
});

const overheads = computed(() => baseCost.value * (config.value.overheads_pct || 0));
const subtotal = computed(() => baseCost.value + overheads.value);

const tierSummaries = computed(() => {
  const tiers = config.value.margin_tiers || {};
  return Object.entries(tiers).map(([key, margin]) => ({
    key,
    margin,
    label: tierLabel(key),
    price: subtotal.value * (1 + margin),
  }));
});

const tierLabel = (key) => {
  const labels = {
    low: 'هامش منخفض',
    medium: 'هامش متوسط',
    high: 'هامش مرتفع',
  };
  return labels[key] || key;
};

const formatCurrency = (value) => {
  const formatter = new Intl.NumberFormat('ar', {
    style: 'currency',
    currency: config.value.currency || 'USD',
  });
  return formatter.format(value || 0);
};

const formatPercent = (value) => {
  const formatter = new Intl.NumberFormat('ar', {
    style: 'percent',
    maximumFractionDigits: 0,
  });
  return formatter.format(value || 0);
};

const formatPricingHint = (feature) => {
  const suffix = feature.pricing === 'flat' ? 'سعر ثابت' : 'لكل وحدة';
  return `${feature.unit_price} ${config.value.currency || 'USD'} - ${suffix}`;
};

onMounted(fetchConfig);
</script>
