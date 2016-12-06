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
  let fila_plan = 5;
  let modens = document.getElementById('modens').tBodies[0].children;
  let size = document.getElementById('modens').tBodies[0].childElementCount;
  for (let i = 1; i < size; i++) {
    if (modens[i].children[fila_repuesta].innerText !== '') {

      saldo = modens[i].children[fila_repuesta].innerText.match(/Saldo Bs. \d+,\d+/gm);
      if (saldo === null) {
        error_saldo = "FALLO SALDO";
        saldo = modens[i].children[fila_saldo].firstChild.value;
        sms = modens[i].children[fila_mensajes].firstChild.value;
      } 
      else{
        saldo = saldo[0].slice(10).replace(',', '.');

        sms = modens[i].children[fila_repuesta].innerText.match(/SMS: \d+/);
        if (sms === null) {
          if(modens[i].children[fila_plan].innerText !== 'SMS Ilimitado')
          {
            error_sms = "FALLO SMS";
          }
          sms = 0;
        } 
        else 
        {
            sms = sms[0].slice(5);
        }
     }
      out += saldo + '\t' + sms + '\n';
      modens[i].children[fila_saldo].firstChild.value = saldo;
      modens[i].children[fila_mensajes].firstChild.value = sms;
      modens[i].children[fila_coment].firstChild.value = error_saldo + error_sms;
    }
    error_saldo = '';
    error_sms = '';
  }
  //console.log(out);
}
actualizarCampos();