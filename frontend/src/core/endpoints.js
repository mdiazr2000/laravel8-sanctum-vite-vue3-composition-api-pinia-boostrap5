export const API_ENDPOINT =
  import.meta.env.VITE_APP_BACKEND_URL || "http://localhost:8000/api";
export const BACKEND_URL =
  import.meta.env.VITE_APP_SERVER_URL || "http://localhost:8000";

export const getCSRFToken = BACKEND_URL + "/sanctum/csrf-cookie";
export const getLoginEndpoint = API_ENDPOINT + "/login";
export const getRegisterEndpoint = API_ENDPOINT + "/client";
export const getAvailableBooksEndpoint = API_ENDPOINT + "/books/available";
export const getReserveBookEndpoint = API_ENDPOINT + "/book/reserve";
export const getReservedBooksEndpoint = API_ENDPOINT + "/client/reservations";
export const getUnReservedBooksEndpoint = (idReservation) =>
  `${API_ENDPOINT}/book/unreserve/${idReservation}`;
export const getListBooksEndpoint = API_ENDPOINT + "/books";
export const getAddBooksEndpoint = API_ENDPOINT + "/book";
export const getDeleteBooksEndpoint = (id) => `${API_ENDPOINT}/book/${id}`;
export const getUpdateFileNameEndpoint = (id) =>
  `${API_ENDPOINT}/updateFile/${id}`;
