<template>
  <div :style="wrapper">
    <h2 :style="title">
      {{ isEdit ? 'Edit Supplier' : 'Add New Supplier' }}
    </h2>

    <form @submit.prevent="handleSubmit">

      <!-- Name -->
      <div :style="fieldGroup">
        <label :style="labelStyle">Name</label>
        <input v-model="form.name" type="text" required :style="inputStyle" />
      </div>

      <!-- Email -->
      <div :style="fieldGroup">
        <label :style="labelStyle">Email</label>
        <input v-model="form.email" type="email" required :style="inputStyle" />
      </div>

      <!-- Phone -->
      <div :style="fieldGroup">
        <label :style="labelStyle">Phone</label>
        <input v-model="form.phone" type="text" required :style="inputStyle" />
      </div>

      <!-- Company -->
      <div :style="fieldGroup">
        <label :style="labelStyle">Company</label>
        <input v-model="form.company" type="text" :style="inputStyle" />
      </div>

      <!-- Location -->
      <div :style="fieldGroup">
        <label :style="labelStyle">Location</label>
        <input v-model="form.location" type="text" :style="inputStyle" />
      </div>

      <!-- Buttons -->
      <div :style="buttonsWrapper">
        <button type="submit" :style="submitBtn">
          {{ isEdit ? 'Update Supplier' : 'Create Supplier' }}
        </button>

        <button type="button" @click="cancel" :style="cancelBtn">
          Cancel
        </button>
      </div>

    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();

/* ---------------- STYLE OBJECTS ---------------- */

const wrapper = {
  maxWidth: "500px",
  margin: "30px auto",
  padding: "25px",
  background: "#ffffff",
  borderRadius: "10px",
  border: "1px solid #e3e3e3",
  boxShadow: "0px 3px 12px rgba(0,0,0,0.08)",
};

const title = {
  textAlign: "center",
  marginBottom: "20px",
  fontSize: "22px",
  fontWeight: "700",
  color: "#333",
};

const fieldGroup = {
  marginBottom: "16px",
  display: "flex",
  flexDirection: "column",
};

const labelStyle = {
  marginBottom: "6px",
  fontWeight: "600",
  color: "#444",
};

const inputStyle = {
  padding: "12px",
  borderRadius: "6px",
  border: "1px solid #ccc",
  fontSize: "14px",
};

const buttonsWrapper = {
  display: "flex",
  justifyContent: "space-between",
  marginTop: "25px",
};

const submitBtn = {
  padding: "12px 20px",
  fontSize: "14px",
  borderRadius: "6px",
  cursor: "pointer",
  width: "48%",
  background: "#4caf50",
  color: "white",
  border: "none",
};

const cancelBtn = {
  padding: "12px 20px",
  fontSize: "14px",
  borderRadius: "6px",
  cursor: "pointer",
  width: "48%",
  background: "#ccc",
  color: "#333",
  border: "none",
};

/* ---------------- LOGIC ---------------- */

const form = ref({
  name: "",
  email: "",
  phone: "",
  company: "",
  location: "",
});

const isEdit = ref(false);

onMounted(async () => {
  if (route.params.id) {
    isEdit.value = true;
    const res = await axios.get(`/api/suppliers/${route.params.id}`);
    form.value = res.data;
  }
});

const handleSubmit = async () => {
  try {
    if (isEdit.value) {
      await axios.put(`/api/suppliers/${route.params.id}`, form.value);
    } else {
      await axios.post("/api/suppliers", form.value);
    }
    router.push("/supplier-list");
  } catch (e) {
    console.error(e);
  }
};

const cancel = () => router.push("/supplier-list");
</script>
