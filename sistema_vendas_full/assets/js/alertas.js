const p = new URLSearchParams(location.search);

if (p.get("erro")) {
  const div = document.getElementById("erro");
  div.textContent = traduzErro(p.get("erro"));
  div.style.display = "block";
}

if (p.get("cad") === "ok" || p.get("msg") === "ok") {
  const div = document.getElementById("ok");
  div.textContent = traduzSucesso(p.get("cad") || p.get("msg"));
  div.style.display = "block";
}

function traduzErro(codigo) {
  switch (codigo) {
    case "1": return "Preencha todos os campos.";
    case "loginDuplicado": return "Este login já está em uso.";
    case "db": return "Erro ao salvar no banco de dados.";
    case "invalido": return "Usuário ou senha inválidos.";
    default: return "Ocorreu um erro desconhecido.";
  }
}

function traduzSucesso(codigo) {
  switch (codigo) {
    case "ok": return "Operação realizada com sucesso!";
    default: return "Ação concluída.";
  }
}
