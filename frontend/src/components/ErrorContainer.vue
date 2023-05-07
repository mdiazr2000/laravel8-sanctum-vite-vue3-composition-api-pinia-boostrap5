<template>
  <div
    v-if="props?.errors?.message"
    class="alert alert-danger"
    role="alert"
    style="height: auto"
  >
    <div v-if="errorList.length || props.errors.message">
      <div v-if="props.errors.message" style="color: red">
        {{ props.errors.message }}
      </div>
      <div v-for="(error, index) in errorList" :key="index">
        {{ error }}
      </div>
    </div>
  </div>
</template>

<script setup>
import {computed} from "vue";

const props = defineProps({
  errors: {
    default: null,
    type: Object,
  },
});

const errorList = computed(() => {
  let tempList = [];
  if (props.errors.details !== undefined) {
    let propertyList = Object.getOwnPropertyNames(props.errors.details);
    if (propertyList && propertyList.length) {
          propertyList &&
          propertyList.forEach((item) => {
            const itemAdd = item + " : " + props.errors.details[item].join(",");
            tempList.push(itemAdd)
          });
    }
  }
  return tempList;
});
</script>

<style scoped></style>
