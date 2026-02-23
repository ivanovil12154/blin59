const TOccPrepod = 'TOPrd',
  TOccStudent = 'TOStd',
  TOccCurator = 'TOCur',
  TOccParent = 'TOPrn';

class POtvet {
  IDWorkOtvet = 0;
  WkOtCheckOtvet = '';
  WkOtTextStudent = '';
  WkOtTextPrepod = '';
  WkOtOrder = '';
  ZdOtPrav = '';
  ZdOtText = '';
  TegOtvet = null;
  LoadFromBD = function (Mas) {
    this.IDWorkOtvet = Mas['IDWorkOtvet'];
    this.WkOtCheckOtvet = Mas['WkOtCheckOtvet'];
    this.WkOtTextStudent = Mas['WkOtTextStudent'];
    this.WkOtTextPrepod = Mas['WkOtTextPrepod'];
    this.WkOtOrder = Mas['WkOtOrder'];
    this.ZdOtPrav = Mas['ZdOtPrav'];
    this.ZdOtText = Mas['ZdOtText'];
  };
  GetPrav() {
    return this.WkOtCheckOtvet == this.ZdOtPrav;
  }
}
class PVopros {
  IDWorkVopros = 0;
  WkVsTextPrepod = '';
  WkVsTextStudent = '';
  WkVsOrder = '';
  WkVsCheckRes = '';
  WkVsGrad = 0;
  ZdVsText = '';
  SpisOtvet = [];
  TegVopros = null;
  LoadFromBD = function (Mas) {
    this.IDWorkVopros = Mas['IDWorkVopros'];
    this.WkVsTextPrepod = Mas['WkVsTextPrepod'];
    this.WkVsTextStudent = Mas['WkVsTextStudent'];
    this.WkVsOrder = Mas['WkVsOrder'];
    this.WkVsCheckRes = Mas['WkVsCheckRes'];
    this.WkVsGrad = Mas['WkVsGrad'];
    this.ZdVsText = Mas['ZdVsText'];
  };
  GetTestOtvet = function () {
    if (SpisOtvet.length > 1) {
      let BooPrav = true;
      for (let otvet of SpisOtvet) {
        if (!otvet.GetPrav) {
          BooPrav = false;
          break;
        }
      }
      if (BooPrav) {
        return 'Y';
      } else {
        return 'N';
      }
    } else {
      return '-';
    }
  };
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
class PPredmet {
  IDPredmet = 0;
  IDPredmetSpis = 0;
  PdSpName = '';
  PrepodIDUser = 0;
  PrepodUserNameS = '';
  StudentIDUser = 0;
  StudentUserNameS = '';
  IDClass = 0;
  ClsName = '';
  SpisWork = [];
  tegELem = null;
  LoadFromBD(mas) {
    this.IDPredmet = mas['IDPredmet'];
    this.IDPredmetSpis = mas['IDPredmetSpis'];
    this.PdSpName = mas['PdSpName'];
    this.PrepodIDUser = mas['PrepodIDUser'];
    this.PrepodUserNameS = mas['PrepodUserNameS'];
    this.StudentIDUser = mas['StudentIDUser'];
    this.StudentUserNameS = mas['StudentUserNameS'];
    this.IDClass = mas['IDClass'];
    this.ClsName = mas['ClsName'];
  }

  equals(mas) {
    return this.IDPredmetSpis == mas['IDPredmetSpis'] && this.PrepodIDUser == mas['PrepodIDUser'] && this.StudentIDUser == mas['StudentIDUser'] && this.IDClass == mas['IDClass'];
  }

  getName(VTOcc) {
    if (VTOcc == TOccPrepod) {
      return this.PdSpName + '<br>' + this.StudentUserNameS;
    }
    if (VTOcc == TOccStudent) {
      return this.PdSpName + '<br>' + this.PrepodUserNameS;
    }
  }

  getUspev() {
    let countEnd = 0;
    let grad = 0;
    for (let elem of this.SpisWork) {
      if (elem.WkDateEnd != null) {
        countEnd += 1;
        grad = Number(grad) + Number(elem.WkGrade);
      }
    }
    if (countEnd > 0) {
      let res = Math.round((grad * 10) / countEnd) / 10;
      return res;
    } else {
      return '-';
    }
  }
  GetPredPrep() {
    return this.PdSpName + '<br>' + this.PrepodUserNameS;
  }
  GetCountWork() {
    let countbegin = 0;
    let countPerform = 0;
    let countEnd = 0;
    for (let elem of this.SpisWork) {
      countbegin += 1;
      if (elem.WkDatePerform != null) {
        countPerform += 1;
      }
      if (elem.WkDateEnd != null) {
        countEnd += 1;
      }
    }
    return countbegin + '/' + countPerform + '/' + countEnd;
  }
  LoadDataPredPrep(mas) {
    this.RIDClass = mas['IDClass'];
    this.RClsName = mas['ClsName'];
    this.RIDPredmetSpis = mas['IDPredmetSpis'];
    this.RPdSpName = mas['PdSpName'];
    this.PrepIDUser = mas['IDUser'];
    this.PrepUserNameS = mas['UserNameS'];
  }
  LoadDataZagFromElem(elem) {
    this.RIDClass = elem.MyData.RIDClass;
    this.RClsName = elem.MyData.RClsName;
    this.RIDPredmetSpis = 0;
    this.RPdSpName = '';
    this.PrepIDUser = 0;
    this.PrepUserNameS = '';
  }

  Equalt(mas) {
    return this.RIDClass == drow['IDClass'] && this.RIDPredmetSpis == drow['IDPredmetSpis'] && this.RIDUser == drow['IDUser'];
  }
  ADDWork(mas) {
    let W = new PMyWork();
    W.IDWork = mas['IDWork'];
    W.WkZadanID = mas['WkZadanID'];
    W.WkDateBegin = StrToDate(mas['WkDateBegin']);
    W.WkDatePerform = StrToDate(mas['WkDatePerform']);
    W.WkDateEnd = StrToDate(mas['WkDateEnd']);
    W.WkGrade = mas['WkGrade'];
    this.SpisWork.push(W);
  }
}

function StrToDate(str) {
  if (str == null) {
    return null;
  }
  return new Date(str);
}
/*            Преобразование объекта даты в строку  */
function DateToStr(VDate) {
  let Str = '';
  if (VDate == null) {
    Str = '';
  } else {
    Str = String(VDate.getDate()).replace(/^(.)$/, '0$1') + '.' + String(VDate.getMonth() + 1).replace(/^(.)$/, '0$1') + '.' + VDate.getFullYear();
  }
  return Str;
}
function ObjToStr(VObj) {
  if (typeof VObj == 'string') {
    return VObj;
  } else {
    return '';
  }
}


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


/*            Константы для типа загурзки  */
const LoadWorkFull = 'LWFu';
const LoadWorkExecute = 'LWEx';

/*module.exports = { POtvet, PVopros, PMyWork };*/
