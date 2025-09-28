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

// Ajuste de posição da tooltip
document.addEventListener("DOMContentLoaded", () => {
  const profs = document.querySelectorAll(".modelo-prof");

  profs.forEach(card => {
    const tooltip = card.querySelector(".tooltip-prof");

    card.addEventListener("mouseenter", () => {
      const rect = card.getBoundingClientRect();
      const tooltipWidth = tooltip.offsetWidth;
      const screenWidth = window.innerWidth;

      // se o card + tooltip ultrapassar a largura da tela → abre para a esquerda
      if (rect.right + tooltipWidth > screenWidth - 20) {
        tooltip.style.left = "auto";
        tooltip.style.right = "105%"; 
      } else {
        tooltip.style.left = "105%";
        tooltip.style.right = "auto";
      }
    });
  });
});


 // VERIFICA SE AS SENHAS ESTÃO IGUAIS 

document.querySelector('form').addEventListener('submit', function(e) {
    const senha = document.getElementById('senha').value;
    const confirmarSenha = document.getElementById('confirmar_senha').value;

    if (senha !== confirmarSenha) {
        alert('As senhas não coincidem!');
        e.preventDefault(); 
    }
});


// VERIFICADOR DO LOGIN

document.addEventListener('DOMContentLoaded', () => {
  const loginForm = document.getElementById('loginForm');
  if (!loginForm) return;

  loginForm.addEventListener('submit', function(event) {
    const email = document.getElementById('email');
    const senha = document.getElementById('senha');

    email.setCustomValidity('');
    senha.setCustomValidity('');

    let valido = true;

    if (!email.value) {
      email.setCustomValidity('Por favor, preencha seu email.');
      valido = false;
    } else {
      
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email.value)) {
        email.setCustomValidity('Por favor, insira um email válido.');
        valido = false;
      }
    }

    if (!senha.value) {
      senha.setCustomValidity('Por favor, preencha sua senha.');
      valido = false;
    } else if (senha.value.length < 4) {
      senha.setCustomValidity('Senha deve ter ao menos 4 caracteres.');
      valido = false;
    }

    if (!valido) {
      email.reportValidity();
      senha.reportValidity();
      event.preventDefault();
    }
  });
});