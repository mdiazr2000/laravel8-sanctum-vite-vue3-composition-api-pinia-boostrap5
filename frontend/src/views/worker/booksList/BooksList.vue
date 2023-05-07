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
    <div style="display: flex; flex-direction: column; width: 70%">
      <InfoContainer v-if="data.messageInfo" :message="data.messageInfo" />
      <h1>Books List</h1>
      <span
        >Note: click over reserved status to see details of reservation</span
      >
      <button
        type="button"
        class="btn btn-primary"
        style="width: 100px"
        @click="showModalAddBook"
      >
        Add book
      </button>
      <table class="table">
        <thead>
          <tr>
            <th scope="row">#</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Active</th>
            <th scope="col">Status</th>
            <th scope="col">Status Time</th>
            <th scope="col">Edit Book</th>
            <th scope="col">Delete Book</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(book, index) in data.listBooks" :key="book.id">
            <th scope="row">{{ ++index }}</th>
            <td>{{ book.title }}</td>
            <td>{{ book.description }}</td>
            <td>{{ book.active ? "Yes" : "No" }}</td>
            <td>
              <div
                v-if="book.reservation.length > 0"
                style="cursor: pointer"
                @click="setSelectedReservation(book.reservation)"
              >
                Reserved
                <i class="bi bi-folder-fill"></i>
              </div>
              <div v-if="book.reservation.length == 0">
                Free
                <i class="bi bi-folder"></i>
              </div>
            </td>
            <td>
              <div v-if="book?.reservation.length > 0">
                <div v-if="book?.reservation[0].status_time == 'ontime'">
                  Ontime <i class="bi bi-alarm"></i>
                </div>
                <div v-if="book?.reservation[0].status_time == 'overdue'">
                  Overdue <i class="bi bi-alarm-fill"></i>
                </div>
              </div>
            </td>
            <td align="center">
              <i
                class="bi bi-pencil"
                style="cursor: pointer"
                @click="showModalEditBook(book)"
              ></i>
            </td>
            <td align="center">
              <i
                class="bi bi-trash3"
                style="cursor: pointer"
                @click="showModalDeleteBook(book)"
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
          <h5 id="exampleModalLabel" class="modal-title">
            Reservation details
          </h5>
          <button
            type="button"
            class="btn-close"
            aria-label="Close"
            @click="hideModal"
          ></button>
        </div>
        <div class="modal-body">
          <div>
            Client name : {{ data.reservationSelected?.client.name }}
            {{ data.reservationSelected?.client.lastname }}
          </div>
          <div>Initial date : {{ data.reservationSelected?.initialDate }}</div>
          <div>Final date : {{ data.reservationSelected?.finalDate }}</div>
          <div>Status : {{ data.reservationSelected?.status_time }}</div>
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
        </div>
      </div>
    </div>
  </div>

  <div
    id="addBook"
    ref="modalAddBook"
    class="modal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">Add book</h5>
          <button
            type="button"
            class="btn-close"
            aria-label="Close"
            @click="hideModalAddBook"
          ></button>
        </div>
        <div class="modal-body">
          <div
            style="
              display: flex;
              flex-direction: column;
              align-items: center;
              margin-top: 10px;
            "
          >
            <ErrorContainer :errors="data.validationErrors" />
            <div
              style="
                display: flex;
                width: 400px;
                flex-direction: column;
                justify-content: space-around;
              "
            >
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"
                  >Title</label
                >
                <input
                  id="exampleFormControlInput1"
                  type="text"
                  class="form-control"
                  placeholder="Title"
                  :value="data.book.title"
                  @input="(event) => (data.book.title = event.target.value)"
                />
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"
                  >Description</label
                >
                <input
                  id="exampleFormControlInput1"
                  type="text"
                  class="form-control"
                  placeholder="Description"
                  :value="data.book.description"
                  @input="
                    (event) => (data.book.description = event.target.value)
                  "
                />
              </div>
              <div class="form-check">
                <input
                  id="flexCheckChecked"
                  ref="activeCheckAddBook"
                  class="form-check-input"
                  type="checkbox"
                  value=""
                  checked
                />
                <label class="form-check-label" for="flexCheckChecked">
                  Active
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            ref="closeModal"
            type="button"
            class="btn btn-secondary"
            @click="hideModalAddBook"
          >
            Close
          </button>
          <button type="button" class="btn btn-primary" @click="addBook">
            Add
          </button>
        </div>
      </div>
    </div>
  </div>

  <div
    id="editBook"
    ref="modalEditBook"
    class="modal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">Edit book</h5>
          <button
            type="button"
            class="btn-close"
            aria-label="Close"
            @click="hideModalEditBook"
          ></button>
        </div>
        <div class="modal-body">
          <div
            style="
              display: flex;
              flex-direction: column;
              align-items: center;
              margin-top: 10px;
            "
          >
            <ErrorContainer :errors="data.validationErrors" />
            <div
              style="
                display: flex;
                width: 400px;
                flex-direction: column;
                justify-content: space-around;
              "
            >
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"
                  >Title</label
                >
                <input
                  id="exampleFormControlInput1"
                  type="text"
                  class="form-control"
                  placeholder="Title"
                  :value="data.book.title"
                  @input="(event) => (data.book.title = event.target.value)"
                />
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"
                  >Description</label
                >
                <input
                  id="exampleFormControlInput1"
                  type="text"
                  class="form-control"
                  placeholder="Description"
                  :value="data.book.description"
                  @input="
                    (event) => (data.book.description = event.target.value)
                  "
                />
              </div>
              <div class="form-check">
                <input
                  id="flexCheckChecked"
                  ref="activeCheckEditBook"
                  class="form-check-input"
                  type="checkbox"
                  value=""
                />
                <label class="form-check-label" for="flexCheckChecked">
                  Active
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            ref="closeModal"
            type="button"
            class="btn btn-secondary"
            @click="hideModalEditBook"
          >
            Close
          </button>
          <button type="button" class="btn btn-primary" @click="editBook">
            Update
          </button>
        </div>
      </div>
    </div>
  </div>

  <div
    id="deleteModal"
    class="modal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">Delete book</h5>
          <button
            type="button"
            class="btn-close"
            aria-label="Close"
            @click="hideModalDeleteBook"
          ></button>
        </div>
        <div class="modal-body">
          Are you sure that you want to delete this book?
        </div>
        <div class="modal-footer">
          <button
            ref="closeModal"
            type="button"
            class="btn btn-secondary"
            @click="hideModalDeleteBook"
          >
            Close
          </button>
          <button
            ref="closeModal"
            type="button"
            class="btn btn-primary"
            @click="deleteBook"
          >
            Accept
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {
  getAddBooksEndpoint,
  getListBooksEndpoint,
  getDeleteBooksEndpoint,
} from "../../../core/endpoints";
import {
  GetRequest,
  PostRequest,
  PutRequest,
  DeleteRequest,
} from "../../../core/api-request";
import { reactive, onMounted, ref } from "vue";
import { useAuthStore } from "../../../stores.js";
import InfoContainer from "../../../components/InfoContainer.vue";
import ErrorContainer from "../../../components/ErrorContainer.vue";
import { Modal } from "bootstrap";

const store = useAuthStore();

const activeCheckAddBook = ref(false);
const activeCheckEditBook = ref(false);

const data = reactive({
  listBooks: "",
  errorInfo: null,
  clientId: store.profile.id,
  bookIdSelected: null,
  modalGeneric: null,
  reservationSelected: null,
  messageInfo: null,
  validationErrors: [],
  book: {},
});

const showModal = () => {
  data.modalGeneric = new Modal(document.getElementById("exampleModal2"), {});
  data.modalGeneric.show();
};

const hideModal = () => {
  data.modalGeneric.hide();
};

const showModalAddBook = () => {
  data.modalGeneric = new Modal(document.getElementById("addBook"), {});
  data.validationErrors = [];
  data.book.title = "";
  data.book.description = "";
  data.modalGeneric.show();
};

const hideModalAddBook = () => {
  data.modalGeneric.hide();
};

const showModalEditBook = (book) => {
  data.modalGeneric = new Modal(document.getElementById("editBook"), {});
  data.validationErrors = [];
  data.book = Object.assign({}, book);
  activeCheckEditBook.value.checked = data.book.active;
  data.modalGeneric.show();
};

const hideModalEditBook = () => {
  data.modalGeneric.hide();
};

const showModalDeleteBook = (book) => {
  data.modalGeneric = new Modal(document.getElementById("deleteModal"), {});
  data.validationErrors = [];
  data.book.id = book.id;
  data.modalGeneric.show();
};

const hideModalDeleteBook = () => {
  data.modalGeneric.hide();
};

const loadBooks = async () => {
  const url = getListBooksEndpoint;
  data.validationErrors = null;
  const result = await GetRequest(url, store.token);
  if (result.status !== 200) {
    data.listBooks = [];
  } else {
    data.listBooks = result.data.data;
  }
};

const addBook = async () => {
  const url = getAddBooksEndpoint;
  data.validationErrors = null;
  const result = await PostRequest(
    url,
    {
      title: data.book.title,
      description: data.book.description,
      reserved: false,
      active: activeCheckAddBook.value.checked,
    },
    store.token
  );
  if (result.status !== 200) {
    data.validationErrors = result.data.error;
  } else {
    data.messageInfo = result.data.message;
    hideModalAddBook();
    // call available books
    await loadBooks();
  }
};

const editBook = async () => {
  const url = getAddBooksEndpoint;
  data.validationErrors = null;
  const result = await PutRequest(
    url,
    {
      title: data.book.title,
      description: data.book.description,
      reserved: data.book.reserved,
      active: activeCheckEditBook.value.checked,
      id: data.book.id,
    },
    store.token
  );
  if (result.status !== 200) {
    data.validationErrors = result.data.error;
  } else {
    data.messageInfo = result.data.message;
    hideModalEditBook();
    // call available books
    await loadBooks();
  }
};

const deleteBook = async () => {
  const url = getDeleteBooksEndpoint(data.book.id);
  data.validationErrors = null;
  const result = await DeleteRequest(url, store.token);
  if (result.status !== 200) {
    data.validationErrors = result.data.error;
  } else {
    data.messageInfo = result.data.message;
    hideModalDeleteBook();
    // call available books
    await loadBooks();
  }
};

const setSelectedReservation = (reservation) => {
  data.reservationSelected = reservation.length ? reservation[0] : null;
  showModal();
};

onMounted(async () => {
  await loadBooks();
});
</script>

<style scoped></style>
