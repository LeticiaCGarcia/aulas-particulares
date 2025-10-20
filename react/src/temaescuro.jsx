import { useState, useEffect } from "react";
import { Sun, Moon } from "lucide-react";

export default function AlternarTema() {
  const [escuro, setEscuro] = useState(() => {
    const temaSalvo = localStorage.getItem("modo-escuro");
    return temaSalvo === "true";
  });

  useEffect(() => {
    document.body.classList.toggle("modo-escuro", escuro);
    localStorage.setItem("modo-escuro", escuro);
  }, [escuro]);

  return (
    <button
      onClick={() => setEscuro(!escuro)}
      className="botao-tema"
      title={escuro ? "Modo Claro" : "Modo Escuro"}
    >
      {escuro ? <Sun size={22} /> : <Moon size={22} />}
    </button>
  );
}