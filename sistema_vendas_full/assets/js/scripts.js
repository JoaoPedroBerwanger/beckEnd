const p = new URLSearchParams(location.search);

if (p.get("erro") === "1") {
    const e = document.getElementById("erro");
    e.textContent = "Usuário ou senha inválidos.";
    e.style.display = "block";
}

if (p.get("cad") === "ok") {
    const o = document.getElementById("ok");
    o.textContent = "Usuário cadastrado com sucesso!";
    o.style.display = "block";
}
