// TROCA NOMES
const input = document.getElementById("pesquisa-principal");
    const palavras = ['Busque "Inglês"', 'Busque "Francês"', 'Busque "Canto"', 'Busque "Personal trainer"'];
    let index = 0;

    setInterval(() => {
      index = (index + 1) % palavras.length;
      input.setAttribute("placeholder", palavras[index]);
    }, 2000); 


//ROLAGEM DA BARRA


function Rolagem(distancia) {
  const barra = document.getElementById("materiasBarra");
  barra.scrollLeft += distancia;
}