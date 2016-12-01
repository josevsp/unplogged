function actualizarCampos() {
  let out = '';
  let sms = '';
  let saldo = '';
  let error_sms = '';
  let error_saldo = '';
  let fila_saldo = 3;
  let fila_mensajes = 4;
  let fila_repuesta = 9;
  let fila_coment = 2;
  let modens = document.getElementById('modens').tBodies[0].children;
  let size = document.getElementById('modens').tBodies[0].childElementCount;
  for (let i = 1; i < size; i++) {
    if (modens[i].children[fila_repuesta].innerText !== '') {

      let date = new Date();
      date = (date.getMonth()+1) + '/' + date.getDate() + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
      sms = modens[i].children[fila_repuesta].innerText.match(/SMS: \d+/);
      if (sms === null) {
        date = '';
        error_sms = "NO DIO MENSAJES";
        sms = 0;
      } else {

        sms = sms[0].slice(5);
      }
      saldo = modens[i].children[fila_repuesta].innerText.match(/Saldo Bs. \d+,\d+/gm);
      if (saldo === null) {
        date = '';
        error_saldo = "NO DIO SALDO";
        saldo = modens[i].children[fila_saldo].firstChild.value;
      } else {
        saldo = saldo[0].slice(10).replace(',', '.');
      }
      out += saldo + '\t' + date + '\t' + sms + '\n';
      modens[i].children[fila_saldo].firstChild.value = saldo;
      modens[i].children[fila_mensajes].firstChild.value = sms;
      modens[i].children[fila_coment].firstChild.value = error_saldo + ' ' + error_sms;
    }
    error_saldo = '';
    error_sms = '';
  }
  console.log(out);
}
actualizarCampos();