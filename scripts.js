// ROLAGEM DA BARRA
const input = document.getElementById("pesquisa-principal");
const palavras = ['Busque "Inglês"', 'Busque "Francês"', 'Busque "Canto"', 'Busque "Personal trainer"'];
let index = 0;

setInterval(() => {
  index = (index + 1) % palavras.length;
  input.setAttribute("placeholder", palavras[index]);
}, 2000); 

// Função de rolagem para a barra de matérias
function Rolagem(distancia) {
  const barra = document.getElementById("materiasBarra");
  barra.scrollLeft += distancia;
}

// Adicionando funcionalidade ao botão "Mais informações"
document.querySelectorAll('.mais-info').forEach(button => {
  button.addEventListener('click', function(event) {
    event.preventDefault();
    alert('Abrindo mais informações!');
    // Aqui você pode abrir uma modal ou redirecionar o usuário para outra página
  });
});
