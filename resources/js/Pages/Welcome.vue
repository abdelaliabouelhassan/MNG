<script setup>
import { Head, Link } from "@inertiajs/vue3";
import axios from "axios";
import { computed, onMounted, ref, watch } from "vue";

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  logos: {
    type: Array,
    required: true,
  },
});

onMounted(() => {
  if (props.logos && props.logos.length > 0) {
    data.value.logo = props.logos[0].id;
  }
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
  barcode_data: "",
  title_font_size: "18",
});

const url = ref(null);
const generatedData = ref({});
const showDetails = ref(false);
const errors = ref(false);
const generateHorizontalPdf = async () => {
  if (loading.value) return;
  loading.value = true;
  errors.value = false;
  axios
    .post("/generate-horizontal-pdf", data.value, {
      responseType: "blob", // Important for downloading files
    })
    .then((res) => {
      const url = window.URL.createObjectURL(new Blob([res.data]));
      const link = document.createElement("a");
      link.href = url;
      link.setAttribute("download", getName() + ".pdf");
      document.body.appendChild(link);
      link.click();
      link.remove();
    })
    .catch((err) => {
      console.error("Error downloading the PDF", err);
      alert("Error downloading the PDF");
      if (err.response.status === 422) {
        errors.value = true;
      }
    })
    .finally(() => {
      loading.value = false;
    });
};

const generateVerticalPdf = async () => {
  if (loading.value) return;
  loading.value = true;
  errors.value = false;
  axios
    .post("/generate-vertical-pdf", data.value, {
      responseType: "blob", // Important for downloading files
    })
    .then((res) => {
      const url = window.URL.createObjectURL(new Blob([res.data]));
      const link = document.createElement("a");
      link.href = url;
      link.setAttribute("download", getName() + ".pdf");
      document.body.appendChild(link);
      link.click();
      link.remove();
    })
    .catch((err) => {
      console.error("Error downloading the PDF", err);
      alert("Error downloading the PDF");
      if (err.response.status === 422) {
        errors.value = true;
      }
    })
    .finally(() => {
      loading.value = false;
    });
};

const getName = () => {
  if (data.value.strain_name) {
    return data.value.strain_name;
  } else if (data.value.name_one) {
    return data.value.name_one;
  } else if (data.value.name_two) {
    return data.value.name_two;
  } else {
    return "LABEL";
  }
};

const selectedLogo = computed(() => {
  return props.logos.find((item) => item.id === data.value.logo);
});

// Watch for changes in selectedLogo and update barcode_data
watch(selectedLogo, (newValue) => {
  if (newValue) {
    data.value.barcode_data = newValue.barcode;
  }
});

const getData = async () => {
  if (loading.value) return;
  if (!url.value) return;
  loading.value = true;
  axios
    .post("/getData", { url: url.value })
    .then((res) => {
      console.log(res.data);
      generatedData.value = res?.data[0];
      showDetails.value = true;
    })
    .catch((err) => {
      console.error("Error Scraping Data", err);
      alert("Error Scraping Data, Try Again");
    })
    .finally(() => {
      loading.value = false;
    });
};

const CopyInfo = () => {
  // Helper function to check if value is empty/null/undefined
  const isValidValue = (value) => {
    return value !== null && value !== undefined && value !== "";
  };

  // Helper function to clean percentage strings
  const cleanPercentage = (value) => {
    if (!isValidValue(value)) return "0%";
    // Remove any existing % symbol and trim spaces
    const cleanedValue = value.toString().replace(/%/g, "").trim();
    // Add % symbol directly after the number
    return `${cleanedValue}%`;
  };

  // Copy only if values exist and are valid
  if (isValidValue(generatedData.value.batch)) {
    data.value.batch = generatedData.value.batch;
  }

  if (isValidValue(generatedData.value.UID)) {
    data.value.uid = generatedData.value.UID;
  }

  if (isValidValue(generatedData.value.license)) {
    data.value.license = generatedData.value.license;
  }

  if (isValidValue(generatedData.value.distro)) {
    data.value.distro_name = generatedData.value.distro.toUpperCase();
  }

  // Handle percentages with cleaning
  data.value.total_cannabinoids = cleanPercentage(
    generatedData.value.totalCannabinoids
  );
  data.value.sum_of_cannabinoids = cleanPercentage(
    generatedData.value.sumOfCannabinoids
  );
  data.value.total_thc = cleanPercentage(generatedData.value.totalTHC);
  data.value.total_cbd = cleanPercentage(generatedData.value.totalCBD);

  // Handle strain name and its parts
  if (isValidValue(generatedData.value.name)) {
    // Set the full strain name
    data.value.strain_name = generatedData.value.name.toUpperCase();

    // Split the name and handle name_one and name_two
    const nameParts = generatedData.value.name.split(" ");
    if (nameParts.length >= 2) {
      data.value.name_one = nameParts[0].toUpperCase();
      data.value.name_two = nameParts[1].toUpperCase();
    } else {
      // If only one word, set it to name_one and clear name_two
      data.value.name_one = nameParts[0].toUpperCase();
      data.value.name_two = "";
    }
  }

  // Optional: Log the updated data
  console.log("Data updated:", data.value);
};
</script>

<template>
  <Head :title="title" />
  <div class="text-white p-6">
    <div class="max-w-5xl mx-auto">
      {{ errors }}
      <h1 class="text-2xl font-bold mb-4">MNG LABEL MAKER v3</h1>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <div class="mb-4">
            <label for="image-icon" class="block mb-1">Image Icon</label>
            <select
              id="image-icon"
              class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
              v-model="data.logo"
            >
              <option
                :value="logo.id"
                v-for="(logo, index, key) in logos"
                :key="key"
              >
                {{ logo.name }}
              </option>
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
              <label for="name-line-1" class="block mb-1"
                >Strain Name Line 1</label
              >
              <input
                type="text"
                id="name-line-1"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.name_one"
                value="GRAPH"
              />
            </div>
            <div class="mb-4">
              <label for="name-line-2" class="block mb-1"
                >Strain Name Line 2</label
              >
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
          <div class="grid grid-cols-1 gap-4">
            <div class="mb-4">
              <span v-if="errors" class="text-red-400"
                >barcode is not a valid UPC-A barcode.</span
              >
              <label for="barcode-data" class="block mb-1">Barcode Data</label>
              <input
                type="text"
                id="barcode-data"
                class="bg-gray-700 border-gray-600 text-white px-4 py-2 rounded w-full"
                v-model="data.barcode_data"
                placeholder="123456789012"
              />
            </div>
            <div class="mb-4 hidden">
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
        </div>
        <div class="flex flex-col items-end">
          <div class="bg-gray-700 border-gray-600 p-4 rounded w-full">
            <p class="mb-2">From Link we found the below info:</p>
            <input
              type="url"
              v-model="url"
              class="bg-gray-800 border-gray-600 text-white px-4 py-2 rounded w-full mb-4"
              placeholder="enter link to COA if available"
            />
            <div class="w-full">
              <button
                @click="getData"
                class="bg-green-500 w-full hover:bg-green-600 text-white px-4 py-2 rounded"
              >
                GET COA INFO (1 MIN)
              </button>
            </div>
          </div>

          <div class="w-full" v-if="showDetails">
            <!-- Header -->
            <div class="mb-8 pt-8">
              <p class="text-gray-600">Detailed analysis report</p>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
              <!-- Basic Info Section -->
              <div class="p-6 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <div class="space-y-3">
                      <div>
                        <label class="text-sm font-medium text-gray-500"
                          >Batch Number</label
                        >
                        <p class="text-gray-900 font-medium" id="batch">
                          {{ generatedData.batch ?? "N/A" }}
                        </p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500"
                          >Metrc UID</label
                        >
                        <p class="text-gray-900 font-mono" id="uid">
                          {{ generatedData.UID ?? "N/A" }}
                        </p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500"
                          >Strain Name</label
                        >
                        <p class="text-gray-900" id="name">
                          {{ generatedData.name ?? "N/A" }}
                        </p>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="space-y-3">
                      <div>
                        <label class="text-sm font-medium text-gray-500"
                          >Distribution Center</label
                        >
                        <p class="text-gray-900 capitalize" id="distro">
                          {{ generatedData.distro ?? "N/A" }}
                        </p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500"
                          >License Number</label
                        >
                        <p class="text-gray-900 font-mono" id="license">
                          {{ generatedData.license ?? "N/A" }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Analysis Results -->
              <div class="p-6 bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">
                  Cannabinoid Analysis
                </h2>
                <div class="grid grid-cols-2 gap-4">
                  <!-- Total THC -->
                  <div class="bg-white p-4 rounded-lg shadow-sm">
                    <label class="text-sm font-medium text-gray-500"
                      >Total THC</label
                    >
                    <p class="text-2xl font-bold text-green-600" id="totalTHC">
                      {{ generatedData.totalTHC ?? "N/A" }}
                    </p>
                  </div>
                  <!-- Total CBD -->
                  <div class="bg-white p-4 rounded-lg shadow-sm">
                    <label class="text-sm font-medium text-gray-500"
                      >Total CBD</label
                    >
                    <p class="text-2xl font-bold text-blue-600" id="totalCBD">
                      {{ generatedData.totalCBD ?? "N/A" }}
                    </p>
                  </div>
                  <!-- Total Cannabinoids -->
                  <div class="bg-white p-4 rounded-lg shadow-sm">
                    <label class="text-sm font-medium text-gray-500"
                      >Total Cannabinoids</label
                    >
                    <p
                      class="text-2xl font-bold text-purple-600"
                      id="totalCannabinoids"
                    >
                      {{ generatedData.totalCannabinoids ?? "N/A" }}
                    </p>
                  </div>
                  <!-- Sum of Cannabinoids -->
                  <div class="bg-white p-4 rounded-lg shadow-sm">
                    <label class="text-sm font-medium text-gray-500"
                      >Sum of Cannabinoids</label
                    >
                    <p
                      class="text-2xl font-bold text-indigo-600"
                      id="sumCannabinoids"
                    >
                      {{ generatedData.sumOfCannabinoids ?? "N/A" }}
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div class="w-full pt-4">
              <button
                @click="CopyInfo"
                class="bg-green-500 hover:bg-green-600 w-full text-white px-4 py-2 rounded"
              >
                COPY INFO FROM LINK
              </button>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center text-sm text-gray-500">
              <p>Results generated from URL</p>
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