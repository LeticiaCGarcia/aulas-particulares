import React from "react";
import ReactDOM from "react-dom/client";
import AlternarTema from "./temaescuro";

const container = document.getElementById("tema-react");
if (container) {
  ReactDOM.createRoot(container).render(<AlternarTema />);
}
