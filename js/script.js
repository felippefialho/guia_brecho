var swiper = new Swiper(".slide-content", {
  slidesPerView: 3,
  spaceBetween: 25,
  loop: true,
  centerSlide: 'true',
  fade: 'true',
  grabCursor: 'true',
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    520: {
      slidesPerView: 2,
    },
    950: {
      slidesPerView: 3,
    },
  },
});

//ALGORITMO AUTOPREENCHIMENTO PELO CEP


const cepInput = document.querySelector("#cep");
const rua = document.querySelector("#rua");
const bairro = document.querySelector("#bairro");
const cidade = document.querySelector("#cidade");
const estado = document.querySelector("#estado");
const numero = document.querySelector("#numero");
const form = document.querySelector("#formCep");
const dataInput = document.querySelectorAll("[data-input]");

cepInput.addEventListener("keypress", (e) => {
  const someteNumeros = /[0-9]/;
  const key = String.fromCharCode(e.keyCode);

  if (!someteNumeros.test(key)) {
    e.preventDefault();
    return;
  }
});

cepInput.addEventListener("keyup", (e) => {
  const inputValue = e.target.value;

  if (inputValue.length === 8) {
    getAddres(inputValue);
  }
});

const getAddres = async (cep) => {
  mostraLoad();
  cepInput.blur();

  const apiUrl = `https://viacep.com.br/ws/${cep}/json`;

  const response = await fetch(apiUrl);
  const dadosCep = await response.json();

  if (dadosCep.erro === "true") {
    form.reset();
    dataInput.reset();
    mostraLoad();
    return;
  }

  rua.value = dadosCep["logradouro"];
  bairro.value = dadosCep["bairro"];
  cidade.value = dadosCep["localidade"];
  estado.value = dadosCep["uf"];
  mostraLoad();

  rua.removeAttribute("disabled");
  bairro.removeAttribute("disabled");
  cidade.removeAttribute("disabled");
  estado.removeAttribute("disabled");
  numero.removeAttribute("disabled")

};

mostraLoad = () => {
  const loadFade = document.querySelector("#fade");
  const loadElement = document.querySelector("#load");

  loadFade.classList.toggle("hide");
  loadElement.classList.toggle("hide");
};
