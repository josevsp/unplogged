function actualizarCampos() {
  let out = '';
  let sms = '';
  let saldo = '';
  let modens = document.getElementById('modens').tBodies[0].children;
  let size = document.getElementById('modens').tBodies[0].childElementCount;
  for (let i = 1; i < size; i++) {
    if (modens[i].children[8].innerText !== '') {
      let date = new Date();
      date = (date.getMonth()+1) + '/' + date.getDate() + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
      sms = modens[i].children[8].innerText.match(/SMS: \d+/);
      if (sms === null) {
        date = "NO DIO SALDO";
        sms = modens[i].children[2].firstChild.value;
      } else {
        sms = sms[0].slice(5);
      }
      saldo = modens[i].children[8].innerText.match(/Saldo Bs. \d+,\d+/gm);
      if (saldo === null) {
        date = "NO DIO SALDO";
        saldo = modens[i].children[3].firstChild.value;
      } else {
        saldo = saldo[0].slice(10).replace(',', '.');
      }
      out += saldo + '\t' + date + '\t' + sms + '\n';
      modens[i].children[3].firstChild.value = saldo;
      modens[i].children[2].firstChild.value = sms;
    }
  }
  console.log(out);
}
actualizarCampos();