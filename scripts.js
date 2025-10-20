// ===================================================================================================
//                                        ROLAGEM DA BARRA
// ===================================================================================================
document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("pesquisa-principal");
  if (!input) return;

  const palavras = ['Busque "Inglês"', 'Busque "Francês"', 'Busque "Canto"', 'Busque "Personal trainer"'];
  let index = 0;

  setInterval(() => {
    index = (index + 1) % palavras.length;
    input.setAttribute("placeholder", palavras[index]);
  }, 2000);
});

function Rolagem(distancia) {
  const barra = document.getElementById("materiasBarra");
  if (barra) barra.scrollLeft += distancia;
}


// ===================================================================================================
//                                BOTÕES DE "MAIS INFO" DOS PROFESSORES
// ===================================================================================================
document.querySelectorAll('.mais-info').forEach(button => {
  button.addEventListener('click', function(event) {
    event.preventDefault();
    alert('Abrindo mais informações!');
    // TEM Q COLOCAR A OUTRA PAGINA
  });
});


// ===================================================================================================
//                                    AJUSTE DE TOOLTIP DOS PROFESSORES
// ===================================================================================================
document.addEventListener("DOMContentLoaded", () => {
  const profs = document.querySelectorAll(".modelo-prof");

  profs.forEach(card => {
    const tooltip = card.querySelector(".tooltip-prof");
    if (!tooltip) return;

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


// ===================================================================================================
//                                VERIFICA SE AS SENHAS ESTÃO IGUAIS
// ===================================================================================================
document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector('form');
  if (!form) return;

  form.addEventListener('submit', function(e) {
    const senha = document.getElementById('senha');
    const confirmarSenha = document.getElementById('confirmar_senha');
    if (!senha || !confirmarSenha) return;

    if (senha.value !== confirmarSenha.value) {
      alert('As senhas não coincidem!');
      e.preventDefault();
    }
  });
});


// ===================================================================================================
//                                        VERIFICA DO LOGIN
// ===================================================================================================
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


// ===================================================================================================
//                     PEGA OS PROFESSORES PELO ID NA ROLAGEM DA BARRA
// ===================================================================================================
document.addEventListener('DOMContentLoaded', function() {
  const materias = document.querySelectorAll('.materia');
  materias.forEach(materia => {
    materia.addEventListener('click', function() {
      const idMateria = this.getAttribute('data-id');
      window.location.href = "professores.php?id_materia=" + idMateria;
    });
  });
});


// ===================================================================================================
//                          FUNCIONA A BARRA DE PESQUISA (AUTOCOMPLETE)
// ===================================================================================================
document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("pesquisa-principal");
  const sugestoes = document.getElementById("sugestoes");
  const botaoBuscar = document.getElementById("botao-buscar");
  let materiaSelecionada = null;

  if (!input || !sugestoes || !botaoBuscar) return;

  // Quando digita, busca no banco
  input.addEventListener("input", async () => {
    const termo = input.value.trim();
    if (termo.length < 1) {
      sugestoes.innerHTML = "";
      return;
    }

    try {
      const resposta = await fetch(`buscar_materias.php?q=${encodeURIComponent(termo)}`);
      if (!resposta.ok) throw new Error("Erro ao buscar matérias");

      const dados = await resposta.json();
      sugestoes.innerHTML = "";

      dados.forEach(materia => {
        const li = document.createElement("li");
        li.textContent = materia.nome;
        li.dataset.id = materia.id_materia;

        li.addEventListener("click", () => {
          input.value = materia.nome;
          materiaSelecionada = materia.id_materia;
          sugestoes.innerHTML = "";
        });

        sugestoes.appendChild(li);
      });
    } catch (erro) {
      console.error("Erro ao buscar matérias:", erro);
    }
  });

  botaoBuscar.addEventListener("click", () => {
    if (materiaSelecionada) {
      window.location.href = `professores.php?id_materia=${materiaSelecionada}`;
    } else {
      alert("Selecione uma matéria válida antes de buscar!");
    }
  });
});
