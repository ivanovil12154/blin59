function elem_remove_all(gelem){
    elems = gelem.querySelectorAll("*");
    if (elems != null){
        for (let element of elems) {
            element.remove();
        };
    };    
};

function GeneratorRowForGrid(ClassRow, ClassCell, ClassItem, names){
    let elemrow = document.createElement('div');
	elemrow.className = ClassRow;
	grid_MOOverduelist.append(elemrow);

	for (let c = 0; c < names.length; c++){
		elem0 = document.createElement('div');		  
		elem0.className = ClassCell;
		elemrow.append(elem0);

		elem1 = document.createElement('div');		  
		elem1.className = ClassItem;
		elem1.innerHTML = names[c];
		elem0.append(elem1);
	}
    return elemrow; 
};

// разбить строку на массив с определенным кол символов
function splitString(str, length) {
  const result = [];
  for (let i = 0; i < str.length; i += length) {
    result.push(str.slice(i, i + length));
  }
  return result;
}

function VisibleWin(SpisWin, VisWin){
    for (let ind = 0; ind < SpisWin.length; ind++){
        if (SpisWin[ind] == VisWin) {
            SpisWin[ind].classList.remove('elem_hide');
        } else {
            SpisWin[ind].classList.add('elem_hide');
        }
  
    }
}


///////////////////////////////////////////
function Base64ToBlob(data, TD){
	const base64Data = data;
//	const contentType = 'image/png'; // Укажите правильный MIME-тип
	let contentType = ''; 

    if (TD != null && TD.length > 0) {
        contentType = TD; 
    } else {
        contentType = 'application/octet-stream'; 
    };
	

	// 1. Декодируем base64
	const sliceSize = 512;
	const byteCharacters = atob(base64Data);
	const byteArrays = [];

	// 2. Преобразуем в бинарный формат
	for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
  		const slice = byteCharacters.slice(offset, offset + sliceSize);
  		const byteNumbers = new Array(slice.length);
  		for (let i = 0; i < slice.length; i++) {
    		byteNumbers[i] = slice.charCodeAt(i);
  		}
  		const byteArray = new Uint8Array(byteNumbers);
  		byteArrays.push(byteArray);
	}

	// 3. Создаем Blob
	const blob = new Blob(byteArrays, {type: contentType});
	return blob;
};	

function saveFile(blob, filename) {
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement('a');
  
  a.style.display = 'none';
  a.href = url;
  a.download = filename;
  document.body.appendChild(a);
  a.click();
  
  window.URL.revokeObjectURL(url);
  document.body.removeChild(a);
}

function DateDBStrToDateUsStr(DateDBStr){
    if (DateDBStr != null && DateDBStr != ""){
    	let parts = DateDBStr.split("-");
   		const s = (`0${parts[2]}`).slice(-2) + '.' +
                (`0${parts[1]}`).slice(-2) + '.' +
       			(`0${parts[0]}`).slice(-4);
        return s;

	} else {
        return "";
    };	    

}

function DateAddMont(SDate, AddMont){
  let dateStr = SDate.value;
	if (dateStr != ""){
   	let parts = dateStr.split("-");
     
  	let MontF = Number(parts[1]) - 1 + Number(AddMont);	 
		let Year = Math.trunc(MontF / 12);
		let Mont = 0;
		if (Year > 0) {
			Mont = MontF - (Year * 12);
		};
 		Year = Year + Number(parts[0]);
 		const s =   (`0000${Year}`).slice(-4) + '-' + 
                (`0${Mont + 1}`).slice(-2) + '-' + 
  	       			(`0${parts[2]}`).slice(-2);
      return s;
  } else {
    return '';
  }
};



function CheckPassword(Pass1, Pass2, PassOld){
  if (Pass1 != Pass2){
    alert ('Пароли не совподают');
    return false;
  };
  if (PassOld == Pass1){
    alert ('Пароли без изменения');
    return false;
  };
  if (Pass1.length < 6){
    alert ('Количество символов в пароле должно быть больше 5');
    return false;
  }


  var s_letters = "qwertyuiopasdfghjklzxcvbnm"; // Буквы в нижнем регистре
  var b_letters = "QWERTYUIOPLKJHGFDSAZXCVBNM"; // Буквы в верхнем регистре
  var sb_letters = "QWERTYUIOPLKJHGFDSAZXCVBNMqwertyuiopasdfghjklzxcvbnm"; // Буквы 

  var digits = "0123456789"; // Цифры
  var specials = "!@#$%^&*()_-+=\|/.,:;[]{}"; // Спецсимволы
  var is_s = false; // Есть ли в пароле буквы в нижнем регистре
  var is_b = false; // Есть ли в пароле буквы в верхнем регистре
  var is_sb = false; // Есть ли в пароле буквы 
  var is_d = false; // Есть ли в пароле цифры
  var is_sp = false; // Есть ли в пароле спецсимволы

  for (var i = 0; i < Pass1.length; i++) {
    /* Проверяем каждый символ пароля на принадлежность к тому или иному типу */
    if (!is_s && s_letters.indexOf(Pass1[i]) != -1) is_s = true;
    else if (!is_b && b_letters.indexOf(Pass1[i]) != -1) is_b = true;
    else if (!is_d && digits.indexOf(Pass1[i]) != -1) is_d = true;
    else if (!is_sp && specials.indexOf(Pass1[i]) != -1) is_sp = true;
  }
  if (!is_b && !is_s){
    alert ('В пароле должны присутствовать латинские символ');
    return false;
  }

  if (!is_d){
    alert ('В пароле должны присутствовать цифровые символы');
    return false;
  }

  if (!is_sp){
    alert ('В пароле должны присутствовать спецсимволы - "!@#$%^&*()_-+=\|/.,:;[]{}"');
    return false;
  }

  return true;




  var rating = 0;
  var text = "";
  if (is_s) rating++; // Если в пароле есть символы в нижнем регистре, то увеличиваем рейтинг сложности
  if (is_b) rating++; // Если в пароле есть символы в верхнем регистре, то увеличиваем рейтинг сложности
  if (is_d) rating++; // Если в пароле есть цифры, то увеличиваем рейтинг сложности
  if (is_sp) rating++; // Если в пароле есть спецсимволы, то увеличиваем рейтинг сложности
  /* Далее идёт анализ длины пароля и полученного рейтинга, и на основании этого готовится текстовое описание сложности пароля */
  if (pass1.length < 6 && rating < 3) text = "Простой";
  else if (pass1.length < 6 && rating >= 3) text = "Средний";
  else if (pass1.length >= 8 && rating < 3) text = "Средний";
  else if (pass1.length >= 8 && rating >= 3) text = "Сложный";
  else if (pass1.length >= 6 && rating == 1) text = "Простой";
  else if (pass1.length >= 6 && rating > 1 && rating < 4) text = "Средний";
  else if (pass1.length >= 6 && rating == 4) text = "Сложный";
  alert(text); // Выводим итоговую сложность пароля
  return false; // Форму не отправляем

}


class PMyWork {
  IDWork = 0;
  IDZadan = 0;
  ZdName = '';
  ZdNameL = '';
  WkDateBegin = '';
  WkDatePerform = '';
  WkDateEnd = '';
  WkGrade = '';
  WkTextPrepod = '';
  WkTextStudent = '';
  WkEnabled = '';

  PrepodIDUser = 0;
  PrepodUserNameS = '';
  StudentIDUser = 0;
  StudentUserNameS = '';

  SpisVopros = [];
  LoadFromBD = function (Mas) {
    this.IDWork = Mas['IDWork'];
    this.IDZadan = Mas['IDZadan'];
    this.ZdName = Mas['ZdName'];
    this.ZdNameL = Mas['ZdNameL'];
    this.WkDateBegin = StrToDate(Mas['WkDateBegin']);
    this.WkDatePerform = StrToDate(Mas['WkDatePerform']);
    this.WkDateEnd = StrToDate(Mas['WkDateEnd']);
    this.WkGrade = Mas['WkGrade'];
    this.WkTextPrepod = Mas['WkTextPrepod'];
    this.WkTextStudent = Mas['WkTextStudent'];

    this.PrepodIDUser = Mas['PrepodIDUser'];
    this.PrepodUserNameS = Mas['PrepodUserNameS'];
    this.StudentIDUser = Mas['StudentIDUser'];
    this.StudentUserNameS = Mas['StudentUserNameS'];
    this.WkEnabled = Mas['WkEnabled'];
  };
  GetCountVoprosAllTestPrav = function () {
    let CountAll = 0;
    let CountTest = 0;
    let CountPrav = 0;
    for (let vopros of this.SpisVopros) {
      CountAll += 1;
      if (vopros.SpisOtvet.length > 0) {
        CountTest += 1;
        let Prav = true;
        for (let otvet of vopros.SpisOtvet) {
          if (!otvet.GetPrav()) {
            Prav = false;
          }
        }
        if (Prav) {
          CountPrav += 1;
        }
      }
    }
    return CountAll + '/' + CountTest + '/' + CountPrav;
  };
}