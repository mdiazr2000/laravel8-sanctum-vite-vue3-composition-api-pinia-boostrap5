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
      <h1>Books reserved</h1>
      <table class="table">
        <thead>
          <tr>
            <th scope="row">#</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">InitialDate</th>
            <th scope="col">FinalDate</th>
            <th scope="col">Status</th>
            <th scope="col">UnReserved</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(book, index) in data.reservedBooks" :key="book.id">
            <th scope="row">{{ ++index }}</th>
            <td>{{ book.title }}</td>
            <td>{{ book.description }}</td>
            <td>{{ book.initialDate }}</td>
            <td>{{ book.finalDate }}</td>
            <td width="100px">
              {{ book.status_time }}
              <i v-if="book.status_time == 'ontime'" class="bi bi-alarm"></i>
              <i
                v-if="book.status_time == 'overdue'"
                class="bi bi-alarm-fill"
              ></i>
            </td>
            <td align="center">
              <i
                class="bi bi-archive"
                style="cursor: pointer"
                @click="setSelectedReservation(book.id_reservation)"
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
          <h5 id="exampleModalLabel" class="modal-title">Return book</h5>
          <button
            type="button"
            class="btn-close"
            aria-label="Close"
            @click="hideModal"
          ></button>
        </div>
        <div class="modal-body">
          Are you sure that you want to return this Book?
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
          <button type="button" class="btn btn-primary" @click="unReserveBook">
            Save changes
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {
  getReservedBooksEndpoint,
  getUnReservedBooksEndpoint,
} from "../../../core/endpoints";
import { GetRequest } from "../../../core/api-request";
import { reactive, onMounted, ref } from "vue";
import { useAuthStore } from "../../../stores.js";
import InfoContainer from "../../../components/InfoContainer.vue";
import FailedContainer from "../../../components/FailedContainer.vue";
import { Modal } from "bootstrap";

const modalReserve = ref(null);
const closeModal = ref(null);

const store = useAuthStore();

const data = reactive({
  reservedBooks: "",
  messageInfo: null,
  errorInfo: null,
  clientId: store.profile.id,
  reservationId: null,
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

const loadReservedBooks = async () => {
  const url = getReservedBooksEndpoint + "/" + data.clientId;
  data.validationErrors = null;
  const result = await GetRequest(url, store.token);
  if (result.status !== 200) {
    data.reservedBooks = [];
  } else {
    data.reservedBooks = result.data.data;
  }
};

const unReserveBook = async () => {
  const url = getUnReservedBooksEndpoint(data.reservationId);
  data.validationErrors = null;
  const result = await GetRequest(url, store.token);
  hideModal();
  if (result.status !== 200) {
    data.errorInfo = result.data.error.message;
  } else {
    data.messageInfo = result.data.message;
    // call available books
    await loadReservedBooks();
  }
};

const setSelectedReservation = (id) => {
  data.reservationId = id;
  showModal();
};

onMounted(async () => {
  await loadReservedBooks();
});
</script>

<style scoped></style>
