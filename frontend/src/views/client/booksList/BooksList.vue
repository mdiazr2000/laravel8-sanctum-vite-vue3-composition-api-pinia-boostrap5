<template>
  <div
    style="
      width: 100%;
      display: flex;
      flex-direction: row;
      justify-content: space-around;
      margin-top: 30px;
    "
  >
    <div style="display: flex; flex-direction: column; width: 50%">
      <InfoContainer v-if="data.messageInfo" :message="data.messageInfo" />
      <FailedContainer v-if="data.errorInfo" :message="data.errorInfo" />
      <h1>Books available to reserve</h1>
      <table class="table">
        <thead>
          <tr>
            <th scope="row">#</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Reserve</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(book, index) in data.availableBooks" :key="book.id">
            <th scope="row">{{ ++index }}</th>
            <td>{{ book.title }}</td>
            <td>{{ book.description }}</td>
            <td align="center">
              <i
                class="bi bi-file-bar-graph"
                style="cursor: pointer"
                @click="setSelectedBook(book.id)"
              ></i>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Modal -->
  <div
    id="exampleModal2"
    ref="modalReserve"
    class="modal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">Reserve book</h5>
          <button
            type="button"
            class="btn-close"
            aria-label="Close"
            @click="hideModal"
          ></button>
        </div>
        <div class="modal-body">
          Are you sure that you want to reserve this Book?
        </div>
        <div class="modal-footer">
          <button
            ref="closeModal"
            type="button"
            class="btn btn-secondary"
            @click="hideModal"
          >
            Close
          </button>
          <button type="button" class="btn btn-primary" @click="reserveBook">
            Save changes
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {
  getAvailableBooksEndpoint,
  getReserveBookEndpoint,
} from "../../../core/endpoints";
import { GetRequest, PostRequest } from "../../../core/api-request";
import { reactive, onMounted, ref } from "vue";
import { useAuthStore } from "../../../stores.js";
import InfoContainer from "../../../components/InfoContainer.vue";
import FailedContainer from "../../../components/FailedContainer.vue";
import { Modal } from "bootstrap";

const modalReserve = ref(null);
const closeModal = ref(null);

const store = useAuthStore();

const data = reactive({
  availableBooks: "",
  messageInfo: null,
  errorInfo: null,
  clientId: store.profile.id,
  bookIdSelected: null,
  modalConfirmation: null,
});

const showModal = () => {
  data.modalConfirmation = new Modal(
    document.getElementById("exampleModal2"),
    {}
  );
  data.modalConfirmation.show();
};

const hideModal = () => {
  data.modalConfirmation.hide();
};

const loadAvailableBooks = async () => {
  const url = getAvailableBooksEndpoint;
  data.validationErrors = null;
  const result = await GetRequest(url, store.token);
  if (result.status !== 200) {
    data.availableBooks = [];
  } else {
    data.availableBooks = result.data.data;
  }
};

const reserveBook = async () => {
  const url = getReserveBookEndpoint;
  data.validationErrors = null;
  const result = await PostRequest(
    url,
    {
      clientId: data.clientId,
      bookId: data.bookIdSelected,
    },
    store.token
  );
  hideModal();
  if (result.status !== 200) {
    data.errorInfo = result.data.error.message;
  } else {
    data.messageInfo = result.data.message;
    // call available books
    await loadAvailableBooks();
  }
};

const setSelectedBook = (id) => {
  data.bookIdSelected = id;
  showModal();
};

onMounted(async () => {
  await loadAvailableBooks();
});
</script>

<style scoped></style>
