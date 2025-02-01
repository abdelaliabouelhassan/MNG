<script setup>
import { Head, Link } from "@inertiajs/vue3";
import axios from "axios";
import { ref } from "vue";

defineProps({
  title: {
    type: String,
    required: true,
  },
});

const loading = ref(false);

const data = ref({
  icon: "",
  strain_name: "GRAPE BUBBA",
  name_one: "GRAPE",
  name_two: "BUBBA",
  total_cannabinoids: "0%",
  sum_of_cannabinoids: "",
  total_thc: "0%",
  total_cbd: "0%",
  pkg_date: "01-31-2025",
  batch: "00-00-A0-000",
  uid: "1A0000000000000000000",
  license: "C11-0001463-LIC",
  distro_name: "DYER MANAGEMENT CENTER",
  strain_type: "indica",
  barcode_data: "0000000000",
  title_font_size: "18",
});

const generateHorizontalPdf = async () => {
  if (loading.value) return;
  loading.value = true;
  axios
    .post("/generate-horizontal-pdf", data.value, {
      responseType: "blob", // Important for downloading files
    })
    .then((res) => {
      const url = window.URL.createObjectURL(new Blob([res.data]));
      const link = document.createElement("a");
      link.href = url;
      link.setAttribute("download", "invoice-2023-04-10.pdf");
      document.body.appendChild(link);
      link.click();
      link.remove();
    })
    .catch((err) => {
      console.error("Error downloading the PDF", err);
    })
    .finally(() => {
      loading.value = false;
    });
};

const generateVerticalPdf = async () => {
  if (loading.value) return;
  loading.value = true;
  axios
    .post("/generate-vertical-pdf", data.value, {
      responseType: "blob", // Important for downloading files
    })
    .then((res) => {
      const url = window.URL.createObjectURL(new Blob([res.data]));
      const link = document.createElement("a");
      link.href = url;
      link.setAttribute("download", "invoice-2023-04-10.pdf");
      document.body.appendChild(link);
      link.click();
      link.remove();
    })
    .catch((err) => {
      console.error("Error downloading the PDF", err);
    })
    .finally(() => {
      loading.value = false;
    });
};
</script>

<template>
  <Head :title="title" />
  <div class="text-white p-6">
    <div class="max-w-5xl mx-auto">
      <h1 class="text-2xl font-bold mb-4">MNG LABEL MAKER v3</h1>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <div class="mb-4">
            <label for="image-icon" class="block mb-1">Image Icon</label>
            <select
              id="image-icon"
              class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
              v-model="data.icon"
            >
              <option value="HOUSE PARTY">HOUSE PARTY</option>
            </select>
          </div>
          <div class="mb-4">
            <label for="strain_name" class="block mb-1">Strain Name</label>
            <input
              type="text"
              id="strain_name"
              class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
              v-model="data.strain_name"
              value="GRAPH"
            />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
              <label for="name-line-1" class="block mb-1">Name Line 1</label>
              <input
                type="text"
                id="name-line-1"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.name_one"
                value="GRAPH"
              />
            </div>
            <div class="mb-4">
              <label for="name-line-2" class="block mb-1">Name Line 2</label>
              <input
                type="text"
                id="name-line-2"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.name_two"
                value="BUBBA"
              />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
              <label for="total-cannabinoids" class="block mb-1"
                >Total Cannabinoids</label
              >
              <input
                type="text"
                id="total-cannabinoids"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.total_cannabinoids"
                value="0 %"
              />
            </div>
            <div class="mb-4">
              <label for="sum-of-cannabinoids" class="block mb-1"
                >Sum of Cannabinoids</label
              >
              <input
                type="text"
                id="sum-of-cannabinoids"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.sum_of_cannabinoids"
              />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
              <label for="total-thc" class="block mb-1">Total THC</label>
              <input
                type="text"
                id="total-thc"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.total_thc"
                value="0 %"
              />
            </div>
            <div class="mb-4">
              <label for="total-cbd" class="block mb-1">Total CBD</label>
              <input
                type="text"
                id="total-cbd"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.total_cbd"
                value="0 %"
              />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
              <label for="pkg-date" class="block mb-1">Pkg Date</label>
              <input
                type="text"
                id="pkg-date"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.pkg_date"
                value="01-31-2025"
              />
            </div>
            <div class="mb-4">
              <label for="batch" class="block mb-1">Batch</label>
              <input
                type="text"
                id="batch"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.batch"
                value="00-00-A0-000"
              />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
              <label for="uid" class="block mb-1">UID</label>
              <input
                type="text"
                id="uid"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.uid"
                value="1A0000000000000000000"
              />
            </div>
            <div class="mb-4">
              <label for="license" class="block mb-1">License</label>
              <input
                type="text"
                id="license"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.license"
                value="C11-0001463-LIC"
              />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
              <label for="distro-name" class="block mb-1">Distro Name</label>
              <input
                type="text"
                id="distro-name"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.distro_name"
                value="DYER MANAGEMENT CENTER"
              />
            </div>
            <div class="mb-4">
              <label for="strain-type" class="block mb-1">Strain Type</label>
              <select
                id="strain-type"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.strain_type"
              >
                <option value="indica">indica</option>
                <option value="sativa">sativa</option>
                <option value="hybrid">hybrid</option>
              </select>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
              <label for="barcode-data" class="block mb-1">Barcode Data</label>
              <input
                type="text"
                id="barcode-data"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.barcode_data"
                value="0000000000"
              />
            </div>
            <div class="mb-4">
              <label for="title-font-size" class="block mb-1"
                >Title Font Size</label
              >
              <input
                type="text"
                id="title-font-size"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.title_font_size"
                value="18"
              />
            </div>
          </div>
        </div>
        <div class="flex flex-col items-end">
          <div class="grid md:grid-cols-2 gap-2">
            <button
              @click="generateVerticalPdf"
              class="bg-blue-500 hover:bg-blue-600 uppercase text-white px-4 py-2 rounded mb-4"
            >
              MAKE VERTICAL LABEL
            </button>
            <button
              @click="generateHorizontalPdf"
              class="bg-blue-500 hover:bg-blue-600 uppercase text-white px-4 py-2 rounded mb-4"
            >
              MAKE Horizontal LABEL
            </button>
          </div>
          <div class="bg-gray-700 border-gray-600 p-4 rounded w-full">
            <p class="mb-2">From Link we found the below info:</p>
            <input
              type="url"
              class="bg-gray-800 border-gray-600 text-white px-4 py-2 rounded w-full mb-4"
              placeholder="enter link to COA if available"
            />
            <div class="grid md:grid-cols-2 gap-2">
              <button
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"
              >
                GET COA INFO (1 MIN)
              </button>
              <button
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"
              >
                COPY INFO FROM LINK
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div
    class="w-full h-full fixed top-0 left-0 flex bg-black/50 duration-500"
    v-if="loading"
  >
    <div class="relative flex flex-col items-center m-auto">
      <!-- Pulsing circles -->
      <div
        class="absolute w-32 h-32 bg-blue-500 rounded-full opacity-70 loader-ring"
      ></div>
      <div
        class="relative w-16 h-16 bg-gradient-to-tr from-blue-500 to-blue-500 rounded-full loader-dot shadow-lg"
      ></div>

      <!-- Loading text -->
      <div class="mt-8 text-blue-300 text-xl font-medium tracking-wider">
        LOADING
        <span class="animate-pulse">.</span>
        <span class="animate-pulse delay-100">.</span>
        <span class="animate-pulse delay-200">.</span>
      </div>
    </div>
  </div>
</template>



<style>
body {
  @apply bg-gray-900;
}

@keyframes pulse-ring {
  0% {
    transform: scale(0.33);
  }
  80%,
  100% {
    opacity: 0;
  }
}
@keyframes pulse-dot {
  0%,
  100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
}
.loader-ring {
  animation: pulse-ring 1.25s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
}
.loader-dot {
  animation: pulse-dot 1.25s cubic-bezier(0.455, 0.03, 0.515, 0.955) -0.4s infinite;
}
</style>