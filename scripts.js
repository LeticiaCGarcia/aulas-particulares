// ROLAGEM DA BARRA
const input = document.getElementById("pesquisa-principal");
const palavras = ['Busque "Inglês"', 'Busque "Francês"', 'Busque "Canto"', 'Busque "Personal trainer"'];
let index = 0;

setInterval(() => {
  index = (index + 1) % palavras.length;
  input.setAttribute("placeholder", palavras[index]);
}, 2000); 

function Rolagem(distancia) {
  const barra = document.getElementById("materiasBarra");
  barra.scrollLeft += distancia;
}

document.querySelectorAll('.mais-info').forEach(button => {
  button.addEventListener('click', function(event) {
    event.preventDefault();
    alert('Abrindo mais informações!');
    // TEM Q COLOCAR A OUTRA PAGINA
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const profs = document.querySelectorAll(".modelo-prof");

  profs.forEach(card => {
    const tooltip = card.querySelector(".tooltip-prof");

    card.addEventListener("mouseenter", () => {
      const rect = card.getBoundingClientRect();
      const tooltipWidth = tooltip.offsetWidth;
      const screenWidth = window.innerWidth;

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

// VERIFICA DO LOGIN
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

// PARA PESQUISAR OS PROFESSORES
document.getElementById('pesquisa-principal').addEventListener('input', function() {
    const query = this.value.toLowerCase();
    const professores = document.querySelectorAll('#professores-container .modelo-prof');

    professores.forEach(prof => {
        const nome = prof.getAttribute('data-nome');
        const materia = prof.getAttribute('data-materia');

        if (nome.includes(query) || materia.includes(query)) {
            prof.style.display = 'block';
        } else {
            prof.style.display = 'none';
        }
    });
});

// PEGA OS PROFESSORES PELO ID NA ROLAGEM DA BARRA
document.addEventListener('DOMContentLoaded', function() {
    const materias = document.querySelectorAll('.materia');
    materias.forEach(materia => {
        materia.addEventListener('click', function() {
            const idMateria = this.getAttribute('data-id');
            window.location.href = "professores.php?id_materia=" + idMateria;
        });
    });
});
