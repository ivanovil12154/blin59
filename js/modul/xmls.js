let divfon = null;

let xhr = null;

function SendData(addurl, fdata, func, fparam, fune) {
	divfon = GetFon();
  xhr = new XMLHttpRequest();
  xhr.open('POST', addurl);
  xhr.responseType = 'text';
  xhr.send(fdata);

  xhr.onload = function () {
		divfon.remove();
    if (xhr.status != 200) {
      alert(`Ошибка ${xhr.status}: ${xhr.statusText}`);
    } else {
    	if (func != null){
        func(xhr.response, fparam);  
			};
    }
  }; 
  xhr.onerror = function () {
		divfon.remove();
    alert(`Ошибка соединения`);
		if (fune != null){
			fune(fparam);
		}
		return;
  };
  xhr.onprogress = function(event) {
		/*
    if (event.lengthComputable) {
      alert(`Получено ${event.loaded} из ${event.total} байт`);
    } else {
      alert(`Получено ${event.loaded} байт`); // если в ответе нет заголовка Content-Length
    }
		*/
  };    
};

function breakload(){
	xhr.abort();
}

function GetFon(){
	divfon = document.createElement('div');
	divfon.className = 'FonLoadWin';  
//	divfon.className = 'FonModalWin';  
	divfon.style.display = 'block';
	divfon.innerHTML = 'Загрузка';
	let key = document.createElement('input');
	key.type = 'button';
	key.onclick = "breakload()";
	key.value = 'Прервать';
	divfon.append(key);
	let vbody = document.querySelector('body');
	vbody.prepend(divfon);
	return  divfon;
}

async function sha256(message) {
  // Кодируем строку в Uint8Array
  const msgBuffer = new TextEncoder().encode(message);
  // Хешируем
  const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
  // Преобразуем в шестнадцатеричную строку
  const hashArray = Array.from(new Uint8Array(hashBuffer));
  return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
}
